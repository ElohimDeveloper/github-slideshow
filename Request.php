<?php
declare(strict_types = 1);

interface Request 
{
    /**
     * Accepts request data
     * Expects named associative
     * keys relevant to the;
     * Use Case Scenario
     * 
     * Standard request structure:
     * data => field name => .....
     *         field name => .....
     * type => e.g. add etc.
     *
     * @return array
     */
    public function packet(): array;

    /**
     * Converts response to 
     * Client input format 
     *
     * @return mixed
     */
    public function json();

    
}

?>