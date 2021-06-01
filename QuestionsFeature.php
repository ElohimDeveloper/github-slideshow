<?php
declare(strict_types = 1);

$request_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Interface/Request.php';
$response_path = $_SERVER['DOCUMENT_ROOT'] . '/Air_Pollution_DWEB/Interface/Response.php';
require_once($response_path);
require_once($request_path);

class QuestionsFeature implements Request
{
    private $request = null;
    private $response = null;

    public function __construct($client_request, Response $domain_module)
    {
        $this->_request($client_request);
        $this->response = $domain_module->respondTo($this);
    }

    private function _request($client_request): void
    {
        $assoc = true;
        $this->request = json_decode($client_request, $assoc);
    }

    public function packet(): array
    {
        return $this->request;
    }

    public function json()
    {
        return json_encode($this->response, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES);
    }
}
