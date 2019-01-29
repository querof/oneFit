<?php

namespace test\Controller;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as Client;

class WorkoutDaysExcercisesControllerTest extends TestCase
{
    private $http;

    private $token;

    private $workoutDaysId;

    private $excercisesId;


    public function setUp()
    {
        $this->http = new Client(['base_uri' => 'localhost/jobs/oneFit/web/index.php/']);

        $this->setToken();
        $this->setWorkoutDaysExcercises();
    }

    public function tearDown()
    {
        $this->http = null;
    }

    public function testList()
    {
        $response = $this->http->request('GET', 'workoutdaysexcercises');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testGet()
    {
        $response = $this->http->request('POST', 'workoutdaysexcercises', ['query' => ['workoutDaysId' => $this->workoutDaysId, 'excercisesId' => $this->excercisesId, 'repetitions' => 3, 'token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $response = $this->http->request('GET', 'workoutdaysexcercises/'.$data['id']);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testSearch()
    {
        $response = $this->http->request('GET', 'workoutdaysexcercises/search', ['query' => ['params' => '{"workout_days":{"name":{"value":"Leg Day","group":true}},"workout_days_excercises":{"id":{"order":"asc","group":true}},"excercises":{"name":{"order":"asc","group":true}}}']]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testSave()
    {
        $response = $this->http->request('POST', 'workoutdaysexcercises', ['query' => ['workoutDaysId' => $this->workoutDaysId, 'excercisesId' => $this->excercisesId, 'repetitions' => 5, 'token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testDelete()
    {
        $response = $this->http->request('POST', 'workoutdaysexcercises', ['query' => ['workoutDaysId' => $this->workoutDaysId, 'excercisesId' => $this->excercisesId, 'repetitions' => 6, 'token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $response = $this->http->request('DELETE', 'workoutdaysexcercises/'.$data['id'], ['query' => ['token' => $this->token]]);

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

    private function setWorkoutDaysExcercises()
    {
        $numberRnd = rand(0, 9999);

        $response = $this->http->request('POST', 'plan', ['query' => ['name' => 'UserPlan Test API Delete', 'description' => 'Des Test API Set','token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $response = $this->http->request('POST', 'workoutdays', ['query' => ['name' => 'Workout Day - '.$numberRnd,'description' => 'Des. - '.$numberRnd,'planId' => $data['id'],'weekday'=>'MON','token' => $this->token]]);

        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->workoutDaysId = $data['id'];

        $response = $this->http->request('POST', 'excercises', ['query' => ['name' => 'Ex. Test API - '.$numberRnd, 'description' => 'Ex Des Test API - '.$numberRnd,'token' => $this->token]]);


        $body = $response->getBody();
        $data = json_decode($body->getContents(), true);

        $this->excercisesId = $data['id'];
    }
}
