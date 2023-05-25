<?php

namespace AdvancedSQL\query\join;

use AdvancedSQL\query\IQuery;
use PDOStatement;

/**
 * IJoin class
 */
interface IJoin
{

    public function on(string $conditional): IJoin;

    public function as(string $alias): IJoin;

    public function using(array $columns): IJoin;

    public function join(): IJoin;

    public function leftJoin(string $table): IJoin;

    public function innerJoin(string $table): IJoin;

    public function rightJoin(string $table): IJoin;

    public function fullJoin(string $table): IJoin;

    public function where(string $where, $execute = []): IQuery;

    public function execute(): PDOStatement;

    public function getPrefix(): string;

    public function toQuery(): string;
}