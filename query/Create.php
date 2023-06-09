<?php

namespace AdvancedSQL\query;

/**
 * Create class
 */
class Create extends Query
{

    /**
     * @var array
     */
    private array $columns = [];

    /**
     * @var array
     */
    private array $types = [];

    /**
     * Set a column that you want to add.
     *
     * @param string $column
     * @param mixed $value
     * @return Create
     */
    public function setColumn(string $column, mixed $value): Create
    {
        $this->columns[] = $column;

        $this->types[] = $value;

        return $this;
    }

    /**
     * Set a column that you want to add.
     *
     * @param string $column
     * @param mixed $value
     * @return Create
     */
    public function column(string $column, mixed $value): Create
    {
        $this->setColumn($column, $value);

        return $this;
    }

    /**
     * Set the columns that you want to add by array.
     *
     * @param array $columns
     * @return Create
     */
    public function setColumnsByArray(array $columns): Create
    {
        foreach ($columns as $key => $value) $this->setColumn($key, $value);

        return $this;
    }

    /**
     * Set the columns that you want to add by array.
     *
     * @param array $columns
     * @return Create
     */
    public function columns(array $columns): Create
    {
        $this->setColumnsByArray($columns);

        return $this;
    }

    /**
     * Create a column named "id" as primary key with auto increment.
     *
     * @return Create
     */
    public function id(): Create
    {
        return $this->setColumn("id", "int(11) PRIMARY KEY AUTO_INCREMENT");
    }

    /**
     * Set the columns that you want to add by array.
     *
     * @param array $columns
     * @return Create
     */
    public function setColumns(array $columns): Create
    {
        $this->setColumnsByArray($columns);

        return $this;
    }

    /**
     * Convert object to query.
     *
     * @return string
     */
    public function toQuery(): string
    {
        $query = "CREATE TABLE IF NOT EXISTS $this->table ( ";

        for ($i = 0; $i < count($this->columns); $i++) {
            $query .= $i != (count($this->columns) - 1) ? "{$this->columns[$i]} {$this->types[$i]}, " : "{$this->columns[$i]} {$this->types[$i]} ";
        }

        $query .= ")";

        return $query;
    }
}
