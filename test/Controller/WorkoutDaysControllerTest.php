<?php

namespace test\Controller;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as Client;

class WorkoutDaysControllerTest extends TestCase
{
    private $http;

    private $token;

    private $planId;


    public function setUp()
    {
        $this->http = new Client(['base_uri' => 'localhost/jobs/oneFit/web/index.php/']);

        $this->setToken();
        $this->setPlan();
    }

    public function tearDown()
    {
        $this->http = null;
    }

    public function testList()
    {
        $response = $this->http->request('GET', 'workoutdays');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testGet()
    {
        $response = $this->http->request('POST', 'workoutdays', ['query' => ['name' => 'Leg Day - Get Test','description' => 'Des. LegDay','planId' => $this->planId,'weekday'=>'MON','token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $response = $this->http->request('GET', 'workoutdays/'.$data['id']);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testSearch()
    {
        $response = $this->http->request('GET', 'workoutdays/search', ['query' => ['params' => '{"workout_days":{"name":{"value":"Leg Day"}},"plan":{"name":{"order":"desc"}}}' ]]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testSave()
    {
        $response = $this->http->request('POST', 'workoutdays', ['query' => ['name' => 'Leg Day - Save','description' => 'Des. LegDay - Save','planId' => $this->planId,'weekday'=>'MON','token' => $this->token]]);


        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $response = $this->http->request('PUT', 'workoutdays/'.$data['id'], ['query' => ['name' => 'workoutdays Test API Mod', 'description' => 'Des Test API Mod','token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testDelete()
    {
        $response = $this->http->request('POST', 'workoutdays', ['query' => ['name' => 'Leg Day - Delete','description' => 'Des. LegDay - Delete','planId' => $this->planId,'weekday'=>'MON','token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $response = $this->http->request('DELETE', 'workoutdays/'.$data['id'], ['query' => ['token' => $this->token]]);

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

    private function setPlan()
    {
        $numberRnd = rand(0, 9999);

        $response = $this->http->request('POST', 'plan', ['query' => ['name' => 'UserPlan Test API Delete', 'description' => 'Des Test API Set','token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->planId = $data['id'];
    }
}
