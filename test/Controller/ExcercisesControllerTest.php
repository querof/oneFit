<?php

namespace test\Controller;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as Client;

class ExcercisesControllerTest extends TestCase
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
        $response = $this->http->request('GET', 'excercises');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testGet()
    {

        $response = $this->http->request('POST', 'excercises', ['query' => ['name' => 'Ex','description' => 'Des. Ex','token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $response = $this->http->request('GET', 'excercises/'.$data['id']);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testSearch()
    {
        $response = $this->http->request('GET', 'excercises/search', ['query' => ['params' => '{"excercises":{"name":{"value":"Ex"}}}' ]]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testSave()
    {
        $response = $this->http->request('POST', 'excercises', ['query' => ['name' => 'Ex. Test API', 'description' => 'Ex Des Test API','token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $response = $this->http->request('PUT', 'excercises/'.$data['id'], ['query' => ['name' => 'excercises Test API Mod', 'description' => 'Des Test API Mod','token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testDelete()
    {
        $response = $this->http->request('POST', 'excercises', ['query' => ['name' => 'excercises Test API Delete', 'description' => 'Des Test API Delete','token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $response = $this->http->request('DELETE', 'excercises/'.$data['id'], ['query' => ['token' => $this->token]]);

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
