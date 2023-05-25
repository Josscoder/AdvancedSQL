<?php

namespace AdvancedSQL;

use AdvancedSQL\query\AddColumns;
use AdvancedSQL\query\Create;
use AdvancedSQL\query\Delete;
use AdvancedSQL\query\Drop;
use AdvancedSQL\query\DropColumns;
use AdvancedSQL\query\Insert;
use AdvancedSQL\query\ModifyColumns;
use AdvancedSQL\query\Query;
use AdvancedSQL\query\Select;
use AdvancedSQL\query\ShowColumns;
use AdvancedSQL\query\Truncate;
use AdvancedSQL\query\Update;
use AdvancedSQL\table\ITable;
use PDOStatement;

/**
 * ISQL interface
 */
interface ISQL
{

    public function isConnected(): bool;

    public function table(string $table): ITable;

    public function select(?string $table = null): Select;

    public function insert(?string $table = null): Insert;

    public function update(?string $table = null): Update;

    public function delete(?string $table = null): Delete;

    public function create(?string $table = null): Create;

    public function truncate(?string $table = null): Truncate;

    public function drop(?string $table = null): Drop;

    public function showColumns(?string $table = null): ShowColumns;

    public function addColumns(?string $table = null): AddColumns;

    public function modifyColumns(?string $table = null): ModifyColumns;

    public function dropColumns(?string $table = null): DropColumns;

    public function prepare(Query $query): PDOStatement;

    public function setLastStatement(PDOStatement $statement): void;

    public function getLastStatement(): ?PDOStatement;

    public function getLastError(): string;

    public function import(array $import): void;

    public function modify(array $tables): void;
}
