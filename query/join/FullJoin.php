<?php

namespace AdvancedSQL\query\join;

/**
 * FullJoin class
 */
class FullJoin extends Join
{

    public function getPrefix(): string
    {
        return "FULL JOIN";
    }
}
