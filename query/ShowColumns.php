<?php

namespace AdvancedSQL\query;

use PDOStatement;

/**
 * ShowColumns class
 */
class ShowColumns extends Query
{

    /**
     * @var string|null
     */
    private ?string $like = null;

    /**
     * Execute the Query and return an PDOStatement Object so you can fetch results.
     *
     * @return PDOStatement
     */
    public function execute(): PDOStatement
    {
        parent::execute();

        return $this->prepare;
    }

    /**
     * Fetch all the results.
     *
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->execute()->fetchAll();
    }

    /**
     * Fetch the first result false if is a bad query.
     *
     * @return array
     */
    public function fetch(): array
    {
        return ($this->execute()->fetch() ?? []);
    }

    /**
     * @param string $like
     * @return ShowColumns
     */
    public function like(string $like): ShowColumns
    {
        $this->like = $like;

        $this->execute[] = $like;

        return $this;
    }

    /**
     * Generate the query string of the object.
     *
     * @return string
     */
    public function toQuery(): string
    {
        $query = "SHOW COLUMNS FROM $this->table";

        $query .= !empty($this->like) ? "LIKE ?" : "";

        return $query;
    }
}
