<?php

namespace AdvancedSQL\query;

/**
 * DropColumns class
 */
class DropColumns extends Query
{

    private array $columns = [];

    /**
     * Set a column that you want to drop by string.
     *
     * @param string $column
     * @return DropColumns
     */
    public function setColumn(string $column): DropColumns
    {
        $this->columns[] = $column;

        return $this;
    }

    /**
     * Set a column that you want to drop by string.
     *
     * @param string $column
     * @return DropColumns
     */
    public function column(string $column): DropColumns
    {
        $this->setColumn($column);

        return $this;
    }

    /**
     * Set the columns list that you want to drop by array.
     *
     * @param array $columns
     * @return DropColumns
     */
    public function setColumnsByArray(array $columns): DropColumns
    {
        foreach ($columns as $key => $value) $this->setColumn($key, $value);

        return $this;
    }

    /**
     * Set the columns list that you want to drop by array.
     *
     * @param array $columns
     * @return DropColumns
     */
    public function columns(array $columns): DropColumns
    {
        $this->setColumnsByArray($columns);

        return $this;
    }

    /**
     * Set the columns list that you want to drop by array.
     *
     * @param array $columns
     * @return DropColumns
     */
    public function setColumns(array $columns): DropColumns
    {
        $this->setColumnsByArray($columns);

        return $this;
    }

    /**
     * Execute the query
     *
     * @return boolean
     */
    public function execute(): bool
    {
        $this->execute = $this->columns;

        return parent::execute();
    }

    /**
     * Generate the query string of the object
     *
     * @return string
     */
    public function toQuery(): string
    {
        $query = "ALTER TABLE $this->table";

        for ($i = 0; $i < count($this->columns); $i++) {
            $query .= $i != (count($this->columns) == 1) ? " DROP COLUMN {$this->columns[$i]};" : ($i == 0 ? " DROP COLUMN {$this->columns[$i]}, " : ($i != (count($this->columns) != 1) ? "DROP COLUMN {$this->columns[$i]}, " : "DROP COLUMN {$this->columns[$i]};"));
        }

        return $query;
    }
}
