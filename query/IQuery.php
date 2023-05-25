<?php

namespace AdvancedSQL\query;

use AdvancedSQL\table\ITable;

/**
 * IQuery class
 */
interface IQuery
{

    public function getTable(): ?ITable;

    /**
     * Add WHERE parameter to the query.
     *
     * @param string $where
     * @param array $execute
     * @return IQuery
     */
    public function where(string $where, array $execute = []): IQuery;

    public function toQuery(): string;

    /**
     * Execute the query.
     *
     * @return boolean
     */
    public function execute(): mixed;

    /**
     * Get error string if there is a problem with the Query.
     *
     * @return string|null
     */
    public function getError(): ?string;
}
