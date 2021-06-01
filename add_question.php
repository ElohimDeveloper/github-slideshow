<?php
declare(strict_types = 1);

session_start();
$question_feature_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Use_Cases/QuestionsFeature.php';
require_once($question_feature_path);

$questions_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/requirements_catalogue/Questions/php/Questions.php';
require_once($questions_path);

$mysql_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Infrastructure/Storage/MySql/php/MySql.php';
require_once($mysql_path);

$questions_table_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Infrastructure/Storage/QuestionsTable/php/QuestionsTable.php';
require_once($questions_table_path);

$add_questions_req = file_get_contents("php://input");
// var_dump($add_questions_req);


$default_credentials = array('host' => 'localhost', 'user' => 'root', 'code' => '');
$select_database = true;
// $new_db = false;
$database = 'users_etc';

$domain_module = new Questions();
$dependency = array('module_table' => 
new QuestionsTable(new MySql($default_credentials, $database, $select_database)));
$domain_module->_construct($dependency);

$use_case = new QuestionsFeature($add_questions_req, $domain_module);

echo $use_case->json();
