<?php

namespace test\Controller;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as Client;

class UserPlanControllerTest extends TestCase
{
    private $http;

    private $token;

    private $planId;

    private $userId;


    public function setUp()
    {
        $this->http = new Client(['base_uri' => 'localhost/jobs/oneFit/web/index.php/']);

        $this->setToken();
        $this->setUserPlan();
    }

    public function tearDown()
    {
        $this->http = null;
    }

    public function testList()
    {
        $response = $this->http->request('GET', 'userplan');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testGet()
    {
        $response = $this->http->request('POST', 'userplan', ['query' => ['userId' => $this->userId, 'planId' => $this->planId, 'token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $response = $this->http->request('GET', 'userplan/'.$data['id']);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testSearch()
    {
        $response = $this->http->request('POST', 'userplan', ['query' => ['userId' => $this->userId, 'planId' => $this->planId,'token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $response = $this->http->request('GET', 'userplan/search', ['query' => ['params' => '{"user_plan":{"id":{"function":"count"}},"plan":{"id":{"value":"'.$data['id'].'","order":"asc","group":true}},"user":{"email":{"order":"asc","group":true}}}']]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testSave()
    {
        $response = $this->http->request('POST', 'userplan', ['query' => ['userId' => $this->userId, 'planId' => $this->planId,'token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testDelete()
    {
        $response = $this->http->request('POST', 'userplan', ['query' => ['userId' => $this->userId, 'planId' => $this->planId,'token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $response = $this->http->request('DELETE', 'userplan/'.$data['id'], ['query' => ['token' => $this->token]]);

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

    private function setUserPlan()
    {
        $numberRnd = rand(0, 9999);

        $response = $this->http->request('POST', 'user', ['query' => ['name'=>'User-'.$numberRnd,'lastname'=>'UserLastname-'.$numberRnd,'email' => 'querof'.$numberRnd.'@gmail.com','weight' => 100 ,'size'=> 2, 'password' =>'1234', 'token' => $this->token ]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->userId = $data['id'];

        $response = $this->http->request('POST', 'plan', ['query' => ['name' => 'UserPlan Test API Delete', 'description' => 'Des Test API Set','token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->planId = $data['id'];
    }
}
