<?php

namespace AdvancedSQL\query;

use AdvancedSQL\query\join\FullJoin;
use AdvancedSQL\query\join\IJoin;
use AdvancedSQL\query\join\InnerJoin;
use AdvancedSQL\query\join\Join;
use AdvancedSQL\query\join\LeftJoin;
use AdvancedSQL\query\join\RightJoin;
use PDOStatement;

/**
 * Select class
 */
class Select extends Query{

    /**
     * @var array
     */
    private array $columns = ["*"];

    /**
     * @var string|null
     */
    private ?string $distinct = null;

    /**
     * @var Join[]
     */
    private array $joins = [];

    /**
     * @var ?string
     */
    private ?string $order = null;

    /**
     * Set the ORDER BY attribute to the SQL query.
     *
     * @param string|null $by
     * @return Select
     */
    public function orderBy(?string $by) : Select {
        $this->order = $by;

        return $this;
    }

    /**
     * Set the LIMIT attribute to the SQL query.
     *
     * @param int $limit
     * @return Select
     */
    public function setLimit(int $limit) : IQuery {
        return parent::setLimit($limit);
    }

    /**
     * Set the LIMIT attribute to the SQL query.
     *
     * @param int $limit
     * @return Select
     */
    public function limit(int $limit) : IQuery {
        return parent::limit($limit);
    }

    /**
     * Set the WHERE SQL parameter.
     *
     * @param string $where Set where example: "name = ?" or "name = ? AND last = ?".
     * @param array $execute Set values example "Denzel" or ["Denzel", "Code"].
     * @return Select
     */
    public function where(string $where, array $execute = []) : IQuery {
        return parent::where($where, $execute);
    }

    /**
     * Set the list of columns that tou want to select by array
     *
     * @param array $columns
     * @return Select
     */
    public function setColumns(array $columns = ["*"]) : Select {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Set the list of columns that tou want to select by array
     *
     * @param array $columns
     * @return Select
     */
    public function columns(array $columns = ["*"]) : Select {
        return $this->setColumns($columns);
    }

    /**
     * Select distinct value
     *
     * @param string|null $column
     * @return Select
     */
    public function distinct(string $column = null) : Select {
        $this->distinct = $column;

        return $this;
    }

    /**
     * Join table.
     *
     * @param string $table
     * @return Join
     */
    public function join(string $table) : IJoin {
        return ($this->joins[] = new Join($this, $table));
    }

    /**
     * Left join table.
     *
     * @param string $table
     * @return LeftJoin
     */
    public function leftJoin(string $table) : IJoin {
        return ($this->joins[] = new LeftJoin($this, $table));
    }

    /**
     * Inner join table.
     *
     * @param string $table
     * @return InnerJoin
     */
    public function innerJoin(string $table) : IJoin {
        return ($this->joins[] = new InnerJoin($this, $table));
    }

    /**
     * Right join table.
     *
     * @param string $table
     * @return RightJoin
     */
    public function rightJoin(string $table) : IJoin {
        return ($this->joins[] = new RightJoin($this, $table));
    }

    /**
     * Full join table.
     *
     * @param string $table
     * @return FullJoin
     */
    public function fullJoin(string $table) : IJoin {
        return ($this->joins[] = new FullJoin($this, $table));
    }

    /**
     * Fetch all the results.
     *
     * @return array
     */
    public function fetchAll() : array {
        return $this->execute()->fetchAll();
    }

    /**
     * Fetch the first result false if is a bad query.
     *
     * @return array
     */
    public function fetch() : array {
        $data = $this->execute()->fetch();

        return !$data ? [] : $data;
    }

    /**
     * Execute the Query and return an PDOStatement Object so you can fetch results.
     *
     * @return PDOStatement
     */
    public function execute(): PDOStatement {
        parent::execute();

        return $this->prepare;
    }

    /**
     * Execute the query.
     *
     * @return bool
     */
    public function executeBool(): bool
    {
        return parent::execute();
    }

    /**
    * Generate the query string of the object
    *
    * @return string
    */
    public function toQuery() : string {
        $query = "SELECT " . (!empty($this->distinct) ? "DISTINCT $this->distinct " : "");

        $query .= join(", ", $this->columns);

        $query .= !empty($this->table) ? " FROM $this->table" : "";

        foreach ($this->joins as $join) $query .= " " . $join->toQuery();

        $query .= !empty($this->where) ? " WHERE $this->where" : "";

        $query .= !empty($this->order) ? " ORDER BY $this->order" : "";

        $query .= $this->limit > 0 ? " LIMIT $this->limit" : "";

        return $query;
    }
}
