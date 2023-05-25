<?php

namespace AdvancedSQL\query\join;

/**
 * InnerJoin class
 */
class InnerJoin extends Join
{

    public function getPrefix(): string
    {
        return "INNER JOIN";
    }
}
