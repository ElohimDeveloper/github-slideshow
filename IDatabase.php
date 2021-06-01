<?php
declare(strict_types=1);

interface IDatabase 
{
    /**
     * Overriding 'Constructor'
     *
     * @param array $credentials
     * Credentials:- named keys:
     * host, user, code
     * @param string $database
     * @param boolean $select_database
     * @return void
     */
    public function reconstruct(array $credentials = array('host' => 'localhost', 'user' => 'root', 'code' => ''), string $database = '', bool $select_database = false, bool $new_db = false): void;

    /**
     * Designates the Request(s) Submitted
     *
     * @param array $request_model
     * named-keys: request, query_type
     * @return void
     */
    public function fulfill(array $request_model = array('request' => '', 'query_type' => 'command')): void;

    /**
     * Gets Previous Query Result
     * 
     * Response are return using the following structures:
     * 
     * Command Response Structure (N.B. named-keys used):
     * status, response_date, response_time, assoc, numerical
     * 
     * Query Response Structure (N.B. named-keys used):
     * status, result
     * 
     * Note: When not executing a select (query) statement,
     * the 'Command Response Structure is returned.
     *
     * @return array
     */
    public function response_packet(): array;

    /**
     * Closes connection to selected database
     *
     * @return void
     */
    public function disconnect(): void;

    /**
     * Verifies connection to selected database was closed
     *
     * @return boolean
     */
    public function connected(): bool;

    /**
     * Verifies database and server connection
     * was made
     *
     * @return boolean
     */
    public function completed_base_setup(): bool;
}

?>
