<?php

namespace test\Controller;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as Client;

class PlanControllerTest extends TestCase
{
    private $http;

    private $token;


    public function setUp()
    {
        $this->http = new Client(['base_uri' => 'localhost/jobs/oneFit/web/index.php/']);

        $this->setToken();
    }

    public function tearDown()
    {
        $this->http = null;
    }

    public function testList()
    {
        $response = $this->http->request('GET', 'plan');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testGet()
    {
        $response = $this->http->request('POST', 'plan', ['query' => ['name' => 'Advanced user','token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $response = $this->http->request('GET', 'plan/'.$data['id']);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testSearch()
    {
        $response = $this->http->request('GET', 'plan/search', ['query' => ['params' => '{"plan":{"name":{"value":"Advanced user"}}}' ]]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testSave()
    {
        $response = $this->http->request('POST', 'plan', ['query' => ['name' => 'Plan Test API', 'description' => 'Des Test API','token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $response = $this->http->request('PUT', 'plan/'.$data['id'], ['query' => ['name' => 'Plan Test API Mod', 'description' => 'Des Test API Mod','token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testDelete()
    {
        $response = $this->http->request('POST', 'plan', ['query' => ['name' => 'Plan Test API Delete', 'description' => 'Des Test API Delete','token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $response = $this->http->request('DELETE', 'plan/'.$data['id'], ['query' => ['token' => $this->token]]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    private function setToken()
    {
        $response = $this->http->request('POST', 'auth/signin', ['query' => ['params' =>'{"user":{"email":{"value":"querof@gmail.com"},"password":{"value":"darkside"}}}']]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->token = $data['token'];
    }
}
