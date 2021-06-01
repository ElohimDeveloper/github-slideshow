<?php
declare(strict_types=1);

interface IEntityTable 
{
    /**
     * Adds a data into a new row
     * within a selected database table
     *
     * @param array $row_data
     * @return void
     */
    public function insert(array $row_data): void;

    /**
     * Fetches a single or multiple rows from
     * within selected database table(s) 
     *
     * @param array $entity_id (named_key: entity_id [and other selected keys])
     * @return array 'of Client'
     */
    public function retrieve(array $entity_credential): array;

    /**
     * Changes current row data within 
     * a selected database's table(s)
     *
     * @param array $new_info
     * @return void
     */
    public function update(array $new_info = array('request' => '', 'query_type' => '')): void;

    /**
     * Removes a row within a selected database table
     *
     * @param array $entity_id
     * @return void
     */
    public function delete(array $entity_code = array()): void;

    /**
     * Creates a new table within the selected database
     *
     * @param array $field_info
     * @return void
     */
    public function table_setup(): void;

    /**
     * Drops table within selected database
     *
     * @param array $table_name
     * @return void
     */
    public function drop_table(): void;

    /**
     * Gets Previous Query Result
     *
     * Note: When not executing a select (query) statement,
     * the 'Command Response Structure is returned.
     * 
     * Command Response Structure (N.B. named-keys used):
     * status, response_date, response_time, assoc, numerical
     * 
     * Query Response Structure (N.B. named-keys used):
     * status, result
     * @return array
     */
    public function response(): array;

    /**
     * Performs Database Setup
     *
     * @param array $credentials
     * Credentials:- named keys:
     * host, user, code
     * @param string $database (to be created)
     * @param boolean $select_database
     * @return void
     */
    public function connection(array $credentials = array(), string $database = '', bool $select_database = false, bool $new_db = false): void;

    /**
     * Ensures that initial connection was completed
     *
     * @return boolean
     */
    public function connection_successful(): bool;

    /**
     * Closes database connection
     *
     * @return void
     */
    public function drop_connection(): void;

    /**
     * Total row count
     *
     * @return integer
     */
    public function count(): string;

    /**
     * Retrieve last row's code
     *
     * @return string
     */
    public function last_code(): string;

    public function database_link(): IDatabase;

    public function all_rows(): array;

    // public function database_created(): bool;

    /**
     * Main Accessor Method
     * The array is associated, 
     * the key is named: with the 
     * class' attribute name passed.
     * 
     * Accepts lower-case only
     *
     * @param string $name
     * @param boolean $summary
     * @return array
     */
    public function information(string $name = '', bool $summary = false): array;

    public function update_data_sql_string(array $request_model): void; 

}

?>
