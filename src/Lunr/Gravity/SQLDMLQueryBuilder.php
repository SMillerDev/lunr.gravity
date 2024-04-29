<?php

/**
 * Base SQL database query builder class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity;

/**
 * This is a SQL query builder class for generating queries
 * suitable for common SQL queries.
 */
abstract class SQLDMLQueryBuilder extends DatabaseDMLQueryBuilder
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Define a DELETE clause.
     *
     * @param string $table_references The tables to delete from
     *
     * @return $this Self reference
     */
    public function delete($table_references = ''): static
    {
        $this->sql_delete($table_references);
        return $this;
    }

    /**
     * Define INTO clause of the SQL statement.
     *
     * @param string $table Table reference
     *
     * @return $this Self reference
     */
    public function into($table): static
    {
        $this->sql_into($table);
        return $this;
    }

    /**
     * Define a Select statement for Insert statement.
     *
     * @param string $select SQL Select statement to be used in Insert
     *
     * @return $this Self reference
     */
    public function select_statement($select): static
    {
        $this->sql_select_statement($select);
        return $this;
    }

    /**
     * Define SET clause of the SQL statement.
     *
     * @param array $set Array containing escaped key->value pairs to be set
     *
     * @return $this Self reference
     */
    public function set($set): static
    {
        $this->sql_set($set);
        return $this;
    }

    /**
     * Define Column names of the affected by Insert or Update SQL statement.
     *
     * @param array $keys Array containing escaped field names to be set
     *
     * @return $this Self reference
     */
    public function column_names($keys): static
    {
        $this->sql_column_names($keys);
        return $this;
    }

    /**
     * Define Values for Insert or Update SQL statement.
     *
     * @param array $values Array containing escaped values to be set
     *
     * @return $this Self reference
     */
    public function values($values): static
    {
        $this->sql_values($values);
        return $this;
    }

    /**
     * Define a SELECT clause.
     *
     * @param string|null $select The column(s) to select
     *
     * @return $this Self reference
     */
    public function select($select): static
    {
        $this->sql_select($select);
        return $this;
    }

    /**
     * Define a UPDATE clause.
     *
     * @param string $table_references The tables to update
     *
     * @return $this Self reference
     */
    public function update($table_references): static
    {
        $this->sql_update($table_references);
        return $this;
    }

    /**
     * Define FROM clause of the SQL statement.
     *
     * @param string $table_reference Table reference
     * @param array  $index_hints     Array of Index Hints
     *
     * @return $this Self reference
     */
    public function from($table_reference, $index_hints = NULL): static
    {
        $this->sql_from($table_reference, $index_hints);
        return $this;
    }

    /**
     * Define JOIN clause of the SQL statement.
     *
     * @param string $table_reference Table reference
     * @param string $type            Type of JOIN operation to perform.
     * @param array  $index_hints     Array of Index Hints
     *
     * @return $this Self reference
     */
    public function join($table_reference, $type = 'INNER', $index_hints = NULL): static
    {
        $this->sql_join($table_reference, $type, $index_hints);
        return $this;
    }

    /**
     * Define USING part of the SQL statement.
     *
     * @param string $column_list Column name to use.
     *
     * @return $this Self reference
     */
    public function using($column_list): static
    {
        $this->sql_using($column_list);
        return $this;
    }

    /**
     * Define ON part of a JOIN clause of the SQL statement.
     *
     * @param string $left     Left expression
     * @param string $right    Right expression
     * @param string $operator Comparison operator
     *
     * @return $this Self reference
     */
    public function on($left, $right, $operator = '='): static
    {
        $this->sql_condition($left, $right, $operator, 'ON');
        return $this;
    }

    /**
     * Define ON part of a JOIN clause with LIKE comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param bool   $negate Whether to negate the comparison or not
     *
     * @return $this Self reference
     */
    public function on_like($left, $right, $negate = FALSE): static
    {
        $operator = ($negate === FALSE) ? 'LIKE' : 'NOT LIKE';
        $this->sql_condition($left, $right, $operator, 'ON');
        return $this;
    }

    /**
     * Define ON part of a JOIN clause with IN comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param bool   $negate Whether to negate the comparison or not
     *
     * @return $this Self reference
     */
    public function on_in(string $left, string $right, bool $negate = FALSE): static
    {
        $operator = ($negate === FALSE) ? 'IN' : 'NOT IN';
        $this->sql_condition($left, $right, $operator, 'ON');
        return $this;
    }

    /**
     * Define ON part of a JOIN clause with BETWEEN comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $lower  The lower bound of the between condition
     * @param string $upper  The upper bound of the between condition
     * @param bool   $negate Whether to negate the comparison or not
     *
     * @return $this Self reference
     */
    public function on_between($left, $lower, $upper, $negate = FALSE): static
    {
        $right    = $lower . ' AND ' . $upper;
        $operator = ($negate === FALSE) ? 'BETWEEN' : 'NOT BETWEEN';
        $this->sql_condition($left, $right, $operator, 'ON');
        return $this;
    }

    /**
     * Define ON part of a JOIN clause with the NULL condition.
     *
     * @param string $left   Left expression
     * @param bool   $negate Whether to negate the condition or not
     *
     * @return $this Self reference
     */
    public function on_null($left, $negate = FALSE): static
    {
        $operator = ($negate === FALSE) ? 'IS' : 'IS NOT';
        $this->sql_condition($left, 'NULL', $operator, 'ON');
        return $this;
    }

    /**
     * Open ON group.
     *
     * @return $this Self reference
     */
    public function start_on_group(): static
    {
        $this->sql_group_start('ON');
        return $this;
    }

    /**
     * Close ON group.
     *
     * @return $this Self reference
     */
    public function end_on_group(): static
    {
        $this->sql_group_end('ON');
        return $this;
    }

    /**
     * Define WHERE clause of the SQL statement.
     *
     * @param string $left     Left expression
     * @param string $right    Right expression
     * @param string $operator Comparison operator
     *
     * @return $this Self reference
     */
    public function where($left, $right, $operator = '='): static
    {
        $this->sql_condition($left, $right, $operator);
        return $this;
    }

    /**
     * Define WHERE clause with LIKE comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param bool   $negate Whether to negate the comparison or not
     *
     * @return $this Self reference
     */
    public function where_like($left, $right, $negate = FALSE): static
    {
        $operator = ($negate === FALSE) ? 'LIKE' : 'NOT LIKE';
        $this->sql_condition($left, $right, $operator);
        return $this;
    }

    /**
     * Define WHERE clause with the IN condition of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param bool   $negate Whether to negate the condition or not
     *
     * @return $this Self reference
     */
    public function where_in(string $left, string $right, bool $negate = FALSE): static
    {
        $operator = ($negate === FALSE) ? 'IN' : 'NOT IN';
        $this->sql_condition($left, $right, $operator);
        return $this;
    }

    /**
     * Define WHERE clause with the BETWEEN condition of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $lower  The lower bound of the between condition
     * @param string $upper  The upper bound of the between condition
     * @param bool   $negate Whether to negate the condition or not
     *
     * @return $this Self reference
     */
    public function where_between($left, $lower, $upper, $negate = FALSE): static
    {
        $right    = $lower . ' AND ' . $upper;
        $operator = ($negate === FALSE) ? 'BETWEEN' : 'NOT BETWEEN';
        $this->sql_condition($left, $right, $operator);
        return $this;
    }

    /**
     * Define WHERE clause with the NULL condition.
     *
     * @param string $left   Left expression
     * @param bool   $negate Whether to negate the condition or not
     *
     * @return $this Self reference
     */
    public function where_null($left, $negate = FALSE): static
    {
        $operator = ($negate === FALSE) ? 'IS' : 'IS NOT';
        $this->sql_condition($left, 'NULL', $operator);
        return $this;
    }

    /**
     * Open WHERE group.
     *
     * @return $this Self reference
     */
    public function start_where_group(): static
    {
        $this->sql_group_start();
        return $this;
    }

    /**
     * Close WHERE group.
     *
     * @return $this Self reference
     */
    public function end_where_group(): static
    {
        $this->sql_group_end();
        return $this;
    }

    /**
     * Define HAVING clause of the SQL statement.
     *
     * @param string $left     Left expression
     * @param string $right    Right expression
     * @param string $operator Comparison operator
     *
     * @return $this Self reference
     */
    public function having($left, $right, $operator = '='): static
    {
        $this->sql_condition($left, $right, $operator, 'HAVING');
        return $this;
    }

    /**
     * Define HAVING clause with LIKE comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param bool   $negate Whether to negate the comparison or not
     *
     * @return $this Self reference
     */
    public function having_like($left, $right, $negate = FALSE): static
    {
        $operator = ($negate === FALSE) ? 'LIKE' : 'NOT LIKE';
        $this->sql_condition($left, $right, $operator, 'HAVING');
        return $this;
    }

    /**
     * Define HAVING clause with IN comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param bool   $negate Whether to negate the comparison or not
     *
     * @return $this Self reference
     */
    public function having_in(string $left, string $right, bool $negate = FALSE): static
    {
        $operator = ($negate === FALSE) ? 'IN' : 'NOT IN';
        $this->sql_condition($left, $right, $operator, 'HAVING');
        return $this;
    }

    /**
     * Define HAVING clause with BETWEEN comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $lower  The lower bound of the between condition
     * @param string $upper  The upper bound of the between condition
     * @param bool   $negate Whether to negate the comparison or not
     *
     * @return $this Self reference
     */
    public function having_between($left, $lower, $upper, $negate = FALSE): static
    {
        $right    = $lower . ' AND ' . $upper;
        $operator = ($negate === FALSE) ? 'BETWEEN' : 'NOT BETWEEN';
        $this->sql_condition($left, $right, $operator, 'HAVING');
        return $this;
    }

    /**
     * Define HAVING clause with the NULL condition.
     *
     * @param string $left   Left expression
     * @param bool   $negate Whether to negate the condition or not
     *
     * @return $this Self reference
     */
    public function having_null($left, $negate = FALSE): static
    {
        $operator = ($negate === FALSE) ? 'IS' : 'IS NOT';
        $this->sql_condition($left, 'NULL', $operator, 'HAVING');
        return $this;
    }

    /**
     * Open HAVING group.
     *
     * @return $this Self reference
     */
    public function start_having_group(): static
    {
        $this->sql_group_start('HAVING');
        return $this;
    }

    /**
     * Close HAVING group.
     *
     * @return $this Self reference
     */
    public function end_having_group(): static
    {
        $this->sql_group_end('HAVING');
        return $this;
    }

    /**
     * Define ORDER BY clause in the SQL statement.
     *
     * @param string $expr Expression to order by
     * @param bool   $asc  Order ASCending/TRUE or DESCending/FALSE
     *
     * @return $this Self reference
     */
    public function order_by($expr, $asc = TRUE): static
    {
        $this->sql_order_by($expr, $asc);
        return $this;
    }

    /**
     * Define a LIMIT clause of the SQL statement.
     *
     * @param int $amount The amount of elements to retrieve
     * @param int $offset Start retrieving elements from a specific index
     *
     * @return $this Self reference
     */
    public function limit($amount, $offset = -1): static
    {
        $this->sql_limit($amount, $offset);
        return $this;
    }

    /**
    * Define a UNION, UNION DISTINCT or UNION ALL clause of the SQL statement.
    *
    * @param string $sql_query SQL query reference
    * @param string $operator  UNION operation to perform
    *
    * @return $this Self reference
    */
    public function union(string $sql_query, string $operator = ''): static
    {
        $this->sql_compound($sql_query, 'UNION', strtoupper($operator));
        return $this;
    }

    /**
     * Set logical connector 'AND'.
     *
     * @deprecated Use `and()` instead
     *
     * @return $this Self reference
     */
    public function sql_and(): static
    {
        return $this->and();
    }

    /**
     * Set logical connector 'AND'.
     *
     * @return $this Self reference
     */
    public function and(): static
    {
        $this->sql_connector('AND');
        return $this;
    }

    /**
     * Set logical connector 'OR'.
     *
     * @deprecated Use `or()` instead
     *
     * @return $this Self reference
     */
    public function sql_or(): static
    {
        return $this->or();
    }

    /**
     * Set logical connector 'OR'.
     *
     * @return $this Self reference
     */
    public function or(): static
    {
        $this->sql_connector('OR');
        return $this;
    }

    /**
     * Define a WITH clause.
     *
     * @param string $alias        The alias of the WITH statement
     * @param string $sql_query    Sql query reference
     * @param array  $column_names An optional parameter to give the result columns a name
     *
     * @return $this Self reference
     */
    public function with($alias, $sql_query, $column_names = NULL): static
    {
        $this->sql_with($alias, $sql_query, '', '', $column_names);
        return $this;
    }

    /**
     * Define a recursive WITH clause.
     *
     * @param string $alias           The alias of the WITH statement
     * @param string $anchor_query    The initial select statement
     * @param string $recursive_query The select statement that selects recursively out of the initial query
     * @param bool   $union_all       True for UNION ALL false for UNION
     * @param array  $column_names    An optional parameter to give the result columns a name
     *
     * @return $this Self reference
     */
    public function with_recursive($alias, $anchor_query, $recursive_query, $union_all = FALSE, $column_names = NULL): static
    {
        $base = ($union_all === TRUE) ? 'UNION ALL' : 'UNION';
        $this->sql_with($alias, $anchor_query, $recursive_query, $base, $column_names);
        return $this;
    }

}

?>
