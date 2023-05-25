<?php

namespace AdvancedSQL\table;

use AdvancedSQL\ISQL;
use AdvancedSQL\query\AddColumns;
use AdvancedSQL\query\Create;
use AdvancedSQL\query\Delete;
use AdvancedSQL\query\Drop;
use AdvancedSQL\query\DropColumns;
use AdvancedSQL\query\Insert;
use AdvancedSQL\query\ModifyColumns;
use AdvancedSQL\query\Select;
use AdvancedSQL\query\ShowColumns;
use AdvancedSQL\query\Truncate;
use AdvancedSQL\query\Update;

class Table implements ITable
{

    /**
     * @var string
     */
    private string $name;

    /**
     * @var ISQL
     */
    private ISQL $sql;

    public function __construct(ISQL $sql, string $name)
    {
        $this->sql = $sql;

        $this->name = $name;
    }

    /**
     * Get table name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get SQL instance.
     *
     * @return ISQL
     */
    public function getSQL(): ISQL
    {
        return $this->sql;
    }

    /**
     * Generate a select query.
     *
     * @return Select
     */
    public function select(): Select
    {
        return (new Select($this));
    }

    /**
     * Generate an insert query.
     *
     * @return Insert
     */
    public function insert(): Insert
    {
        return (new Insert($this));
    }

    /**
     * Generate an update query.
     *
     * @return Update
     */
    public function update(): Update
    {
        return (new Update($this));
    }

    /**
     * Generate a delete query.
     *
     * @return Delete
     */
    public function delete(): Delete
    {
        return (new Delete($this));
    }

    /**
     * Generate a create query.
     *
     * @return Create
     */
    public function create(): Create
    {
        return (new Create($this));
    }

    /**
     * Generate a drop query.
     *
     * @return Drop
     */
    public function drop(): Drop
    {
        return (new Drop($this));
    }

    /**
     * Generate a query to show table columns.
     *
     * @return ShowColumns
     */
    public function showColumns(): ShowColumns
    {
        return (new ShowColumns($this));
    }

    /**
     * Generate a query to add columns into a table.
     *
     * @return AddColumns
     */
    public function addColumns(): AddColumns
    {
        return (new AddColumns($this));
    }

    /**
     * Generate a query to modify columns from a table.
     *
     * @return ModifyColumns
     */
    public function modifyColumns(): ModifyColumns
    {
        return (new ModifyColumns($this));
    }

    /**
     * Generate a query to drop columns from a table.
     *
     * @return DropColumns
     */
    public function dropColumns(): DropColumns
    {
        return (new DropColumns($this));
    }

    /**
     * Generate a query to truncate a table.
     *
     * @return Truncate
     */
    public function truncate(): Truncate
    {
        return (new Truncate($this));
    }

    /**
     * Check if the table exists.
     *
     * @return boolean
     */
    public function exists(): bool
    {
        return $this->select()->executeBool();
    }

    public function __toString()
    {
        return $this->name;
    }
}