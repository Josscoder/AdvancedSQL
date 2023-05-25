<?php

namespace AdvancedSQL\query\join;

/**
 * LeftJoin class
 */
class LeftJoin extends Join
{

    public function getPrefix(): string
    {
        return "LEFT JOIN";
    }
}
