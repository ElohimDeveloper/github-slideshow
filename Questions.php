<?php
declare(strict_types = 1);

$request_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Interface/Request.php';
$response_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Interface/Response.php';
require_once($response_path);
require_once($request_path);

class Questions implements Response
{
    private $code;
    private $email;
    private $fullname;
    private $description;
    private $module_table = null;
    const ADD_REQUEST = 'add';
    const SEARCH_REQUEST = 'search';
    
    /**
     * Class Constructor
     *
     * @param string $fullname
     * @param string $email
     * @param string $description
     * @param string $code
     */
    public function __construct(string $fullname = 'empty', string $email = 'empty', string $description = 'empty', string $code = '')
    {
        $this->fullname = $this->validFullName($fullname) ? $fullname : 'empty';
        $this->email = $this->validEmail($email) ? $email: 'empty';
        $this->code = $this->validCode($code) ? $code: 'empty';
        $this->description = $this->validDescription($description) ? $description: 'empty';
    }

    /**
     * Parse array to Questions
     *
     * @param array $updated_state
     * @return void
     */
    public function renew(array $updated_state): void
    {
        $this->overwrite($updated_state);
    }
    
    public function overwrite(array $key): void
    {
        $this->fullname = $this->validFullName($key['fullname']) ? $key['fullname'] : $this->fullname;
        $this->email = $this->validEmail($key['email']) ? $key['email']: $this->email;
        $this->code = $this->validCode($key['code']) ? $key['code']: $this->code;
        $this->description = $this->validDescription($key['description']) ? $key['description']: $this->description;
    }

    /**
     * Sets the IEntityTable Interface
     *
     * IEntityTable 
     * expected named key: 'module_table'
     *
     * @param array $dependency
     * @return void
     */
    public function _construct(array $dependency): void
    {
        $module_table_exists = ((isset($dependency['module_table']) === true) && empty($dependency['module_table']) === false);
        
        if($module_table_exists)
        {
            $this->module_table = $dependency['module_table'];        
        }
    }

    public function _module_table(IEntityTable $module_table = null): void
    {
        $this->module_table = $module_table;
    }

    public function module_table(): IEntityTable
    {
        return $this->module_table;
    }

    //Accessor Methods
    /**
     * Accessor method
     *
     * @return string
     */
    private function fullname(): string
    {
        return $this->fullname;
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
     * @return void
     */
    private function description()
    {
        return $this->description;
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

    public function validFullName(string $fullname = ''): bool
    {
        $valid = ((is_string($fullname) === true) || ($fullname !== '') || ($fullname !== 'na') || ($fullname !== 'empty'));
        return ($valid) ? true : false; 
    }

    public function validCode(string $code = ''): bool
    {
        $valid = ((is_string($code) === true) || ($code !== '') || ($code !== 'na') || ($code !== 'empty'));
        return ($valid) ? true : false;
    }

    public function validEmail(string $email): bool
    {
        $valid = ((is_string($email) === true) || ($email !== '') || ($email !== 'na') || ($email !== 'empty'));
        return ($valid) ? true : false;
    }

    public function validDescription(string $description): bool
    {
        $valid = ((is_string($description) === true) || ($description !== '') || ($description !== 'na') || ($description !== 'empty'));
        return ($valid) ? true : false;
    }

    public function basic_instance(array $module_data = array()): Questions
    {
        $questions_module = new Questions($module_data['fullname'], $module_data['email'], 'na', $module_data['code']);
        return $questions_module;
    }

    public function instance(array $module_data = array()): Questions
    {
        $questions_module = new Questions($module_data['fullname'], $module_data['email'], 
                            $module_data['description'], $module_data['code']);
        return $questions_module;
    }

    public function object(array $module_data = array()): Questions
    {
        $questions_module = new Questions($module_data['fullname'], $module_data['email'], 
                            $module_data['description'], 'na');
        return $questions_module;
    }

    private function state(): array
    {
        return $class_info = array('fullname' => $this->fullname(), 'email' => $this->email(),
        'description' => $this->description(), 'code' => $this->code()); 
    }

    private function build_state(User $current_user): array
    {
        return $info = array('fullname' => $current_user->fullname, 'email' => $current_user->email,
        'description' => $current_user->description, 'code' => $current_user->code); 
    }

    public function information(string $name = '', bool $summary = false): array
    {
        $class_info = $this->state();
        $empty = ($this->initialized_name($name));
        $single_attribute = ($empty) ? array($name => $class_info[$name]) : '';
        return $information = ($this->request_summary($summary)) ? $class_info : $single_attribute;
    }

    public function add(Questions $add = null): void
    {
        $add->code = $this->new_code();
        $this->_row($add);
    }

    public function _row(Questions $new_question = null): void
    {
        $row_data = array('fullname' => $new_question->fullname, 'email' => $new_question->email,
        'description' => $new_question->description, 'code' => $new_question->code); 

        $this->module_table()->insert($row_data);
    }

    public function exists(Questions $question): bool
    {
        $current_question = $this->find($question);
        $valid_account = false;

        $valid_question = ($current_question->code() === $question->code());
        return ($valid_question === true) ? true : false;
    }

    public function find(Questions $question): Questions
    {
        // $response = null;
        $questions = null;
        $quests = array();
        $quests_account = null;

        $exists = $this->row_data($question);
        $quests_account = $exists;
        $empty_account = (empty($quests_account) === false);
        $email_set = (($empty_account) && (($quests_account->email !== '') || ($quests_account->email !== 'empty')) &&
        ($quests_account->email === $question->email()));
        $fullname_set = (($empty_account) && (($quests_account->fullname !== '') || ($quests_account->fullname !== 'empty')) &&
        ($quests_account->fullname === $question->fullname())); 
        $code_set = (($empty_account) && (($quests_account->code !== '') || ($quests_account->code !== 'empty')) &&
        ($quests_account->code === $question->code()));

        $account_found_in_table =  (($code_set) || ($fullname_set) || ($email_set));

        if ($account_found_in_table) 
        {
            //test code
            $quests['location'] = 'in finds-question class';
            $quests['found_in_table'] = $exists;//test code

            $questions = $quests_account;

            return $questions;
        }
        else
        {
            //test code
            $quests['location'] = 'in finds-question class';
            $quests['not_found_in_table'] = 'unsuccessful';//test code

            return $questions = new Questions();
        }
    }

    public function row_data(Questions $question): Questions
    {
        $response = null;
        $account = null;

        $code = $question->information('code');
        $fullname = $question->information('fullname');
        $email = $question->information('email');
        $request = array('code' => $code['code'], 'fullname' => $fullname['fullname'], 'email' => $email['email']);
        $response = $this->module_table()->retrieve($request);
        $response = $response['response'];
        $successful = (($response['status'] === 'ok') && (!is_null($response['assoc'])));

        if ($successful) 
        {
            $account = new Questions($response['assoc']['fullname'],$response['assoc']['email'], 
                                 $response['assoc']['description'],$response['assoc']['code']);
                                
            return $account;
        }
        else 
        {
            return $account = new User();
        }
    }

    public function new_code(): string 
    {
        $new = array();
        $code = 0;
        $cast_code = '';

        $last_code = (int) $this->module_table()->last_code();
        $new['last_code'] = $last_code;
        $new_code = (string) $last_code + 1;
        $new['new_code'] = $new_code;
        $zero = '0';
        $double_zero = '00';

        $successful = (is_string($new_code) === true);

        if(!$successful)
        {
            $less_than_nine = ($new_code <= 9);
            $greater_than_nine = ($new_code > 9);

            if($less_than_nine)
            {
                $cast_code = (string) $new_code;
                $code = $double_zero.$cast_code;
                return $code;
            }
            elseif ($greater_than_nine) 
            {
                $cast_code = (string) $new_code;
                $code = $zero.$cast_code;
                return $code;
            }
            else 
            {
                return '00000000000000000000000000001';//fix
            }
        }
        else 
        {
            return $new_code;
        }
    }

    public function restructure_request(array $entity_credential): array 
    {
        $fullname_key = (array_key_exists('fullname', $entity_credential) === true);
        $email_key = (array_key_exists('email', $entity_credential) === true);
        $credential = null;

        $email_valid = false;
        $fullname_valid = false;

        $two_fields_has_valid_data = false;
            
        $fullname_data = ($fullname_key) ? $entity_credential['fullname'] : 'empty';
        $email_data = ($email_key) ? $entity_credential['email'] : 'empty';

        $email_valid = ($fullname_data !== 'empty');
        $fullname_valid = ($email_data !== 'empty');

        $two_fields_has_valid_data = (($fullname_valid) && ($email_valid));

        if($two_fields_has_valid_data)
        {
            $credential = array('fullname' => $entity_credential['fullname'], 'email' => $entity_credential['email'], 'code' => 'na');
        }
        elseif ($email_valid) 
        {
            $credential = array('fullname' => 'na', 'email' => $entity_credential['email'], 'code' => 'na');
        }
        elseif ($fullname_valid) 
        {
            $credential = array('fullname' => $entity_credential['fullname'], 'email' => 'na', 'code' => 'na');
        }
        else
        {
            $credential = array('fullname' => 'na', 'email' => 'na', 'code' => $entity_credential['code']);
        }
        return $credential;
    }

    public function table_populated(): bool
    {
        $unpopulated_number = 0;
        return ($this->module_table()->count() > $unpopulated_number) ? true : false;
    }

    public function created_table(): bool
    {
        return $this->module_table()->count();
    }

    public function database_and_server_created(): bool
    {
        return $this->module_table()->connection_successful();
    }

    public function respondTo(Request $use_case = null): array
    {
        $client_response = array();
        $app_request = $use_case->packet();
        $request = $app_request['type'];

        switch ($request) 
        {
            case self::ADD_REQUEST:
                $client_response = $this->add_response($app_request);
                break;
            case self::SEARCH_REQUEST:
                $client_response = $this->search_response($app_request);
                break;
            default:
                break;
        }
        return $client_response;
    }

    public function add_response(array $add_quests_req): array
    {
        $client_response = array();
        $valid_response = false;

        $this->add($this->object($add_quests_req['data']));
        $response_data = $this->module_table()->response();
        $response_data = $response_data['response'];
        $valid_response = $this->add_response_format_policy($response_data);
        
        if($valid_response)
        {
            $client_response['success'] = array_merge($add_quests_req['data']);
            $client_response['status'] = 'ok';
            $client_response['error'] = 'none';
        }
        else 
        {
            $client_response['status'] = 'fail';
            $client_response['success'] = 'none';
            $client_response['error'] = 'retry';
        }
        return $client_response;
    }

    private function add_response_format_policy(array $response_data): bool
    {
        $valid_response = ( ((empty($response_data['status']) === false) && (empty($response_data['result']) === false)) && 
                        (($response_data['status'] === 'ok') && ($response_data['result'] === 'true')) );

        return $valid_response;
    }

    public function search_response(array $fetch_quests_req): array 
    {
        $client_response = array();
        $valid_response = false;
        
        $this->find($this->basic_instance($this->restructure_request($fetch_quests_req['data'])));
        $response_data = $this->module_table()->response();
        $response_data = $response_data['response'];

        $valid_response = ( ((empty($response_data['status']) === false) && (empty($response_data['assoc']) === false)) && 
                        ($response_data['status'] === 'ok') );

        if($valid_response)
        {
            $client_response['success'] = array_merge($response_data['assoc'], $client_response);
            $client_response['status'] = 'ok';
            $client_response['error'] = 'none';
        }
        else 
        {
            $client_response['status'] = 'fail';
            $client_response['success'] = 'none';
            $client_response['error'] = 'not found';
        }
        return $client_response;
    }

    //Accessor Method's Helper Methods

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
}
