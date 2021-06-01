<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertContainsEquals;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;
use function PHPUnit\Framework\assertNotContainsEquals;
use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertNotNull;

require_once('requirements_catalogue\Questions\php\Questions.php');
require_once('Infrastructure\Storage\MySql\php\MySql.php');
require_once('Infrastructure\Storage\QuestionsTable\php\QuestionsTable.php');
require_once('test\unit\requirements_catalogue\Stubs\AddQuestionsStub.php');

class QuestionsTest extends TestCase
{
    private $questions;
    private $entries = array();
    private $table_data = array();

    public function test_question_is_found_in_table()
    {
        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        // $new_db = false;
        $database = 'users_etc';
        
        $this->_questions(new Questions());
        $dependency = array('module_table' => new QuestionsTable(new MySql($default_credentials, $database, $select_database)));
        $this->questions()->_construct($dependency);

        $actual = $this->questions()->row_data(new Questions ('josiah tobas', 'jtobas@elohimbaraenterprises.org', 'na', '001'));

        $expected = new Questions ('josiah tobas', 'jtobas@elohimbaraenterprises.org', 'TrinidadCaymanTobago', '001'); 
        assertEquals($actual, $expected);
    }

    public function test_question_is_found_in_table_via_find_interface()
    {
        $actual = null;
        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        // $new_db = false;
        $database = 'users_etc';
        
        $this->_questions(new Questions());
        $dependency = array('module_table' => new QuestionsTable(new MySql($default_credentials, $database, $select_database)));
        $this->questions()->_construct($dependency);
        $questions_test_data = new Questions ('josiah tobas', 'jtobas@elohimbaraenterprises.org', 'na', '001');
        $actual = $this->questions()->find($questions_test_data);
        $expected = null;
        // var_dump($actual);

        $expected = new Questions ('josiah tobas', 'jtobas@elohimbaraenterprises.org', 'TrinidadCaymanTobago', '001'); 
        assertEquals($expected, $actual);
    }

    public function test_question_code_is_correctly_generated()
    {
        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        // $new_db = false;
        $database = 'users_etc';
        
        $this->_questions(new Questions());
        $dependency = array('module_table' => new QuestionsTable(new MySql($default_credentials, $database, $select_database)));
        $this->questions()->_construct($dependency);

        $actual = $this->questions()->new_code();

        $expected = '004';
        assertEquals($expected, $actual);
    }

    public function test_question_is_added_to_database()
    {
        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        // $new_db = false;
        $database = 'users_etc';
        
        $this->_questions(new Questions());
        $dependency = array('module_table' => new QuestionsTable(new MySql($default_credentials, $database, $select_database)));
        $this->questions()->_construct($dependency);

        $new_user = new Questions ('andrew tobas', 'al_tobas@elohimbaraenterprises.org', 'TrinidadCaymanTobago', ''); 
        $expected = new Questions ('andrew tobas', 'al_tobas@elohimbaraenterprises.org', 'TrinidadCaymanTobago', '004'); 

        $this->questions()->add($new_user);

        $response = $this->questions()->find($expected);
        $added_to_module_table = $response;

        assertEquals($expected, $added_to_module_table);
    }

    public function test_question_is_added_and_correct_response_is_returned()
    {
        $expected = false;
        $actual = array();
        $data = array();
        $app_request = array();
        $response_data = array();
        $client_response = array();

        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        // $new_db = false;
        $database = 'users_etc';
        
        $this->_questions(new Questions());
        $dependency = array('module_table' => new QuestionsTable(new MySql($default_credentials, $database, $select_database)));
        $this->questions()->_construct($dependency);
        
        $data['data'] = array('fullname' => 'jesus christ', 'description' => 'Heaven', 
                        'email' => 'jc@elohimbara.org');
        
        $type = array('type' => 'add');
        $add_questions_req = array_merge($data, $type);
        
        $client_response = $this->questions()->add_response($add_questions_req);

        var_dump($client_response);
        // var_dump(json_encode($client_response));

        assertContainsEquals('ok', $client_response);
        assertContainsEquals('none', $client_response);
        assertContainsEquals($add_questions_req['data']['fullname'], $client_response['success']);
        assertContainsEquals($add_questions_req['data']['email'], $client_response['success']);
        assertContainsEquals($add_questions_req['data']['description'], $client_response['success']);
    }

    public function test_question_is_retrieved_and_correct_response_is_returned()
    {
        $data = array();
        $fetch_questions_req = array();
        $response_data = array();
        $client_response = array();

        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        // $new_db = false;
        $database = 'users_etc';
        
        $this->_questions(new Questions());
        $dependency = array('module_table' => new QuestionsTable(new MySql($default_credentials, $database, $select_database)));
        $this->questions()->_construct($dependency);
        
        $data['data'] = array('code' => '003');

        $type = array('type' => 'search');

        $fetch_questions_req = array_merge($data, $type);
        $client_response = $this->questions()->search_response($fetch_questions_req);

        assertContainsEquals('003', $client_response['success']);
    }

    public function test_questions_is_added_via_the_respondTo_interface_and_correct_response_is_returned()
    {
        $expected = false;
        $actual = array();
        $data = array();
        $app_request = array();
        $response_data = array();
        $client_response = array();

        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        // $new_db = false;
        $database = 'users_etc';
        
        $this->_questions(new Questions());
        $dependency = array('module_table' => new QuestionsTable(new MySql($default_credentials, $database, $select_database)));
        $this->questions()->_construct($dependency);
        
        $data['data'] = array('fullname' => 'Father God', 'description' => 'Heaven', 
                        'email' => 'fg@elohimbara.org');
        
        $type = array('type' => 'add');
        $app_request = array_merge($data, $type);

        $app = new AddQuestionsStub($app_request, $this->questions());

        $client_response = $app->response();

        // var_dump($client_response);
        // var_dump(json_encode($client_response));

        assertContainsEquals('ok', $client_response);
        assertContainsEquals('none', $client_response);
        assertContainsEquals($app_request['data']['fullname'], $client_response['success']);
        assertContainsEquals($app_request['data']['email'], $client_response['success']);
        assertContainsEquals($app_request['data']['description'], $client_response['success']);
    }

/*     public function test_all_rows()
    {
        $table_results = array();
        $numerical_results = array();

        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        // $new_db = false;
        $database = 'users_etc';

        $this->_questions(new Questions());
        $dependency = array('module_table' => new QuestionsTable(new MySql($default_credentials, $database, $select_database)));
        $this->questions()->_construct($dependency);

        $response = null;
        $response = $this->questions()->module_table()->all_rows();
        $successful = (($response['status'] === 'ok') && (!is_null($response['assoc'])));

        $numerical_results = reset($response['numerical']);
        $entries = array();
        $users = array();
        // reset($numerical_results);

        $results_counter = 0;
        // var_dump($numerical_results);
        $array_size = sizeof($numerical_results) -1;
        // $array_size['array_size'] = $array_size;
        var_dump($array_size);
        $this->entries['entries'] = array();

        while ($results_counter <= $array_size) 
        {
            if(!empty($numerical_results[$results_counter]))
            {
                $this->table_data = array('code' => $numerical_results[$results_counter][0], 'fullname' => $numerical_results[$results_counter][1], 
                'description' => $numerical_results[$results_counter][2], 'email' => $numerical_results[$results_counter][3]);
            //     // $table_results['results'] = array_merge();
            //     // $users = array_merge($users, $users);
                // $this->entries['entries'] = array_merge($this->entries, $users);//returns all the rows but has more than one 'entires' named key
                // $this->entries = array_merge($this->entries, $this->table_data); //returns only one row
                // $this->entries = array_merge($this->entries['entries'], $this->table_data); //gives undefined index: entires error
                $this->entries['entries'] = array_merge_recursive($this->entries['entries'], $this->table_data); //gives the exact structure needed but still returns only one row
                // $this->entries['entries'] = array_merge($this->entries, $this->table_data); //returns all the rows but has more than one 'entires' named key
            //     $this->entries['entries'] = array_unique(array_reduce($this->table_data, 'array_merge'));

            }
            else
            {
                break;
            }

            $results_counter++;
        }
        // $entries = array_merge
        // $this->entries['entries'] = array_unique(array_reduce($numerical_results, 'array_merge'));
        // for ($i=0; $i < sizeof($numerical_results); $i++) 
        // {
        //     // for ($j=0; $j < ; $i++) { 
        //     //     # code...
        //     // } 
        //     $users = array('firstname' => , 'sirname' => , 'username' => , 'date_of_birth' => , 'address' => , 'postcode' => , 
        //             'email' => , 'password' => , 'code' => , );
        //     $table_results['results'] = array_merge();
        // }


        // for ($i=0; $i >= sizeof($numerical_results); $i++) 
        // {
        //     // $users = ;

        //     $entries['entries'] .= array('code' => $numerical_results[$i][0], 'fullname' => $numerical_results[$i][1], 
        //     'description' => $numerical_results[$i][2], 'email' => $numerical_results[$i][3]);
        //     // $users = array('firstname' => , 'sirname' => , 'username' => , 'date_of_birth' => , 'address' => , 'postcode' => , 
        //     //         'email' => , 'password' => , 'code' => , );
        //     // $table_results['results'] = array_merge();
        // }

        // var_dump($numerical_results[1]);
        var_dump($this->entries);


        assertNotEmpty($this->entries);
        assertIsArray($this->entries);
        assertNotNull($this->entries);
    }
 */    
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
        return $information = ($this->request_summary($summary)) ? $class_info : $single_attribute;
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
     * Verifies assigned name
     *
     * @param string $name
     * @return boolean
     */
    private function initialized_name(string $name): bool
    {
        return ($name !== '');
    }

    private function state(): array
    {
        return $class_info = array('firstname' => $this->firstname(), 
        'sirname' => $this->sirname(), 'email' => $this->email(),
        'password' => $this->password(), 'code' => $this->code());
    }

    public function questions(): Questions
    {
        return $this->questions;
    }

    public function _questions(Questions $questions = null): void
    {
        $this->questions = ($this->questions !== null) ? $this->questions : $questions;
    }

    public function questions_response(): Response
    {
        return $this->user_response;
    }

    public function _user_response(Questions $user = null): void
    {
        $this->user_response = ($this->user_response !== null) ? $this->user_response : $user;
    }

    private function firstname(): string
    {
        return $this->firstname;
    }

    /**
     * Accessor method
     *
     * @return string
     */
    private function sirname(): string
    {
        return $this->sirname;
    }

    /**
     * Accessor method
     *
     * @return string
     */
    private function password(): string
    {
        return $this->password;
    }

    /**
     * Accessor method
     *
     * @return string
     */
    private function email(): string
    {
        return $this->email;
    }

    /**
     * Accessor method
     *
     * @return string
     */
    private function code(): string
    {
        return $this->code;
    }
}
