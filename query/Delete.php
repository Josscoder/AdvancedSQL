<?php

namespace AdvancedSQL\query;

/**
 * Update class
 */
class Delete extends Query
{

    /**
     * Set the LIMIT attribute to the SQL query.
     *
     * @param int $limit
     * @return Delete
     */
    public function setLimit(int $limit): IQuery
    {
        return parent::setLimit($limit);
    }

    /**
     * Set the LIMIT attribute to the SQL query.
     *
     * @param int $limit
     * @return Delete
     */
    public function limit(int $limit): IQuery
    {
        return parent::limit($limit);
    }

    /**
     * Set the WHERE SQL parameter.
     *
     * @param string $where Set where example: "name = ?" or "name = ? AND last = ?".
     * @param array $execute Set values example "Denzel" or ["Denzel", "Code"].
     * @return Delete
     */
    public function where(string $where, array $execute = []): IQuery
    {
        return parent::where($where, $execute);
    }

    /**
     * Convert object to query.
     *
     * @return string
     */
    public function toQuery(): string
    {
        $query = "DELETE FROM $this->table";

        $query .= !empty($this->where) ? " WHERE $this->where" : "";

        $query .= $this->limit > 0 ? " LIMIT $this->limit" : "";

        return $query;
    }
}
