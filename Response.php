<?php
declare(strict_types = 1);

$request_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Interface/Request.php';
require_once($request_path);

interface Response 
{
    /**
     * Expects named associative
     * keys relevant to the;
     * Use Case Scenario
     * 
     * Standard (expected) response structure:
     * status => fail or ok
     * success => field name => correct....
     *            field name => .....
     *            none
     * error => field name => not added/not found/not deleted/not updated/incorrect...
     *          field name => ....
     *          none
     *
     * @param Request $use_case
     * @return array
     */
    public function respondTo(Request $use_case = null): array;

    public function _construct(array $dependency): void;
}

?>