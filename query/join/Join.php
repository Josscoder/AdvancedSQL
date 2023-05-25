<?php

namespace AdvancedSQL\query\join;

use AdvancedSQL\query\IQuery;
use AdvancedSQL\query\Select;
use PDOStatement;

/**
 * Join class
 */
class Join implements IJoin
{

    /**
     * @var Select
     */
    protected Select $query;

    /**
     * @var string
     */
    protected string $table;

    /**
     * @var string
     */
    protected string $on;

    /**
     * @var string
     */
    protected string $as;

    /**
     * @var array
     */
    protected array $using = [];

    /**
     * Initialize join.
     *
     * @param Select $query
     * @param string $table
     */
    public function __construct(Select $query, string $table)
    {
        $this->query = $query;

        $this->table = $table;
    }

    /**
     * Add on argument to query.
     *
     * @param string $conditional
     * @return Join
     */
    public function on(string $conditional): Join
    {
        $this->on = $conditional;

        return $this;
    }

    /**
     * Add alias into the join table.
     *
     * @param string $alias
     * @return Join
     */
    public function as(string $alias): Join
    {
        $this->as = $alias;

        return $this;
    }

    /**
     * Add using argument into the using.
     *
     * @param array $columns
     * @return Join
     */
    public function using(array $columns): Join
    {
        $this->using = $columns;

        return $this;
    }

    /**
     * Join table.
     *
     * @param string $table
     * @return Join
     */
    public function join(string $table): IJoin
    {
        return $this->query->join($table);
    }

    /**
     * Left join table.
     *
     * @param string $table
     * @return LeftJoin
     */
    public function leftJoin(string $table): IJoin
    {
        return $this->query->leftJoin($table);
    }

    /**
     * Inner join table.
     *
     * @param string $table
     * @return InnerJoin
     */
    public function innerJoin(string $table): IJoin
    {
        return $this->query->innerJoin($table);
    }

    /**
     * Right join table.
     *
     * @param string $table
     * @return RightJoin
     */
    public function rightJoin(string $table): IJoin
    {
        return $this->query->rightJoin($table);
    }

    /**
     * Full join table.
     *
     * @param string $table
     * @return FullJoin
     */
    public function fullJoin(string $table): IJoin
    {
        return $this->query->fullJoin($table);
    }

    /**
     * Set the WHERE SQL parameter.
     *
     * @param string $where Set where example: "name = ?" or "name = ? AND last = ?".
     * @param mixed $execute Set values example "Denzel" or ["Denzel", "Code"].
     * @return IQuery
     */
    public function where(string $where, $execute = []): IQuery
    {
        return $this->query->where($where, $execute);
    }

    /**
     * Execute query and return PDOStatement.
     *
     * @return PDOStatement
     */
    public function execute(): PDOStatement
    {
        return $this->query->execute();
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return "JOIN";
    }

    /**
     * Convert Object to Query string.
     *
     * @return string
     */
    public function toQuery(): string
    {
        $query = "{$this->getPrefix()} $this->table";

        $query .= !empty($this->as) ? " AS ($this->as)" : "";

        $query .= !empty($this->on) ? " ON ($this->on)" : "";

        $query .= !empty($this->using) ? " USING (" . join(", ", $this->using) . ")" : "";

        return $query;
    }
}
