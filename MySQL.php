<?php

namespace AdvancedSQL;

use AdvancedSQL\exception\SQLException;
use PDO;
use PDOException;

/**
 * MySQL class
 */
class MySQL extends SQL
{

    /**
     * @var string
     */
    private string $database;
    private string $password;
    private string $username;
    private string|int $port;
    private string $host;

    /**
     * @var MySQL
     */
    private static MySQL $instance;

    /**
     * Initialize MySQL Connection.
     *
     * @param string $host
     * @param integer $port
     * @param string $username
     * @param string $password
     * @param string $database
     * @throws SQLException
     */
    public function __construct(string $host = "127.0.0.1", int $port = 3306, string $username = "root", string $password = "", string $database = "testing")
    {
        if (!extension_loaded("pdo")) {
            throw new SQLException('PDO extension is required');
        }

        self::$instance = $this;

        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $this->run();
    }

    /**
     * @return void
     * @throws SQLException
     */
    public function run(): void
    {
        if (!is_null($this->connection)) {
            return;
        }

        try {
            $options = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];

            $this->connection = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->database", $this->username, $this->password);

            foreach ($options as $key => $value) {
                $this->connection->setAttribute($key, $value);
            }

            $this->connected = true;
        } catch (PDOException $e) {
            if ($e->getCode() == 1049) {
                try {
                    $temp = new PDO("mysql:host=$this->host;port=$this->port", $this->username, $this->password);

                    $temp->exec("CREATE DATABASE $this->database");

                    $temp = null;
                } catch (PDOException $exception) {
                    throw new SQLException(sprintf('Error establishing a mysql connection: %s' , $exception->getMessage()));
                }

                $this->run();

                return;
            }

            throw new SQLException(sprintf('Error establishing a mysql connection: %s' , $e->getMessage()));
        }
    }

    /**
     * @return MySQL
     */
    public function getInstance(): MySQL
    {
        return self::$instance;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return integer
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * Import tables (create tables) from a list of tables.
     *
     * @param array $import
     * @return void
     * @throws SQLException
     */
    public function import(array $import): void
    {
        foreach ($import as $table => $columns) {
            $table = $this->table($table);

            if (!$table->exists() && !$table->create()->columns($columns)->execute()) {
                throw new SQLException(sprintf('Error trying to create a table: %s', $this->getLastError()));
            }
        }
    }

    /**
     * Modify/add columns into a list of tables.
     *
     * @param array $tables
     * @return void
     * @throws SQLException
     */
    public function modify(array $tables): void
    {
        foreach ($tables as $table => $modifiedColumns) {
            $table = $this->table($table);

            if (!$table->exists()) {
                throw new SQLException(sprintf('Error trying to modify a column: %s', $this->getLastError()));
            }

            $columns = [];

            foreach ($table->showColumns()->fetchAll() as $ignored) {
                $columns[] = $ignored["Field"];
            }

            foreach ($modifiedColumns as $column => $type) {
                $execute = in_array($column, $columns) ? $table->addColumns()->column($column, $type) : $table->modifyColumns()->column($column, $type);

                if (!$execute) {
                    throw new SQLException(sprintf('Error trying to modify a column: %s', $this->getLastError()));
                }
            }
        }
    }
}
