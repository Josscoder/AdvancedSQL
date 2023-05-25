<?php

namespace AdvancedSQL\query;

/**
 * Drop class
 */
class Drop extends Query
{

    /**
     * Generate the query string of the object
     *
     * @return string
     */
    public function toQuery(): string
    {
        return "DROP TABLE $this->table";
    }
}
