<?php

namespace AdvancedSQL\query;

use AdvancedSQL\ISQL;
use AdvancedSQL\table\ITable;
use PDOStatement;

/**
 * Query class
 */
abstract class Query implements IQuery
{

    /**
     * @var ?ISQL
     */
    protected ?ISQL $sql = null;

    /**
     * @var ?ITable
     */
    protected ?ITable $table = null;

    /**
     * @var array
     */
    protected array $execute = [];

    /**
     * @var ?PDOStatement
     */
    protected ?PDOStatement $prepare = null;

    /**
     * @var ?string
     */
    protected ?string $where = null;

    /**
     * @var int
     */
    protected int $limit = 0;

    /**
     * @param ITable|null $table
     */
    public function __construct(ITable $table = null)
    {
        $this->sql = $table->getSQL();

        $this->table = $table;
    }

    /**
     * Set the LIMIT attribute to the SQL query.
     *
     * @param int $limit
     * @return IQuery
     */
    public function setLimit(int $limit): IQuery
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Set the LIMIT attribute to the SQL query.
     *
     * @param int $limit
     * @return IQuery
     */
    public function limit(int $limit): IQuery
    {
        return $this->setLimit($limit);
    }

    /**
     * Get the table that you want to modify.
     *
     * @return ITable|null
     */
    public function getTable(): ?ITable
    {
        return $this->table;
    }

    /**
     * Set the WHERE SQL parameter.
     *
     * @param string $where Set where example: "name = ?" or "name = ? AND last = ?".
     * @param array $execute Set values example "Denzel" or ["Denzel", "Code"].
     * @return IQuery
     */
    public function where(string $where, array $execute = []): IQuery
    {
        $this->where = $where;

        if (is_array($execute)) $this->execute = $execute; else $this->execute[] = $execute;

        return $this;
    }

    /**
     * Execute the query.
     *
     * @return boolean
     */
    public function execute(): mixed
    {
        $prepare = $this->sql->prepare($this);

        $this->sql->setLastStatement($prepare);

        $this->prepare = $prepare;

        return $prepare->execute($this->execute);
    }

    /**
     * @return PDOStatement|null
     */
    public function getPrepare(): ?PDOStatement
    {
        return $this->prepare;
    }

    /**
     * Get error string if there is a problem with the Query.
     *
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->prepare = null || empty($this->prepare->errorInfo()[2]) ? null : $this->prepare->errorInfo()[2];
    }

    /**
     * Generate the query string of the object.
     *
     * @return string
     */
    public abstract function toQuery(): string;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toQuery();
    }
}
