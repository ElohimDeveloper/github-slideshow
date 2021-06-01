<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertTrue;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertContains;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertNotFalse;
use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertContainsEquals;


$mysql_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Infrastructure/Storage/MySql/php/MySql.php';
require_once($mysql_path);
$i_database_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Interface\IDatabase.php';
require_once($i_database_path);

 class MySqlTest extends TestCase
{
    private $result;
    private $server;
    private $error;
    private $error_no;
    private $assoc_result = array();
    private $search_ok;
    private $command_ok;
    private $status;
    private $request;
    private $numerical_result = array();
    private $closed;
    private $database_selected;
    private $database;
    private $dbase;
    private $dataManipulation_dataDefinition_result = array();
    private $dataQuery_result = array();
    private $response = array();
    private $host;
    private $code;
    private $user;
    private $credentials = array();
    private $date = array();
    private $time = array();

    public function test_connection_to_server_is_successful()
    {
        $mysql = new MySql(array('host' => 'localhost', 'user' => 'root', 'code' => ''));
        $this->server = $mysql->information('server');
        var_dump($this->server);
        assertNotNull($this->server['server']);
    }

    public function test_connection_to_database_is_successful()
    {
        $database_connection = array('database' => 'air_pollution', 'selected_database' => true);
        $mysql = new MySql(array('host' => 'localhost', 'user' => 'root', 'code' => ''),
        $database_connection['database'], $database_connection['selected_database']);
        $this->database_selected = $mysql->information('database_selected');
        var_dump($this->database_selected);
        assertTrue($this->database_selected['database_selected']);
    }

    public function test_completed_base_setup_interface_is_successful()
    {
        $database_connection = array('database' => 'air_pollution', 'selected_database' => true);
        $mysql = new MySql(array('host' => 'localhost', 'user' => 'root', 'code' => ''),
        $database_connection['database'], $database_connection['selected_database']);
        assertTrue($mysql->completed_base_setup());
    }

    public function test_sever_connection_is_closed()
    {
        $mysql = new MySql(array('host' => 'localhost', 'user' => 'root', 'code' => ''));
        $mysql->_close();
        $this->close = $mysql->information('closed');
        assertTrue($this->close['closed']);
    }

    public function test_TEST_MARIA_database_drop_is_successful()
    {
        $database_connection = array('database' => 'net', 'selected_database' => true);

        $mysql = new MySql(array('host' => 'localhost', 'user' => 'root', 'code' => ''),
        $database_connection['database'], $database_connection['selected_database']);

        $request = 'Drop database test_maria';
        $query_type = 'command';
        $request_model = array('request' => $request, 'query_type' => $query_type);

        $mysql->fulfill($request_model);

        $this->dataManipulation_dataDefinition_result = $mysql->information('dataManipulation_dataDefinition_result');
        $result = $this->dataManipulation_dataDefinition_result['dataManipulation_dataDefinition_result'];
        $expected = 'true';
        assertContainsEquals($expected, $result);
        $mysql->_close();
        // var_dump($this->dataManipulation_dataDefinition_result);
    }

    public function test_create_MARIA_TEST_database_result_is_successful()
    {
        $database_connection = array('database' => 'net', 'selected_database' => true);

        $mysql = new MySql(array('host' => 'localhost', 'user' => 'root', 'code' => ''),
        $database_connection['database'], $database_connection['selected_database']);

        $request = 'create database IF NOT EXISTS maria_test';
        $query_type = 'command';
        $request_model = array('request' => $request, 'query_type' => $query_type);

        $mysql->fulfill($request_model);

        $this->dataManipulation_dataDefinition_result = $mysql->information('dataManipulation_dataDefinition_result');
        $result = $this->dataManipulation_dataDefinition_result['dataManipulation_dataDefinition_result'];
        $expected = 'true';
        assertContainsEquals($expected, $result);
        $mysql->_close();
        // var_dump($this->dataManipulation_dataDefinition_result);
    }

    public function test_create_database_result_is_successful()
    {
        $database_connection = array('database' => 'net', 'selected_database' => true);

        $mysql = new MySql(array('host' => 'localhost', 'user' => 'root', 'code' => ''),
        $database_connection['database'], $database_connection['selected_database']);

        $request = 'create database IF NOT EXISTS test_maria';
        $query_type = 'command';
        $request_model = array('request' => $request, 'query_type' => $query_type);

        $mysql->fulfill($request_model);

        $this->dataManipulation_dataDefinition_result = $mysql->information('dataManipulation_dataDefinition_result');
        $result = $this->dataManipulation_dataDefinition_result['dataManipulation_dataDefinition_result'];
        $expected = 'true';
        assertContainsEquals($expected, $result);
        $mysql->_close();
        // var_dump($this->dataManipulation_dataDefinition_result);
    }

    public function test_database_drop_is_successful()
    {
        $database_connection = array('database' => 'net', 'selected_database' => true);

        $mysql = new MySql(array('host' => 'localhost', 'user' => 'root', 'code' => ''),
        $database_connection['database'], $database_connection['selected_database']);

        $request = 'Drop database maria_test';
        $query_type = 'command';
        $request_model = array('request' => $request, 'query_type' => $query_type);

        $mysql->fulfill($request_model);

        $this->dataManipulation_dataDefinition_result = $mysql->information('dataManipulation_dataDefinition_result');
        $result = $this->dataManipulation_dataDefinition_result['dataManipulation_dataDefinition_result'];
        $expected = 'true';
        assertContainsEquals($expected, $result);
        $mysql->_close();
        // var_dump($this->dataManipulation_dataDefinition_result);
    }

    public function test_table_is_created_successfully()
    {
        $database_connection = array('database' => 'test_maria', 'selected_database' => true);

        $mysql = new MySql(array('host' => 'localhost', 'user' => 'root', 'code' => ''),
        $database_connection['database'], $database_connection['selected_database']);

        $request = 'create table book(code varchar (16) not null, title varchar (100), Primary Key(code))';
        $query_type = 'command';
        $request_model = array('request' => $request, 'query_type' => $query_type);

        $mysql->fulfill($request_model);

        $this->dataManipulation_dataDefinition_result = $mysql->information('dataManipulation_dataDefinition_result');
        $result = $this->dataManipulation_dataDefinition_result['dataManipulation_dataDefinition_result'];
        $expected = 'true';
        assertContainsEquals($expected, $result);
        $mysql->_close();
    }

     public function test_book_is_added_successfully()
    {
        $database_connection = array('database' => 'test_maria', 'selected_database' => true);

        $mysql = new MySql(array('host' => 'localhost', 'user' => 'root', 'code' => ''),
        $database_connection['database'], $database_connection['selected_database']);

        $request = "Insert Into `book`(`code`, `title`) VALUES ('003', 'genesis')";
        $query_type = 'command';
        $request_model = array('request' => $request, 'query_type' => $query_type);

        $mysql->fulfill($request_model);

        $this->dataManipulation_dataDefinition_result = $mysql->information('dataManipulation_dataDefinition_result');
        $result = $this->dataManipulation_dataDefinition_result['dataManipulation_dataDefinition_result'];
        $expected = 'true';
        assertContainsEquals($expected, $result);
        $mysql->_close();
    }

    public function test_record_is_returned_successfully()
    {
        $database_connection = array('database' => 'test_maria', 'selected_database' => true);

        $mysql = new MySql(array('host' => 'localhost', 'user' => 'root', 'code' => ''),
        $database_connection['database'], $database_connection['selected_database']);
        $this->server = $mysql->information('server');

        $request = "Select * from book";
        $query_type = 'search';
        $request_model = array('request' => $request, 'query_type' => $query_type);

        $mysql->fulfill($request_model);

        $response = $mysql->information('response');
        $response = $response['response'];
        // var_dump($response);

        $expected = $response['assoc'];
        $code = $expected["code"];
        $title = $expected["title"];

        $this->status = 'ok';
        $this->response = array('status' => $this->status, 'code' =>  $code, 'title' => $title);
        // var_dump($this->result);
        // var_dump($this->response);
        assertContainsEquals($this->status, $this->response);
        assertContainsEquals($code, $this->response);
        assertContainsEquals($title, $this->response);
        $mysql->_close();
    }

    public function test_find_query_type_is_returned_in_a_associative_array()
    {
        $database_connection = array('database' => 'test_maria', 'selected_database' => true);

        $mysql = new MySql(array('host' => 'localhost', 'user' => 'root', 'code' => ''),
        $database_connection['database'], $database_connection['selected_database']);
        $this->server = $mysql->information('server');

        $request = "Select * from book";
        $query_type = 'search';
        $request_model = array('request' => $request, 'query_type' => $query_type);

        $mysql->fulfill($request_model);

        $response = $mysql->information('response');
        $response = $response['response'];

        $expected_key = 'assoc';
        assertArrayHasKey($expected_key, $response);
        // assertNotEmpty();
        $mysql->_close();
    }

    public function test_row_is_deleted_successfully()
    {
        $database_connection = array('database' => 'test_maria', 'selected_database' => true);

        $mysql = new MySql(array('host' => 'localhost', 'user' => 'root', 'code' => ''),
        $database_connection['database'], $database_connection['selected_database']);
        $this->server = $mysql->information('server');

        $request = "Delete from book where book.code = '003'";
        $query_type = 'command';
        $request_model = array('request' => $request, 'query_type' => $query_type);

        $mysql->fulfill($request_model);
        $mysql;

        $this->dataManipulation_dataDefinition_result = $mysql->information('dataManipulation_dataDefinition_result');
        $result = $this->dataManipulation_dataDefinition_result['dataManipulation_dataDefinition_result'];
        $expected = 'true';
        assertContainsEquals($expected, $result);
        $mysql->_close();
    }

    public function test_command_query_type_has_required_keys()
    {
        $database_connection = array('database' => 'test_maria', 'selected_database' => true);

        $mysql = new MySql(array('host' => 'localhost', 'user' => 'root', 'code' => ''),
        $database_connection['database'], $database_connection['selected_database']);

        $request = "Insert Into `book`(`code`, `title`) VALUES ('007', 'Dynamic Websites')";
        $query_type = 'command';
        $request_model = array('request' => $request, 'query_type' => $query_type);

        $mysql->fulfill($request_model);

        $response = $mysql->information('response');
        $response = $response['response'];
        
        // $response['stat'] = 'ok';
        // $response['result'] = 'false';
        $expected_key = 'status';
        $expected_key2 = 'result';
        assertArrayHasKey($expected_key, $response);
        assertArrayHasKey($expected_key2, $response);
        $mysql->_close();
    }

    public function test_book_is_updated_successfully()
    {
        $database_connection = array('database' => 'test_maria', 'selected_database' => true);

        $mysql = new MySql(array('host' => 'localhost', 'user' => 'root', 'code' => ''),
        $database_connection['database'], $database_connection['selected_database']);

        $request = "Update `book` Set book.title = 'DWeb' Where book.code = '007'";
        $query_type = 'command';
        $request_model = array('request' => $request, 'query_type' => $query_type);

        $mysql->fulfill($request_model);

        $response = $mysql->information('response');
        $response = $response['response'];

        $expected = 'ok';

        assertContainsEquals($expected, $response);
        $mysql->_close();
    }

    private function initialized_name(string $name): bool
    {
        return $empty_name = ($name !== '');
    }

    private function request_summary(bool $summary): bool
    {
        return $full_summary = ($summary === true);
    }

    private function state(): array
    {
        return $class_info = array('dataManipulation_dataDefinition_result' => $this->dataManipulation_dataDefinition_result, 
        'request' => $this->request, 'result' => $this->result, 'response' => $this->response, 'closed' => $this->closed(),
        'database_selected' => $this->database_selected, 'server' => $this->server,
        'database' => $this->database, 'host' => $this->host, 'user' => $this->user,
        'code' => $this->code, 'dataQuery_result' => $this->dataQuery_result);
    }

    public function _database(IDatabase $storage): void
    {
        $this->dbase = $storage;
    }

    public function database(): IDatabase
    {
        return $this->dbase;
    }

    public function information(string $name = '', bool $summary = false): array
    {
        $class_info = $this->state();
        $empty = ($this->initialized_name($name));
        $single_attribute = ($empty) ? array($name => $class_info[$name]) : '';
        return $information = ($this->request_summary($summary)) ? $class_info : $single_attribute;
    }

    private function closed(): bool
    {
        return ($this->closed) ? true : false;
    }
} 
?>