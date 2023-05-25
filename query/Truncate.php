<?php

namespace AdvancedSQL\query;

/**
 * Truncate class
 */
class Truncate extends Query
{

    /**
     * Generate the query string of the object.
     *
     * @return string
     */
    public function toQuery(): string
    {
        return "TRUNCATE TABLE $this->table";
    }
}
