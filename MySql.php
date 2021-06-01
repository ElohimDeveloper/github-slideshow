<?php
declare(strict_types=1);

$i_database_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Interface/IDatabase.php';
require_once($i_database_path);

class MySql implements IDatabase
{
    private $result;
    public $server;
    private $request = '';
    private $response = array();
    private $closed = false;
    private $status;
    private $database_selected;
    private $database;
    private $dataManipulation_dataDefinition_result = false;
    private $dataQuery_result = array();
    private $host;
    private $code;
    private $user;
    private $credentials = array();
    private $date = array();
    private $time = array();
    private $assoc_result = array();
    private $numerical_result = array();
    private $error;
    private $search_ok;
    private $command_ok;

    /**
     * Constructor
     *
     * @param array $credentials -uses associative keys: host, user & code
     * @param string $database
     * @param boolean $select_database
     */
    public function __construct(array $credentials = array(), string $database = '', bool $select_database = false)
    {
        $minimum_array_size = 1;
        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $filled_credentials = (sizeof($credentials) > $minimum_array_size);

        ($filled_credentials) ? $this->server_connection($credentials['host'], $credentials['user'], $credentials['code']) : 
        $this->server_connection($default_credentials['host'], $default_credentials['user'], $default_credentials['code']);

        ($this->select_database($database, $select_database)) ? $this->database_connection($database) : $this->database_connection('net');
    }

    /**
     * Overriding 'Constructor'
     *
     * @param array $credentials
     * @param string $database
     * @param boolean $select_database
     * @return void
     */
    public function _construct(array $credentials = array('host' => 'localhost', 'user' => 'root', 'code' => ''), string $database = '', bool $select_database = false): void
    {
        $this->server_connection($credentials['host'], $credentials['user'], $credentials['code']);
        ($this->select_database($database, $select_database)) ? $this->database_connection($database) : $this->database = $this->database;
    }

    private function _request(string $request): void 
    {
        $this->request = $request;
    }

    public function _close(): void 
    {
        $this->closed = mysqli_close($this->server);
    }

    /**
     * Mutator Method
     *
     * @param boolean $command_ok
     * @return void
     */
    private function _commandOk(bool $command_ok = true): void
    {
        $this->command_ok = $command_ok;
    }

    private function _status(bool $status = false): void
    {
        $this->status = ($status) ? 'ok' : 'fail';
        $status = array('status' => $this->status);
        // var_dump($status);
    }

    private function state(): array
    {
        return $class_info = array('dataManipulation_dataDefinition_result' => $this->dataManipulation_dataDefinition_result, 
        'request' => $this->request, 'result' => $this->result, 'response' => $this->response, 'closed' => $this->closed(),
        'database_selected' => $this->database_selected, 'server' => $this->server, 'command_ok' => $this->command_ok,
        'database' => $this->database, 'host' => $this->host, 'user' => $this->user, 'search_ok' => $this->search_ok,
        'code' => $this->code,  'dataQuery_result' => $this->dataQuery_result, 'data' => $this->date,
        'time' => $this->time,);
    }

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
    public function information(string $name = '', bool $summary = false): array
    {
        $class_info = $this->state();
        $empty = ($this->initialized_name($name));
        $single_attribute = ($empty) ? array($name => $class_info[$name]) : '';
        return ($this->request_summary($summary)) ? $class_info : $single_attribute;
    }

    /**
     * Verifies assigned name
     *
     * @param string $name
     * @return boolean
     */
    private function initialized_name(string $name): bool
    {
        return ($name !== '');
    }

    /**
     * Verifies summary request
     *
     * @param boolean $summary
     * @return boolean
     */
    private function request_summary(bool $summary): bool
    {
        return $full_summary = ($summary === true);
    }

    /**
     * Accepts Server Login data
     *
     * @param string $host
     * @param string $user
     * @param string $code
     * @return void
     */
    private function credentials(string $host = 'localhost', string $user = 'root', string $code = ''): void 
    {
        $this->host = $host;
        $this->user = $user;
        $this->code = $code;
        $this->credentials['host'] = $this->host;
        $this->credentials['user'] = $this->user;
        $this->credentials['code'] = $this->code;
    }

    /**
     * Connects to server
     * 
     *
     * @return void
     */
    private function connect(): void
    {
        $this->server = mysqli_connect($this->credentials['host'], $this->credentials['user'], 
        $this->credentials['code']);
    }

    /**
     * Server Setup
     *
     * @param string $host
     * @param string $user
     * @param string $code
     * @return void
     */
    private function server_connection($host = 'localhost', string $user = 'root', string $code = ''): void 
    {
        $this->credentials($host, $user, $code);
        $this->connect();
    }

    /**
     * Connects to database
     *
     * @param string $database
     * @return void
     */
    private function database_connection(string $database = 'maria_test'): void 
    {
        $this->database = $database;
        $this->database_selected = mysqli_select_db($this->server, $this->database);
        $databases['db_chosen'] = $this->database_selected;
    }

    /**
     * Database Selection Check
     *
     * @param string $database
     * @param boolean $select_database
     * @return boolean
     */
    private function select_database(string $database, bool $select_database): bool 
    {
        return ((!is_null($database) && ($database !== '')) && ($select_database === true));
    }

    /**
     * Database Closed Check
     *
     * @return boolean
     */ 
    private function closed(): bool
    {
        return ($this->closed) ? true : false;
    }
    
    /**
     * Executes Data Query Requests
     *
     * @return void
     */
    private function query(): void
    {
        $this->result = mysqli_query($this->server, $this->request);
        $this->search_ok = ($this->query_successful() === true);
        // $search_ok = array('search_ok' => $this->search_ok);
        // $result = array('result' => $this->result);
        $this->error = mysqli_error($this->server);
        $this->query_response();
    }

    /**
     * Initiates Query Response Construction
     * for Data Query Requests
     *
     * @return void
     */
    private function query_response(): void
    {
        $this->query_assoc_numerical_results();
        $this->query_response_data();
    }

    /**
     * Package Data Query Response
     *
     * @param array $status
     * @return void
     */
    private function query_response_package(array $status): void 
    {
        $date_time = array_merge($this->date, $this->time);
        $this->dataQuery_result = array_merge($this->assoc_result, $this->numerical_result);
        $dataQuery_result['query_result_packaging'] = $this->dataQuery_result;
        // var_dump($dataQuery_result);
        $this->response = array_merge($status, $this->dataQuery_result, $date_time);
        $query_package_contents['query_package_contents'] = $this->response;
        // var_dump($query_package_contents);
    }

    /**
     * Data Query Response Data Collection
     *
     * @return void
     */
    private function query_response_data(): void 
    {
        $status['status'] = $this->status;
        $this->date['response_date'] = date("m.d.y");
        $this->time['response_time'] = date("H:i:s");
        $this->query_response_package($status);
    }

    /**
     * Data Query Response in:
     * Associative and Numerical format
     *
     * @return void
     */
    private function query_assoc_numerical_results(): void
    {
        $this->_status($this->search_ok);
        $this->assoc_result['assoc'] =  ($this->status === 'ok') ? $this->attach_assoc_array(): 'empty';
        // $affected_rows1['assoc_result_affected_rows'] = $this->affected_rows();
        // var_dump($affected_rows1);
        // var_dump($this->assoc_result);
        $this->numerical_result['numerical'] = ($this->status === 'ok') ? $this->attach_numerical_array(): 'empty';
        // $affected_rows2['numerical_result_affected_rows'] = $this->affected_rows();
        // var_dump($affected_rows2);
        // var_dump($this->numerical_result);
        // $this->numerical_result['numerical'] = ($this->status === 'ok') ? mysqli_fetch_all($this->result, MYSQLI_NUM): 'empty';
    }

    private function attach_assoc_array(int $mysqli_array_mode = MYSQLI_ASSOC): array
    {
        $assoc_result = '';
        $has_multiple_rows = $this->has_multiple_rows();
        if ($has_multiple_rows) 
        {
            $results_data = mysqli_fetch_all($this->result, $mysqli_array_mode);
            $assoc_result = (is_null($results_data) === false) ? $results_data : array('empty' => 'empty' );
        }
        else
        {
            $results_data = mysqli_fetch_assoc($this->result);
            $assoc_result = (is_null($results_data) === false) ? $results_data : array('empty' => 'empty' );
        }
        return $assoc_result;
    }

    private function attach_numerical_array(int $mysqli_array_mode = MYSQLI_NUM): array
    {
        $assoc_result = '';
        $has_multiple_rows = $this->has_multiple_rows();
        if ($has_multiple_rows) 
        {
            $results_data = mysqli_fetch_all($this->result, $mysqli_array_mode);
            $assoc_result = (is_null($results_data) === false) ? $results_data : array('empty' => 'empty' );
        }
        else
        {
            $results_data = mysqli_fetch_array($this->result, $mysqli_array_mode);
            $assoc_result = (is_null($results_data) === false) ? $results_data : array('empty' => 'empty' );
        }
        return $assoc_result;
    }

    private function has_multiple_rows(): bool
    {
        $row_count = 1;
        return ($this->affected_rows() > $row_count);
    }

    /**
     * Data Query Response Check
     *
     * @return boolean
     */
    private function query_successful(): bool
    {
        return (is_object($this->result) === true);
    }

    /**
     * Executes Data Manipulation and Data Definition Requests
     *
     * @return void
     */
    private function command(): void 
    {
        $this->result = mysqli_query($this->server, $this->request);
        $affected_rows = $this->affected_rows();
        // var_dump($affected_rows);
        $this->_commandOk($this->command_successful($affected_rows));
        $this->command_response();
        $error = mysqli_error($this->server);
        // var_dump($error);
    }

    /**
     * Initiates Data Manipulation and Data Definition Response
     * Construction
     *
     * @return void
     */
    private function command_response(): void
    {
        $this->command_assoc_result();
        $this->command_response_data();        
    }

    /**
     * Data Manipulation and Data Definition Response Data Collection
     *
     * @return void
     */
    private function command_response_data(): void
    {
        $status['status'] = $this->status;
        $result['result'] = $this->dataManipulation_dataDefinition_result['result'];
        // var_dump($result);
        $this->command_response_package($status, $result);
    }

    /**
     * Package Data Manipulation and Data Definition Response
     *
     * @param array $status
     * @param array $result
     * @return void
     */
    private function command_response_package(array $status, array $result): void
    {
        $this->response = array_merge($status, $result);
    }

    /**
     * Data Manipulation and Data Definition in:
     * Associative format
     *
     * @return void
     */
    private function command_assoc_result(): void
    {
        $this->_status($this->command_ok);
        $this->dataManipulation_dataDefinition_result['result'] = ($this->status === 'ok') ? 'true': 'false';
    }

    /**
     * Data Manipulation and Data Definition Response,  
     * Affected Database Rows
     * 
     * @return integer
     */
    private function affected_rows(): int 
    {
       return mysqli_affected_rows($this->server);
    }

    /**
     * Data Manipulation and Data Definition Response Check
     *
     * @param integer $affected_rows
     * @return boolean
     */
    private function command_successful(int $affected_rows): bool 
    {
        return (($this->result === true) && ($affected_rows >= 0) && ($affected_rows !== -1));
    }

    //IDatabase Interface methods

    public function reconstruct(array $credentials = array('host' => 'localhost', 'user' => 'root', 'code' => ''), string $database = '', bool $select_database = false, bool $new_db = false): void
    {
        //Check that db is to be created
        $create_db = ($new_db === true);
        $server = (!is_null($this->server));
        //Carry out decision based on previous check
        (($create_db) && ($server)) ? $this->new_database($database, $select_database) : 
        $this->_construct($credentials, 'empty', false);
    }

    public function fulfill(array $request_model = array('request' => '', 'query_type' => 'command')): void
    {
        $this->_request($request_model['request']);
        $command_query = ($request_model['query_type'] === 'command');
        ($command_query) ? $this->command() : $this->query();
    }

    public function response_packet(): array
    {
        return $this->information('response');
    }

    public function disconnect(): void
    {
        $this->_close();
    }

    public function connected(): bool
    {
        return $this->closed();
    }

    public function completed_base_setup(): bool 
    {
        $setup = array();
        $setup['database'] = $this->information('database_selected');
        $setup['server'] = $this->information('server');

        // $connected_to_database_and_server = ((!is_null($this->server)) && ($this->database_selected === true));
        // $server['server_db'] = $connected_to_database_and_server;
        // $connected_only_to_server = ((is_null($this->server)  !== false) && ($this->database_selected === false));
        // $db['dbase'] = $connected_only_to_server;
        $db['class_database_selected_value'] = $this->database_selected;
        $server['class_server_value'] = $this->server;
        $completed = (($this->database_selected) || ($this->server)) ? true : false;
        $completed_setup['completed_setup'] = $completed;
        return $completed;
    }

    //Internal helper methods for IDatabase Interface methods

    private function new_database(string $db_name = '', bool $select_database = false): void
    {
        //connect to server
        //this is not needed as the connection to server is made upon instantiation
        // $this->server_connection($credentials['host'], $credentials['user'], $credentials['code']);
        
        //build main part of sql query string
        $new_db_request = 'create database IF NOT EXISTS ';

        //build sql query string
        $new_db_request .= $db_name;

        //build request model
        $request_model = array('request' => $new_db_request, 'query_type' => 'command');
        //Act
        //deliver request via the fulfil method and create database
        $this->fulfill($request_model);
        $response = $this->information('response');
        $response = $response['response'];

        $database['new_db_status'] = $response['status'];
        $created = ($database['new_db_status'] === 'ok');
        $create['created'] = $created;

        if($created === true)
        {
            $this->_construct($this->credentials, $db_name, $select_database);
            // $this->database_connection($db_name);
        }
    }
}
?>
