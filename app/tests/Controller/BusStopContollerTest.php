<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class BusStopControllerTests extends TestCase
{

  private $http;

  public function setUp(): Void
  {
    $this->http = new Client([
      'base_uri' => 'http://nginx-container:80/api/busStop/',
      'defaults' => [
        'headers'  => ['content-type' => 'application/json', 'Accept' => 'application/json'],
      ]
    ]);
  }

  public function tearDown(): Void
  {
    $this->http = null;
  }

  public function testGetBusStopSuccess200()
  {
    $response = $this->http->request('GET', '490000077D');
    $this->assertEquals(200, $response->getStatusCode());

    $contentType = $response->getHeaders()["Content-Type"][0];
    $this->assertEquals("application/json", $contentType);
  }

  public function testGetBusStopFailedNotFound400()
  {
    $response = $this->http->get('TEST', ['http_errors' => false]);
    $this->assertEquals(404, $response->getStatusCode());

    $this->assertEquals(
      "Not Found",
      json_decode($response->getBody(), true)['error']['message']
    );

    $contentType = $response->getHeaders()["Content-Type"][0];
    $this->assertEquals("application/json", $contentType);
  }

  public function testGetBusNearestBusStopsSuccess200()
  {
    $response = $this->http->request('GET', '?lat=51.55597&lon=-0.2797&distance_mins=5');
    $this->assertEquals(200, $response->getStatusCode());

    $contentType = $response->getHeaders()["Content-Type"][0];
    $this->assertEquals("application/json", $contentType);
  }


  public function testGetBusNearestBusStopsFailedMissingParam400()
  {
    $response = $this->http->get('?lon=-0.2797&distance_mins=5', ['http_errors' => false]);
    $this->assertEquals(400, $response->getStatusCode());

    $this->assertEquals(
      "Parameter lat of value NULL violated a constraint This value should not be null.",
      json_decode($response->getBody(), true)['error']['message']
    );

    $contentType = $response->getHeaders()["Content-Type"][0];
    $this->assertEquals("application/json", $contentType);
  }

  public function testGetBusNearestBusStopsFailedDistanceParam400()
  {
    $response = $this->http->get('?lat=53.801277&lon=-0.2797&distance_mins=TEST', ['http_errors' => false]);
    $this->assertEquals(400, $response->getStatusCode());

    $this->assertEquals(
      "Parameter distance_mins of value TEST violated a constraint Parameter 'distance_mins' value, does not match requirements '\d+'",
      json_decode($response->getBody(), true)['error']['message']
    );

    $contentType = $response->getHeaders()["Content-Type"][0];
    $this->assertEquals("application/json", $contentType);
  }

  public function testGetBusNearestBusStopsFailedLongitude400()
  {
    $response = $this->http->get('?lat=53.801277&lon=TEST&distance_mins=5', ['http_errors' => false]);
    $this->assertEquals(400, $response->getStatusCode());

    $this->assertEquals(
      "Parameter lon of value TEST violated a constraint Parameter 'lon' value, does not match requirements '[-0-9.]+'",
      json_decode($response->getBody(), true)['error']['message']
    );

    $contentType = $response->getHeaders()["Content-Type"][0];
    $this->assertEquals("application/json", $contentType);
  }
}
