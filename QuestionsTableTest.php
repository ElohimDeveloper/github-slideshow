<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertContainsEquals;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

$mysql_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Infrastructure/Storage/MySql/php/MySql.php';
require_once($mysql_path);
$questions_table_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Infrastructure/Storage/QuestionsTable/php/QuestionsTable.php';
require_once($questions_table_path);
// require_once('Infrastructure\Storage\QuestionsTable\php\QuestionsTable.php');

class QuestionsTableTest extends TestCase
{
    private $questions_table = null;

     public function test_questions_table_is_dropped()
    {
        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        // $new_db = false;
        $database = 'users_etc';

        $this->_table(new QuestionsTable(new MySql($default_credentials, $database, $select_database)));

        $this->table()->drop_table();

        $response = $this->table()->response();
        $response = $response['response'];

        $expected_status = 'ok';

        assertContainsEquals($expected_status, $response);
    }

     public function test_serverLogin_and_database_creation() 
    {
        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        $new_db = true;
        $database = 'users_etc';

        $this->_table(new QuestionsTable(new MySql()));
        $this->table()->connection($default_credentials, $database, $select_database, $new_db);
        
        assertTrue($this->table()->connection_successful());
        $this->table()->drop_connection();
    }

    public function test_questions_table_is_created_successfully()
    {
        //open db connection
        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        // $new_db = false;
        $database = 'users_etc';

        $this->_table(new QuestionsTable(new MySql($default_credentials, $database, $select_database)));

        //Build request model-containing the the built table query and execute
        $this->table()->table_setup();

        //Get status key value from associative array.
        $response = $this->table()->response();
        $response = $response['response'];// this line of code does not lend well to a proper developer (user) experience

        $expected_status = 'ok';
        assertContainsEquals($expected_status, $response);
        $this->table()->drop_connection();
    }

     public function test_questions_data_is_stored_in_table()
    {
        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        // $new_db = false;
        $database = 'users_etc';

        $this->_table(new QuestionsTable(new MySql($default_credentials, $database, $select_database)));
        
        $row_data = array('fullname' => 'josiah tobas', 'description' => 'TrinidadCaymanTobago', 
                    'email' => 'jtobas@elohimbaraenterprises.org', 'code' => '001');
        $row = array('fullname' => 'joseph tobas', 'description' => 'TrinidadCaymanTobagoUSA', 
                'email' => 'strongs@elohimbaraenterprises.org', 'code' => '002');
        $this->table()->insert($row_data);
        $this->table()->insert($row);

        $response = $this->table()->response();
        $response = $response['response'];
        
        $expected_status = 'ok';
        assertContainsEquals($expected_status, $response);
    }

    public function test_questions_data_is_retrieved()
    {
        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        // $new_db = false;
        $database = 'users_etc';

        $this->_table(new QuestionsTable(new MySql($default_credentials, $database, $select_database)));

        $row = array('fullname' => 'joseph tobas', 'description' => 'TrinidadCaymanTobagoUSA', 
                'email' => 'strongs@elohimbaraenterprises.org', 'code' => '002');

        $row_data = array('email' => 'strongs@elohimbaraenterprises.org', 'fullname' => 'joseph tobas', 'code' => '002');

        $response = $this->table()->retrieve($row_data);
        $response = $response['response'];
        
        $status = 'ok';
        $code = $row["code"];
        $fullname = $row["fullname"];
        $description = $row['description'];
        $email = $row["email"];

        assertContainsEquals($status, $response);
        assertContainsEquals($code, $response['assoc']);
        assertContainsEquals($fullname, $response['assoc']);
        assertContainsEquals($description, $response['assoc']);
        assertContainsEquals($email, $response['assoc']);
    }

/*     public function test_questions_data_query_update_string_is_built_correctly()
    {
        $code = '001';
        $email = 'jpaultobas@elohimbaraenterprise.org';
        $description = 'Africa';
        $fullname = 'andrew tobas';

        $request = "Update questions Set questions.fullname = 'andrew tobas', questions.email = 'jpaultobas@elohimbaraenterprise.org', ";
        $request .= "questions.description = 'Africa'";
        $request .= " Where questions.code = '001'";

        $set = array('fullname' => $fullname, 'email' => $email, 'description' => $description, 'where' => $code);
        $request_model = array('request' => $set, 'query_type' => 'command');

        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        $new_db = false;
        $database = 'users_etc';

        $this->_table(new QuestionsTable(new MySql($default_credentials, $database, $select_database)));

        $this->table()->update_data_sql_string($request_model);

        $update = $this->table()->information('update_data');
        $update = $update['update_data'];
        
        assertEquals($request, $update);
    }
 */
    public function test_questions_data_query_update_string_is_built_correctly_with_3fields()
    {
        $code = '001';
        $email = 'jpaultobas@elohimbaraenterprise.org';
        $fullname = 'andrew tobas';

        $request = "Update questions Set questions.fullname = 'andrew tobas', questions.email = 'jpaultobas@elohimbaraenterprise.org'";
        $request .= " Where questions.code = '001'";

        $set = array('fullname' => $fullname, 'email' => $email, 'where' => $code);
        $request_model = array('request' => $set, 'query_type' => 'command');

        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        $new_db = false;
        $database = 'users_etc';

        $this->_table(new QuestionsTable(new MySql($default_credentials, $database, $select_database)));

        $this->table()->update_data_sql_string($request_model);

        $update = $this->table()->information('update_data');
        $update = $update['update_data'];
        
        assertEquals($request, $update);
    }

    public function test_questions_data_query_update_string_is_built_correctly_with_2fields()
    {
        $code = '001';
        $email = 'jpaultobas@elohimbaraenterprise.org';
        $description = 'Africa';
        $fullname = 'andrew tobas';

        $request = "Update questions Set questions.fullname = 'andrew tobas'";
        $request .= " Where questions.code = '001'";

        $set = array('fullname' => $fullname, 'where' => $code);
        $request_model = array('request' => $set, 'query_type' => 'command');

        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        $new_db = false;
        $database = 'users_etc';

        $this->_table(new QuestionsTable(new MySql($default_credentials, $database, $select_database)));

        $this->table()->update_data_sql_string($request_model);

        $update = $this->table()->information('update_data');
        $update = $update['update_data'];
        
        assertEquals($request, $update);
    }

    public function test_total_row_count()
    {
        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        $new_db = false;
        $database = 'users_etc';

        $this->_table(new QuestionsTable(new MySql($default_credentials, $database, $select_database)));

        $expected = 2;
        // $expected += 4;
        $expected = strval($expected); 
        assertEquals($expected, $this->table()->count());
    }

    public function test_last_row_is_returned()
    {
        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        $new_db = false;
        $database = 'users_etc';
        $actual = '0';

        $this->_table(new QuestionsTable(new MySql($default_credentials, $database, $select_database)));
        $actual = $this->table()->last_code();

        $expected = '002';
        assertEquals($expected, $actual);
    }

    public function test_all_rows_are_returned()
    {
        $default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
        $select_database = true;
        $new_db = false;
        $database = 'users_etc';

        $this->_table(new QuestionsTable(new MySql($default_credentials, $database, $select_database)));

        $actual = $this->table()->all_rows();

        assertArrayHasKey('assoc', $actual);
    }

    public function _table(IEntityTable $module_table = null): void
    {
        $this->questions_table = $module_table;
    }

    public function table(): IEntityTable
    {
        return $this->questions_table;
    }
}

?>
