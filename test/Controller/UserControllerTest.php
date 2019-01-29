<?php

namespace test\Controller;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as Client;

class UserControllerTest extends TestCase
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
        $response = $this->http->request('GET', 'user');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testGet()
    {
        $numberRnd = rand(0, 9999);

        $response = $this->http->request('POST', 'user', ['query' => ['name'=>'User-'.$numberRnd,'lastname'=>'UserLastname-'.$numberRnd,'email' => 'querof'.$numberRnd.'@gmail.com','weight' => 100 ,'size'=> 2, 'password' =>'1234', 'token' => $this->token ]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $response = $this->http->request('GET', 'user/'.$data['id']);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testSearch()
    {
        $response = $this->http->request('GET', 'user/search', ['query' => ['params' => '{"user":{"email":{"value":"querof@gmail.com"}}}' ]]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testSave()
    {
        $numberRnd = rand(0, 9999);

        $response = $this->http->request('POST', 'user', ['query' => ['name'=>'User-'.$numberRnd,'lastname'=>'UserLastname-'.$numberRnd,'email' => 'querof'.$numberRnd.'@gmail.com','weight' => 100 ,'size'=> 2,'password' =>'1234', 'token' => $this->token ]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $numberRnd = rand(0, 9999);

        $response = $this->http->request('PUT', 'user/'.$data['id'], ['query' => ['name'=>'User-'.$numberRnd,'lastname'=>'UserLastname-'.$numberRnd,'email' => 'querof'.$numberRnd.'@gmail.com','weight' => 100 ,'size'=> 2,'password' =>'1234', 'token' => $this->token ]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testDelete()
    {
        $numberRnd = rand(0, 9999);

        $response = $this->http->request('POST', 'user', ['query' => ['name'=>'User-'.$numberRnd,'lastname'=>'UserLastname-'.$numberRnd,'email' => 'querof'.$numberRnd.'@gmail.com','weight' => 100 ,'size'=> 2,'password' =>'1234', 'token' => $this->token ]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $response = $this->http->request('DELETE', 'user/'.$data['id'], ['query' => ['token' => $this->token]]);

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
