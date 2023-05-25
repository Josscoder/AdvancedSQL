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

/**
 * ISQL interface
 */
interface ITable
{
    public function getName(): string;

    public function getSQL(): ISQL;

    public function exists(): bool;

    public function select(): Select;

    public function insert(): Insert;

    public function update(): Update;

    public function delete(): Delete;

    public function create(): Create;

    public function truncate(): Truncate;

    public function drop(): Drop;

    public function showColumns(): ShowColumns;

    public function addColumns(): AddColumns;

    public function modifyColumns(): ModifyColumns;

    public function dropColumns(): DropColumns;
}