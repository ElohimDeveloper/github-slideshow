<?php
declare(strict_types=1);

$i_database_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Interface/IDatabase.php';
require_once($i_database_path);
$i_entity_table_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Interface/IEntityTable.php';
require_once($i_entity_table_path);

// $mysql_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Infrastructure\Storage\MySql\php\MySql.php';
// require_once($questions_path);

class QuestionsTable implements IEntityTable
{
    private $db_link;
    private $table_drop = '';
    private $insert_data = '';
    private $update_data = '';
    private $penultimate_element_key_name = '';
    private $assoc_array_numerical_keys_size = 0;
    private $antepenultimate_key_name = '';
    private $antepenultimate_key = 0;
    private $where_key = 0;
    private $where_key_element = '';
    private $penultimate_element_key = 0;
    private $fetch_data = '';
    private $response = '';
    private $one_field_has_valid_data;
    private $two_fields_has_valid_data;
    private $all_fields_has_valid_data;
    private $one_field_policy_fields_state;
    private $two_fields_policy_fields_state;
    private $fetch_data_sql_credential_policy_fields;

    public function __construct(IDatabase $database_link)
    {
        $this->_database_dependency($database_link);
    }

    public function _database_dependency(IDatabase $database_link): void
    {
        $this->db_link = $database_link;
    }

    private function one_field_has_valid_data(): bool
    {
        return $this->one_field_has_valid_data;
    }

    private function _one_field_has_valid_data(bool $one_field_has_valid_data): void
    {
        $this->one_field_has_valid_data = $one_field_has_valid_data;
    }

    private function two_fields_has_valid_data(): bool
    {
        return $this->two_fields_has_valid_data;
    }

    private function _two_fields_has_valid_data(bool $two_fields_has_valid_data): void
    {
        $this->two_fields_has_valid_data = $two_fields_has_valid_data;
    }

    private function all_fields_has_valid_data(): bool
    {
        return $this->all_fields_has_valid_data;
    }

    private function _all_fields_has_valid_data(bool $all_fields_has_valid_data): void
    {
        $this->all_fields_has_valid_data = $all_fields_has_valid_data;
    }
    
    private function one_field_policy_fields_state(): array
    {
        return $this->one_field_policy_fields_state;
    }

    private function _one_field_policy_fields_state(array $one_field_policy_fields_state): void
    {
        $this->one_field_policy_fields_state = $one_field_policy_fields_state;
    }

    private function two_fields_policy_fields_state(): array
    {
        return $this->two_fields_policy_fields_state;
    }

    private function _two_fields_policy_fields_state(array $two_fields_policy_fields_state): void
    {
        $this->two_fields_policy_fields_state = $two_fields_policy_fields_state;
    }

    private function fetch_data_sql_credential_policy_fields(): array
    {
        return $this->fetch_data_sql_credential_policy_fields;
    }

    private function _fetch_data_sql_credential_policy_fields(array $fetch_data_sql_credential_policy_fields): void
    {
        $this->fetch_data_sql_credential_policy_fields = $fetch_data_sql_credential_policy_fields;
    }

    private function assoc_array_numerical_keys_size(): int 
    {
        return $this->assoc_array_numerical_keys_size;
    }

    private function _assoc_array_numerical_keys_size(array $numerical_keys): void 
    {
        $this->assoc_array_numerical_keys_size = $this->array_size($numerical_keys);
    }

    private function _antepenultimate_key_name(array $numerical_keys) 
    {
        $this->antepenultimate_key_name = $numerical_keys[$this->antepenultimate_key()];
    } 
    
    private function antepenultimate_key_name(): string
    {
        return $this->antepenultimate_key_name;
    }

    private function _antepenultimate_key(): void
    {
        $upper_bound_index = 0;
        $assoc_array_numerical_keys_size = $this->assoc_array_numerical_keys_size();
        $target_pointer = $assoc_array_numerical_keys_size - 3;

        $this->antepenultimate_key = ($this->has_2or_less_pointers($assoc_array_numerical_keys_size)) ? $upper_bound_index 
        : $target_pointer;
    }

    private function antepenultimate_key(): int
    {
        return $this->antepenultimate_key;
    }

    private function _penultimate_element_key(): void
    {
        $upper_bound_index = 0;
        $assoc_array_numerical_keys_size = $this->assoc_array_numerical_keys_size();
        $target_pointer = $assoc_array_numerical_keys_size - 2;

        $this->penultimate_element_key = ($this->has_2or_less_pointers($assoc_array_numerical_keys_size)) 
        ? $upper_bound_index : $target_pointer;
    }

    private function penultimate_element_key(): int
    {
        return $this->penultimate_element_key;
    }

    private function _penultimate_element_key_name(array $numerical_keys): void 
    {
       $this->penultimate_element_key_name = $numerical_keys[$this->penultimate_element_key()];
    }
    
    private function penultimate_element_key_name(): string
    {
        return $this->penultimate_element_key_name;
    }

    function has_2or_less_pointers($assoc_array_numerical_keys_size): bool 
    {
        return ($assoc_array_numerical_keys_size <= 2) ? true : false;
    }

    private function numerical_keys($request_model)
    {
        $assoc_to_numerical_keys = array_keys($request_model['request']);
        //var_dump($assoc_to_numerical_keys);

        return $assoc_to_numerical_keys;
    }

    private function array_size(array $numerical_keys): int 
    {
       return count($numerical_keys);
    }

    private function _where_key(): void 
    {
        $target_pointer = $this->assoc_array_numerical_keys_size() - 1;
        $this->where_key = $target_pointer;
    }

    private function where_key(): int
    {
        return $this->where_key;
    }

    private function where_key_element(): string
    {
        return $this->where_key_element;
    }

    private function _where_key_element(array $assoc_numerical_keys): void 
    {
        $this->where_key_element = $assoc_numerical_keys[$this->where_key()];
    }

    public function table_creation(): string 
    {
        return $this->table_creation;
    }

    public function _table_creation(): void 
    {
        $this->table_creation = 'Create table questions( ';
        $this->table_creation .= 'code varchar (16) not null, ';
        $this->table_creation .= 'fullname varchar (60), ';
        $this->table_creation .= 'description varchar (200) , ';
        $this->table_creation .= 'email varchar (90), ';
        $this->table_creation .= 'Primary Key (code)';
        $this->table_creation .= ')';
    }

    private function _table_drop(): void 
    {
        $this->table_drop = 'drop table `questions`';
    }

    private function _delete_data(): void 
    {
        $this->delete_data = 'Delete from questions Where questions.code = ';
    }

    private function _update_data(): void 
    {
        $this->update_data = 'Update questions ';
        $this->update_data .= 'Set'.' ';
    }

    public function update_data(): string
    {
        return $this->update_data;
    }

    private function _fetch_data(): void
    {
        $this->fetch_data = 'Select * from questions ';
    }        

    private function _insert(): void 
    {
        $this->insert_data = 'Insert into `questions` (`code`, `fullname`, `email`, `description`'; 
        $this->insert_data .= ') VALUES (';
    }

    public function insert(array $row_data): void
    {
        $this->_insert();

        $this->insert_data .= "'".$row_data['code']."', ";
        $this->insert_data .= "'".$row_data['fullname']."', ";
        $this->insert_data .= "'".$row_data['email']."', ";
        $this->insert_data .= "'".$row_data['description']."'";
        $this->insert_data .= ')';

        $request_model = array('request' => $this->insert_data, 'query_type' => 'command');
        $this->database_link()->fulfill($request_model);
    }

    public function retrieve(array $entity_credential): array
    {
        $this->_fetch_data();
        $this->_fetch_data_sql_string($entity_credential);      

        $request_model = array('request' => $this->fetch_data, 'query_type' => 'search');
        $this->database_link()->fulfill($request_model);

        return $this->response();
    }

    public function update(array $new_info = array('request' => '', 'query_type' => '')): void
    {
        $this->update_data_sql_string($new_info);
        // var_dump($new_info['request']);

        $new_info['request'] = $this->update_data;
        // $update_string = array();
        // $update_string['update_sql'] = $this->update_data;
        // var_dump($update_string);
        $this->database_link()->fulfill($new_info);
    }

    public function delete(array $entity_code = array()): void
    {
        $this->_delete_data();
        $this->delete_data .= "'".$entity_code['row_code']."'";

        $request_model = array('request' => $this->delete_data, 'query_type' => 'command');
        var_dump($request_model);
        $this->database_link()->fulfill($request_model);
    }

    public function table_setup(): void
    {
        $this->_table_creation();
        $request_model =  array('request' => $this->table_creation(), 'query_type' => 'command');
        $this->database_link()->fulfill($request_model);
    }

    public function drop_table(): void
    {
        $this->_table_drop();
        $request_model = array('request' => $this->table_drop, 'query_type' => 'command');
        $this->database_link()->fulfill($request_model);
    }

    public function response(): array
    {
        return $this->response = $this->database_link()->response_packet();
    }

    public function connection(array $credentials = array(), string $database = '', bool $select_database = false, bool $new_db = false): void
    {
        $this->database_link()->reconstruct($credentials, $database, $select_database, $new_db);
    }

    public function connection_successful(): bool
    {
        return $this->database_link()->completed_base_setup();
    }

    public function drop_connection(): void
    {
        $this->database_link()->disconnect();
    }

    public function count(): string
    {
        $sql = 'Select count(*) from questions';
        $request_model = array('request' => $sql, 'query_type' => 'search');
        $this->database_link()->fulfill($request_model);

        $response = $this->database_link()->response_packet();
        $response = $response['response'];
        $response = $response['assoc']['count(*)'];
        
        return $response;
    }

    public function all_rows(): array
    {
        $request_model = array('request' => 'Select * from questions', 'query_type' => 'search');
        $this->database_link()->fulfill($request_model);
        $response = $this->database_link()->response_packet();
        var_dump($response);
        $response = $response['response'];

        return $response;
    }

    public function last_code(): string
    {
        $sql = 'select * from questions order by questions.code desc limit 1';
        $request = array('request' => $sql, 'query_type' => 'search');
        $this->database_link()->fulfill($request);
        // $last_code = array();

        $response = $this->database_link()->response_packet();
        $response = $response['response'];
        $successful = ($response['status'] === 'ok');

        if($successful)
        {
            // $last_code['successful'] = 'true';
            // $last_code['last_code'] = $response['assoc'];
            // var_dump($last_code);
            return $response['assoc']['code'];
        }
        else 
        {
            return '0';
        }
    }

    public function database_link(): IDatabase
    {
        return $this->db_link;
    }

    public function database_created(): bool
    {
        return true;
    }

    //Mutator & Accessor Method Helpers
    /**
     * Class Accessor-Builder method
     *
     * @return array
     */
    private function state(): array
    {
        return $class_info = array('update_data' => $this->update_data(), 'database' => $this->response()); 
        // 'sirname' => $this->sirname(), 'email' => $this->email(),
        // 'password' => $this->password(), 'code' => $this->code()
    }

    public function information(string $name = '', bool $summary = false): array
    {
        $class_info = $this->state();
        $empty = ($this->initialized_name($name));
        $single_attribute = ($empty) ? array($name => $class_info[$name]) : '';
        return $information = ($this->request_summary($summary)) ? $class_info : $single_attribute;
    }

    public function update_data_sql_string(array $request_model): void 
    {
        $this->_update_data();
        $equals = '=';
        $table = 'questions.';
        $assoc_to_numerical_keys = $this->numerical_keys($request_model);

        $this->_assoc_array_numerical_keys_size($assoc_to_numerical_keys);
        $this->_penultimate_element_key();
        $this->_penultimate_element_key_name($assoc_to_numerical_keys);

        $this->_antepenultimate_key($assoc_to_numerical_keys);
        $this->_antepenultimate_key_name($assoc_to_numerical_keys);
        //test code
        // $last_element_key['antepenultimate_key'] = $this->antepenultimate_key();
        // $last_element_key['antepenultimate_key_name'] = $this->antepenultimate_key_name();
        // var_dump($last_element_key);
        
        $where_clause = $request_model['request']['where'];
        $this->_where_key();
        $this->_where_key_element($assoc_to_numerical_keys);

        $this->foreach_field_update($request_model, $assoc_to_numerical_keys, $table, $equals);
        $this->update_data .= 'Where questions.code'.' '.$equals.' '."'".$where_clause."'";
    }

    private function foreach_field_update(array $request_model, array $assoc_to_numerical_keys, string $table, string $equals): void 
    {
        $iterable_size = ($this->assoc_array_numerical_keys_size() >= 3);

        if($iterable_size)
        {
            $this->multiple_field_update($request_model, $assoc_to_numerical_keys, $table, $equals);
        }
        else 
        {
            $this->single_field_update($request_model, $assoc_to_numerical_keys, $table, $equals);
        }
    }

    private function multiple_field_update(array $request_model, array $assoc_to_numerical_keys, string $table, string $equals): void 
    {
        $request_model = $request_model['request'];
        foreach ($request_model as $fields => $updated_field_values) 
        {
            $key_pointer = array_search($fields, $assoc_to_numerical_keys, true);

            $penultimate_element_key_located = (($key_pointer === $this->penultimate_element_key()) && ( $fields === $this->penultimate_element_key_name()));

            $antepenultimate_element_key_located = (($key_pointer === $this->antepenultimate_key() ) && 
                                            ($fields === $this->antepenultimate_key_name())
                                            && (!$penultimate_element_key_located));

            $where_key_located = (($key_pointer === $this->where_key()) && ($fields === $this->where_key_element()));

            $located_preantepenultimate_element_key = ((!$antepenultimate_element_key_located) && (!$where_key_located) 
                                                                    && (!$penultimate_element_key_located));

            if($located_preantepenultimate_element_key)
            {
                $this->update_data .= $table.$fields.' '.$equals.' '."'".$updated_field_values."', ";
            }
            elseif ($antepenultimate_element_key_located) 
            {
                $this->update_data .= $table.$fields.' '.$equals.' '."'".$updated_field_values."', ";
            }
            elseif ($penultimate_element_key_located) 
            {
                $this->update_data .= $table.$fields.' '.$equals.' '."'".$updated_field_values."' ";
            }
            elseif($where_key_located)
            {
                continue;
            }
        }
        unset($fields);
    }

    private function single_field_update(array $request_model, array $assoc_to_numerical_keys, string $table, string $equals): void 
    {
        $key_pointer = array_search($this->antepenultimate_key_name(), $assoc_to_numerical_keys, true);
        $updated_field_values = $request_model['request'][$this->antepenultimate_key_name()];

        $first_element_key = (($key_pointer === $this->antepenultimate_key()));

        if($first_element_key)
        {
            $this->update_data .= $table.$this->antepenultimate_key_name().' '.$equals.' '."'".$updated_field_values."' ";
        }
        else
        {
            return;
        }
    }

    public function _fetch_data_sql_string(array $entity_credential): void 
    {
        $fullname_data = $entity_credential['fullname'];
        $email_data = $entity_credential['email'];
        $code_data = $entity_credential['code'];
        $fields_state = array();

        $this->fetch_data_sql_credential_policy($fullname_data, $email_data, $code_data);
        $fetch_data_sql_credential_policy_fields = $this->fetch_data_sql_credential_policy_fields();
        $this->one_field_has_valid_data_policy($fetch_data_sql_credential_policy_fields['set_fullname'], 
        $fetch_data_sql_credential_policy_fields['set_email'],$fetch_data_sql_credential_policy_fields['set_code']);
        $this->two_fields_has_valid_data_policy($fetch_data_sql_credential_policy_fields['set_fullname'], 
        $fetch_data_sql_credential_policy_fields['set_email'], $fetch_data_sql_credential_policy_fields['set_code']);
        
        //reason why na is in the read strings sql when there is only one field
        //to be updated. And you have
        $this->all_fields_has_valid_data_policy($fetch_data_sql_credential_policy_fields['set_fullname'], 
        $fetch_data_sql_credential_policy_fields['set_email'], $fetch_data_sql_credential_policy_fields['set_code']);
        if($this->all_fields_has_valid_data()) 
        {
            $this->fetch_data .= 'Where questions.code = '."'".$code_data."'";
            $this->fetch_data .= ' OR questions.email = '."'".$email_data."'";
            $this->fetch_data .= ' OR questions.fullname = '."'".$fullname_data."'";
        }
        elseif($this->one_field_has_valid_data())
        {
            $fields_state = $this->one_field_policy_fields_state();
            $this->single_field_fetch_data_sql($fields_state['code_valid'], $fields_state['email_valid'], 
            $fields_state['fullname_valid'], $entity_credential);
        }
        elseif($this->two_fields_has_valid_data())
        {
            $fields_state = $this->two_fields_policy_fields_state();
            $this->duo_field_fetch_data_sql($fields_state['fullname_email_valid'], 
            $fields_state['email_code_valid'], $fields_state['fullname_code_valid'], $entity_credential);
        }
        else
        {
            //this block takes care of:
            //all fields don't have valid data
            //a rare case occurrence
            return;
        }
        $fetch_sql['fetch_sql'] = $this->fetch_data;
        var_dump($fetch_sql);
    }

    private function single_field_fetch_data_sql(bool $code_valid, bool $email_valid, bool $fullname_valid, array $entity_credential): void 
    {
        $fullname_data = $entity_credential['fullname'];
        $email_data = $entity_credential['email'];
        $code_data = $entity_credential['code'];

        if($code_valid) 
        {
            $this->fetch_data .= ' Where questions.code = '."'".$code_data."'";
        }
        elseif($email_valid) 
        {
            $this->fetch_data .= ' Where questions.email = '."'".$email_data."'";
        }
        elseif($fullname_valid) 
        {
            $this->fetch_data .= ' Where questions.fullname = '."'".$fullname_data."'";
        }
        else 
        {
            return;
        }
    }

    private function duo_field_fetch_data_sql(bool $fullname_email_valid, bool $email_code_valid, bool $fullname_code_valid, array $entity_credential): void 
    {
        $fullname_data = $entity_credential['fullname'];
        $email_data = $entity_credential['email'];
        $code_data = $entity_credential['code'];

        if($fullname_email_valid) 
        {
            $this->fetch_data .= ' Where questions.email = '."'".$email_data."'";
            $this->fetch_data .= ' OR questions.fullname = '."'".$fullname_data."'";
        }
        elseif($email_code_valid) 
        {
            $this->fetch_data .= ' Where questions.email = '."'".$email_data."'";
            $this->fetch_data .= ' OR questions.code = '."'".$code_data."'";
        }
        elseif($fullname_code_valid) 
        {
            $this->fetch_data .= ' Where questions.fullname = '."'".$fullname_data."'";
            $this->fetch_data .= ' OR questions.code = '."'".$code_data."'";
        }
        else
        {
            return;
        }
    }

    private function fetch_data_sql_credential_policy($fullname_data, $email_data, $code_data): void
    {
        $set_fullname = (($fullname_data !== 'na') || ($fullname_data !== 'empty'));
        $set_email = (($email_data !== 'na') || ($email_data !== 'empty'));
        $set_code = (($code_data !== 'na') || ($code_data !== 'empty'));

        $fetch_data_sql_credential_policy_fields = array('set_fullname' => $set_fullname,
        'set_email' => $set_email,
        'set_code' => $set_code);

        $this->_fetch_data_sql_credential_policy_fields($fetch_data_sql_credential_policy_fields);
    }

    private function all_fields_has_valid_data_policy(bool $set_fullname, bool $set_email, bool $set_code): void
    {
        $all_fields_valid = (($set_fullname) && ($set_email) && ($set_code));
        $this->_all_fields_has_valid_data($all_fields_valid);
    }

    private function one_field_has_valid_data_policy(bool $set_fullname, bool $set_email, bool $set_code): void
    {
        $code_valid = ((!$set_fullname) && (!$set_email) && ($set_code));
        $email_valid = ((!$set_fullname) && ($set_email) && (!$set_code));
        $fullname_valid = (($set_fullname) && (!$set_email) && (!$set_code));

        $one_field_has_valid_data = (($code_valid) || ($email_valid) || ($fullname_valid));
        
        $this->one_field_state_array_setup($code_valid, $email_valid, $fullname_valid);
        $this->_one_field_has_valid_data($one_field_has_valid_data);
    }

    private function one_field_state_array_setup(bool $code_valid, bool $email_valid, bool $fullname_valid): void 
    {
        $fields_state_for_one_field = array('fullname_valid' => $fullname_valid, 
        'email_valid' => $email_valid,
        'code_valid' => $code_valid);
        $this->_one_field_policy_fields_state($fields_state_for_one_field);
    }
    
    private function two_fields_has_valid_data_policy($set_fullname, $set_email, $set_code): void
    {
        $fullname_email_valid = (($set_fullname) && ($set_email) && (!$set_code));
        $email_code_valid = ((!$set_fullname) && ($set_email) && ($set_code));
        $fullname_code_valid = (($set_fullname) && (!$set_email) && ($set_code));

        $two_fields_has_valid_data = (($fullname_email_valid) || ($email_code_valid) || ($fullname_code_valid));

        $this->two_fields_policy_fields_state_array_setup($fullname_email_valid, $email_code_valid, $fullname_code_valid);

        $this->_two_fields_has_valid_data($two_fields_has_valid_data);
    }
    
    private function two_fields_policy_fields_state_array_setup(bool $fullname_email_valid, bool $email_code_valid, bool $fullname_code_valid): void 
    {
        $fields_state_for_two_fields = array('fullname_email_valid' => $fullname_email_valid, 
        'email_code_valid' => $email_code_valid,
        'fullname_code_valid' => $fullname_code_valid);
        $this->_two_fields_policy_fields_state($fields_state_for_two_fields);
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
