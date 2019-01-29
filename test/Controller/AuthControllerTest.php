<?php

namespace test\Controller;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as Client;

class AuthControllerTest extends TestCase
{
    private $http;


    public function setUp()
    {
        $this->http = new Client(['base_uri' => 'localhost/jobs/oneFit/web/index.php/']);
    }

    public function tearDown()
    {
        $this->http = null;
    }

    public function testSignin()
    {
        $response = $this->http->request('POST', 'auth/signin', ['query' => ['params' =>'{"user":{"email":{"value":"querof@gmail.com"},"password":{"value":"darkside"}}}']]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $response = $this->http->request('GET', 'auth', ['query' => ['token' => $data['token']]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }
}
