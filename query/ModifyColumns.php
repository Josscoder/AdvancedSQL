<?php

namespace AdvancedSQL\query;

/**
 * ModifyColumns class
 */
class ModifyColumns extends Query
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
     * Set a column that you want to modify.
     *
     * @param string $column
     * @param string $value
     * @return ModifyColumns
     */
    public function setColumn(string $column, string $value): ModifyColumns
    {
        $this->columns[] = $column;

        $this->values[] = $value;

        return $this;
    }

    /**
     * Set a column that you want to modify.
     *
     * @param string $column
     * @param string $value
     * @return ModifyColumns
     */
    public function column(string $column, string $value): ModifyColumns
    {
        $this->setColumn($column, $value);

        return $this;
    }

    /**
     * Set the columns that you want to modify by array.
     *
     * @param array $data
     * @return ModifyColumns
     */
    public function setColumnsByArray(array $data): ModifyColumns
    {
        foreach ($data as $key => $value) {
            $this->setColumn($key, $value);
        }

        return $this;
    }

    /**
     * Set the columns that you want to modify by array.
     *
     * @param array $columns
     * @return ModifyColumns
     */
    public function columns(array $columns): ModifyColumns
    {
        $this->setColumnsByArray($columns);

        return $this;
    }

    /**
     * Set the columns that you want to modify by array.
     *
     * @param array $data
     * @return ModifyColumns
     */
    public function setColumns(array $data): ModifyColumns
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
            $query .= $i != (count($this->columns) == 1) ? " MODIFY COLUMN {$this->columns[$i]} {$this->values[$i]};" : ($i == 0 ? " MODIFY COLUMN {$this->columns[$i]} {$this->values[$i]}, " : ($i != (count($this->columns) != 1) ? "MODIFY COLUMN {$this->columns[$i]} {$this->values[$i]}, " : "MODIFY COLUMN {$this->columns[$i]} {$this->values[$i]};"));
        }

        return $query;
    }
}
