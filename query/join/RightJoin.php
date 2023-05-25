<?php

namespace AdvancedSQL\query\join;

/**
 * RightJoin class
 */
class RightJoin extends Join
{

    public function getPrefix(): string
    {
        return "RIGHT JOIN";
    }
}
