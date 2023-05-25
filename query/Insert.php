<?php

namespace AdvancedSQL\query;

/**
 * Insert class
 */
class Insert extends Query
{

    /**
     * @var array
     */
    private array $fields = [];

    /**
     * @var array
     */
    private array $values = [];

    /**
     * Set the column name and the value that you want to assign to the row.
     *
     * @param string $field
     * @param mixed $value
     * @return Insert
     */
    public function setField(string $field, mixed $value): Insert
    {
        $this->fields[] = $field;

        $this->values[] = $value;

        $this->execute[] = $value;

        return $this;
    }

    /**
     * Set the column name and the value that you want to assign to the row.
     *
     * @param string $field
     * @param mixed $value
     * @return Insert
     */
    public function field(string $field, mixed $value): Insert
    {
        return $this->setField($field, $value);
    }

    /**
     * Set the column name and the value that you want to assign to the row by array.
     *
     * @param array $fields
     * @return Insert
     */
    public function setFieldsByArray(array $fields): Insert
    {
        foreach ($fields as $key => $value) $this->setField($key, $value);

        return $this;
    }

    /**
     * Set the column name and the value that you want to assign to the row by array.
     *
     * @param array $fields
     * @return Insert
     */
    public function fields(array $fields): Insert
    {
        return $this->setFieldsByArray($fields);
    }

    /**
     * Set the column name and the value that you want to assign to the row by array.
     *
     * @param array $fields
     * @return Insert
     */
    public function setFields(array $fields): Insert
    {
        return $this->setFieldsByArray($fields);
    }

    /**
     * Generate the query string of the object.
     *
     * @return string
     */
    public function toQuery(): string
    {
        $query = "INSERT INTO $this->table (";

        foreach ($this->fields as $i => $field) $query .= $i != (count($this->fields) - 1) ? "$field, " : $field;

        $query .= ") VALUES (";

        for ($i = 0; $i < count($this->values); $i++) $query .= $i != (count($this->values) - 1) ? "?, " : "?";

        $query .= ")";

        return $query;
    }
}
