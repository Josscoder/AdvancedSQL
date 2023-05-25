<?php

namespace AdvancedSQL;

use AdvancedSQL\query\AddColumns;
use AdvancedSQL\query\Create;
use AdvancedSQL\query\Delete;
use AdvancedSQL\query\Drop;
use AdvancedSQL\query\DropColumns;
use AdvancedSQL\query\Insert;
use AdvancedSQL\query\ModifyColumns;
use AdvancedSQL\query\Query;
use AdvancedSQL\query\Select;
use AdvancedSQL\query\ShowColumns;
use AdvancedSQL\query\Truncate;
use AdvancedSQL\query\Update;
use AdvancedSQL\table\ITable;
use AdvancedSQL\table\Table;
use PDO;
use PDOStatement;

/**
 * SQL abstract class
 */
abstract class SQL implements ISQL
{

    /**
     * @var ?PDO
     */
    protected ?PDO $connection = null;

    /**
     * @var boolean
     */
    protected bool $connected = false;

    /**
     * @var PDOStatement
     */
    protected PDOStatement $lastStatement;

    /**
     * @return void
     */
    abstract public function run(): void;

    /**
     * Set the table to which you want to make a query.
     *
     * @param string $table
     * @return ITable
     */
    public function table(string $table): ITable
    {
        return new Table($this, $table);
    }

    /**
     * Get if the SQL instance is connected.
     *
     * @return boolean
     */
    public function isConnected(): bool
    {
        return $this->connected;
    }

    /**
     * Generate a select query.
     * Recommendation: Use $sql->table("table")->select(); instead.
     *
     * @param string|null $table
     * @return Select
     */
    public function select(?string $table = null): Select
    {
        return (new Select($this->table($table)));
    }

    /**
     * Generate an insert query.
     * Recommendation: Use $sql->table("table")->insert(); instead.
     *
     * @param string|null $table
     * @return Insert
     */
    public function insert(?string $table = null): Insert
    {
        return (new Insert($this->table($table)));
    }

    /**
     * Generate an update query.
     * Recommendation: Use $sql->table("table")->update(); instead.
     *
     * @param string|null $table
     * @return Update
     */
    public function update(?string $table = null): Update
    {
        return (new Update($this->table($table)));
    }

    /**
     * Generate a delete query.
     * Recommendation: Use $sql->table("table")->delete(); instead.
     *
     * @param string|null $table
     * @return Delete
     */
    public function delete(?string $table = null): Delete
    {
        return (new Delete($this->table($table)));
    }

    /**
     * Generate a create query.
     * Recommendation: Use $sql->table("table")->create(); instead.
     *
     * @param string|null $table
     * @return Create
     */
    public function create(?string $table = null): Create
    {
        return (new Create($this->table($table)));
    }

    /**
     * Generate a drop query.
     * Recommendation: Use $sql->table("table")->drop(); instead.
     *
     * @param string|null $table
     * @return Drop
     */
    public function drop(?string $table = null): Drop
    {
        return (new Drop($this->table($table)));
    }

    /**
     * Generate a query to show table columns.
     * Recommendation: Use $sql->table("table")->showColumns(); instead.
     *
     * @param string|null $table
     * @return ShowColumns
     */
    public function showColumns(?string $table = null): ShowColumns
    {
        return (new ShowColumns($this->table($table)));
    }

    /**
     * Generate a query to add columns into a table.
     * Recommendation: Use $sql->table("table")->addColumns(); instead.
     *
     * @param string|null $table
     * @return AddColumns
     */
    public function addColumns(?string $table = null): AddColumns
    {
        return (new AddColumns($this->table($table)));
    }

    /**
     * Generate a query to modify columns from a table.
     * Recommendation: Use $sql->table("table")->modifyColumns(); instead.
     *
     * @param string|null $table
     * @return ModifyColumns
     */
    public function modifyColumns(?string $table = null): ModifyColumns
    {
        return (new ModifyColumns($this->table($table)));
    }

    /**
     * Generate a query to drop columns from a table.
     * Recommendation: Use $sql->table("table")->dropColumns(); instead.
     *
     * @param string|null $table
     * @return DropColumns
     */
    public function dropColumns(?string $table = null): DropColumns
    {
        return (new DropColumns($this->table($table)));
    }

    /**
     * Generate a query to truncate a table.
     * Recommendation: Use $sql->table("table")->truncate(); instead.
     *
     * @param string|null $table
     * @return Truncate
     */
    public function truncate(?string $table = null): Truncate
    {
        return (new Truncate($this->table($table)));
    }

    /**
     * Prepare the query.
     *
     * @param Query $query
     * @return PDOStatement
     */
    public function prepare(Query $query): PDOStatement
    {
        return $this->connection->prepare((string)$query);
    }

    /**
     * Set last statement.
     *
     * @param PDOStatement $statement
     * @return void
     */
    public function setLastStatement(PDOStatement $statement): void
    {
        $this->lastStatement = $statement;
    }

    /**
     * Get last executed prepared statement.
     *
     * @return PDOStatement|null
     */
    public function getLastStatement(): ?PDOStatement
    {
        return $this->lastStatement;
    }

    /**
     * Get last query error.
     *
     * @return string
     */
    public function getLastError(): string
    {
        return $this->getLastStatement()->errorInfo()[2];
    }

    /**
     * Get PDO object.
     *
     * @return PDO
     */
    public function getPDO(): PDO
    {
        return $this->connection;
    }
}
