<?php

namespace AdvancedSQL\query;

/**
 * AddColumns class
 */
class AddColumns extends Query
{

    /**
     * @var array
     */
    private array $columns = [];

    /**
     * @var array
     */
    private array $values = [];

    /**
     * Set a column that you want to add.
     *
     * @param string $column
     * @param string $value
     * @return AddColumns
     */
    public function setColumn(string $column, string $value): AddColumns
    {
        $this->columns[] = $column;

        $this->values[] = $value;

        return $this;
    }

    /**
     * Set a column that you want to add.
     *
     * @param string $column
     * @param string $value
     * @return AddColumns
     */
    public function column(string $column, string $value): AddColumns
    {
        $this->setColumn($column, $value);

        return $this;
    }

    /**
     * Set the columns that you want to add by array.
     *
     * @param array $data
     * @return AddColumns
     */
    public function setColumnsByArray(array $data): AddColumns
    {
        foreach ($data as $key => $value) $this->setColumn($key, $value);

        return $this;
    }

    /**
     * Set the columns that you want to add by array.
     *
     * @param array $columns
     * @return AddColumns
     */
    public function columns(array $columns): AddColumns
    {
        $this->setColumnsByArray($columns);

        return $this;
    }

    /**
     * Set the columns that you want to add by array.
     *
     * @param array $data
     * @return AddColumns
     */
    public function setColumns(array $data): AddColumns
    {
        $this->setColumnsByArray($data);

        return $this;
    }

    /**
     * Execute the query.
     *
     * @return boolean
     */
    public function execute(): bool
    {
        $this->execute = array_merge($this->values, $this->execute);

        return parent::execute();
    }

    /**
     * Convert object to query.
     *
     * @return string
     */
    public function toQuery(): string
    {
        $query = "ALTER TABLE $this->table";

        for ($i = 0; $i < count($this->columns); $i++) {
            $query .= $i != (count($this->columns) == 1) ? " ADD COLUMN {$this->columns[$i]} {$this->values[$i]};" : ($i == 0 ? " ADD COLUMN {$this->columns[$i]} {$this->values[$i]}, " : ($i != (count($this->columns) != 1) ? "ADD COLUMN {$this->columns[$i]} {$this->values[$i]}, " : "ADD COLUMN {$this->columns[$i]} {$this->values[$i]};"));
        }

        return $query;
    }
}
