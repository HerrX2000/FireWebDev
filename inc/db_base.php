<?php
/**
 * MyBB 1.8
 * Copyright 2014 MyBB Group, All Rights Reserved
 *
 * Website: http://www.mybb.com
 * License: http://www.mybb.com/about/license
 *
 */

interface DB_Base
{

    /**
     * Query the database.
     *
     * @param string $string The query SQL.
     * @param integer $hide_errors 1 if hide errors, 0 if not.
     * @param integer 1 $write_query if executes on master database, 0 if not.
     * @return resource The query data.
     */
    function query($string, $hide_errors=0, $write_query=0);

    /**
     * Execute a write query on the master database
     *
     * @param string $query The query SQL.
     * @param boolean|int $hide_errors 1 if hide errors, 0 if not.
     * @return resource The query data.
     */
    function write_query($query, $hide_errors=0);

    /**
     * Explain a query on the database.
     *
     * @param string $string The query SQL.
     * @param string $qtime The time it took to perform the query.
     */
    function explain_query($string, $qtime);

	 /**
     * prepare the database.
     */
	function prepare($query);
	
    /**
     * Return a result array for a query.
     *
     * @param resource     $query      The query ID.
     * @param int $resulttype The type of array to return.
     *
     * @return array The array of results.
     */
    function fetch_array($query, $resulttype=MYSQL_ASSOC);

    /**
     * Return a specific field from a query.
     *
     * @param resource $query The query ID.
     * @param string $field The name of the field to return.
     * @param int|boolean $row The number of the row to fetch it from.
     */
    function fetch_field($query, $field, $row=false);

    /**
     * Moves internal row pointer to the next row
     *
     * @param resource $query The query ID.
     * @param int $row The pointer to move the row to.
     */
    function data_seek($query, $row);

    /**
     * Return the number of rows resulting from a query.
     *
     * @param resource $query The query ID.
     * @return int The number of rows in the result.
     */
    function num_rows($query);

    /**
     * Return the last id number of inserted data.
     *
     * @return int The id number.
     */
    function insert_id();

    /**
     * Close the connection with the DBMS.
     *
     */
    function close();

    /**
     * Return an error number.
     *
     * @return int The error number of the current error.
     */
    function error_number();

    /**
     * Return an error string.
     *
     * @return string The explanation for the current error.
     */
    function error_string();

    /**
     * Output a database error.
     *
     * @param string $string The string to present as an error.
     */
    function error($string="");

    /**
     * Returns the number of affected rows in a query.
     *
     * @return int The number of affected rows.
     */
    function list_tables($database, $prefix='');

    /**
     * Check if a table exists in a database.
     *
     * @param string $table The table name.
     * @return boolean True when exists, false if not.
     */
    function table_exists($table);

    /**
     * Check if a field exists in a database.
     *
     * @param string $field The field name.
     * @param string $table The table name.
     * @return boolean True when exists, false if not.
     */
    function field_exists($field, $table);

    /**
     * Performs a simple select query.
     *
     * @param string $table The table name to be queried.
     * @param string $fields Comma delimited list of fields to be selected.
     * @param string $conditions SQL formatted list of conditions to be matched.
     * @param array $options List of options: group by, order by, order direction, limit, limit start.
     * @return resource The query data.
     */
    function simple_select($table, $fields="*", $conditions="", $options=array());

    /**
     * Build an insert query from an array.
     *
     * @param string $table The table name to perform the query on.
     * @param array $array An array of fields and their values.
     * @return int The insert ID if available
     */
    function insert_query($table, $array);

    /**
     * Build one query for multiple inserts from a multidimensional array.
     *
     * @param string $table The table name to perform the query on.
     * @param array $array An array of inserts.
     * @return int The insert ID if available
     */
    function insert_query_multiple($table, $array);

    /**
     * Build an update query from an array.
     *
     * @param string $table The table name to perform the query on.
     * @param array $array An array of fields and their values.
     * @param string $where An optional where clause for the query.
     * @param string $limit An optional limit clause for the query.
     * @param boolean $no_quote An option to quote incoming values of the array.
     * @return resource The query data.
     */
    function update_query($table, $array, $where="", $limit="", $no_quote=false);

    /**
     * Build a delete query.
     *
     * @param string $table The table name to perform the query on.
     * @param string $where An optional where clause for the query.
     * @param string $limit An optional limit clause for the query.
     * @return resource The query data.
     */
    function delete_query($table, $where="", $limit="");

    /**
     * Escape a string according to the MySQL escape format.
     *
     * @param string $string The string to be escaped.
     * @return string The escaped string.
     */
    function escape_string($string);

    /**
     * Frees the resources of a MySQLi query.
     *
     * @param object $query The query to destroy.
     * @return boolean Returns true on success, false on faliure
     */
    function free_result($query);

    /**
     * Escape a string used within a like command.
     *
     * @param string $string The string to be escaped.
     * @return string The escaped string.
     */
    function escape_string_like($string);

    /**
     * Gets the current version of MySQL.
     *
     * @return string Version of MySQL.
     */
    function get_version();
	
    /**
     * Drop an table with the specified table
     *
     * @param string $table The name of the table.
     * @param boolean $hard Hard drop - no checking
     * @param boolean $table_prefix Use table prefix?
     */
    function drop_table($table, $hard=false, $table_prefix=true);

    /**
     * Renames a table
     *
     * @param string $old_table The old table name
     * @param string $new_table the new table name
     * @param boolean $table_prefix Use table prefix?
     */
    function rename_table($old_table, $new_table, $table_prefix=true);

    /**
     * Time how long it takes for a particular piece of code to run. Place calls above & below the block of code.
     *
     * @deprecated
     */
    function get_execution_time();
}

