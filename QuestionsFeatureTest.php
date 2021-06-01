<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertJsonStringEqualsJsonString;
use function PHPUnit\Framework\assertTrue;

$questions_path = $_SERVER['DOCUMENT_ROOT'] . 'requirements_catalogue\Questions\php\Questions.php';
require_once($questions_path);
require_once('Use_Cases\QuestionsFeature.php');
require_once('Infrastructure\Storage\MySql\php\MySql.php');
require_once('Interface\Request.php');
require_once('Infrastructure\Storage\QuestionsTable\php\QuestionsTable.php');

class QuestionsFeatureTest extends TestCase
{
    private $response = null;
    private $request = null;
    private $questions = null;
    private $use_case = null;

    public function test_ui_add_request_was_processed_and_correct_response_returned()
    {
        $add_questions_req = null;
        $status =array();
        $error = array();
        $success = array();
        $expected_json = null;

        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        // $new_db = false;
        $database = 'users_etc';

        $this->_questions(new Questions());
        $dependency = array('module_table' => new QuestionsTable(new MySql($default_credentials, $database, $select_database)));
        $this->questions()->_construct($dependency);
        
        $data['data'] = array('fullname' => 'Holy Spirit', 'description' => 'Heaven', 
                        'email' => 'hs@elohimbara.org');
        $type = array('type' => 'add');

        $add_questions_req = array_merge($data, $type);
        $add_questions_req = json_encode($add_questions_req);

        $client_request = $add_questions_req;

        $this->_use_case(new QuestionsFeature($client_request, $this->questions()));
        // var_dump($this->use_case()->json());

        $status['status'] = 'ok';
        $success['success'] = array_merge($data['data'], $success);
        $error['error'] = 'none';

        $expected_json = json_encode(array_merge($status, $success, $error));
        // var_dump($expected_json);

        assertJsonStringEqualsJsonString($expected_json, $this->use_case()->json());
    }

    public function test_ui_search_request_was_processed_and_correct_response_returned()
    {
        $fetch_questions_req = null;
        $status =array();
        $error = array();
        $success = array();
        $expected_json = null;

        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        // $new_db = false;
        $database = 'users_etc';

        $this->_questions(new Questions());
        $dependency = array('module_table' => new QuestionsTable(new MySql($default_credentials, $database, $select_database)));
        $this->questions()->_construct($dependency);

        $data['data'] = array('code' => '002');
        $type = array('type' => 'search');

        $fetch_questions_req = array_merge($data, $type);
        $fetch_questions_req = json_encode($fetch_questions_req);

        $client_request = $fetch_questions_req;

        $this->_use_case(new QuestionsFeature($client_request, $this->questions()));
        // var_dump($this->use_case()->json());

        $status['status'] = 'ok';
        $success['success'] = array('fullname' => 'joseph tobas', 'description' => 'TrinidadCaymanTobagoUSA', 
                            'email' => 'strongs@elohimbaraenterprises.org', 'code' => '002');
        $error['error'] = 'none';

        $expected_json = json_encode(array_merge($status, $success, $error));
        // var_dump($expected_json);

        assertJsonStringEqualsJsonString($expected_json, $this->use_case()->json());
    }
    
    public function questions(): Response
    {
        return $this->questions;
    }

    public function _questions(Questions $questions = null): void
    {
        $this->questions = ($this->questions !== null) ? $this->questions : $questions;
    }

    public function use_case(): Request
    {
        return $this->use_case;
    }

    public function _use_case(Request $use_case = null): void
    {
        $this->use_case = ($this->use_case !== null) ? $this->use_case : $use_case;
    }
    
}

