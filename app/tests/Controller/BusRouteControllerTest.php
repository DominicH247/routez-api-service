<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class BusRouteControllerTests extends TestCase
{
  private $http;

  public function setUp(): Void
  {
    $this->http = new Client([
      'base_uri' => 'http://nginx-container:80/api/route/',
      'defaults' => [
        'headers'  => ['content-type' => 'application/json', 'Accept' => 'application/json'],
      ]
    ]);
  }

  public function tearDown(): Void
  {
    $this->http = null;
  }

  public function testGetBusRouteSuccess200()
  {
    $response = $this->http->request('GET', 'MTLN/30/outbound/490000077D/2020-08-28/01:16?');
    $this->assertEquals(200, $response->getStatusCode());

    $contentType = $response->getHeaders()["Content-Type"][0];
    $this->assertEquals("application/json", $contentType);
  }

  public function testGetBusRouteFailedNoRouteFound404()
  {
    $response = $this->http->get('MTLN/30//490000077D/2020-08-28/01:16?', ['http_errors' => false]);
    $this->assertEquals(404, $response->getStatusCode());

    $this->assertEquals(
      "No route found for GET /api/route/MTLN/30//490000077D/2020-08-28/01:16",
      json_decode($response->getBody(), true)['error']['message']
    );

    $contentType = $response->getHeaders()["Content-Type"][0];
    $this->assertEquals("application/json", $contentType);
  }

  public function testGetBusRouteFailedNotFound404()
  {
    $response = $this->http->get('MTLN/30/outbound/THISISATEST/2020-08-28/01:16?', ['http_errors' => false]);
    $this->assertEquals(404, $response->getStatusCode());

    $this->assertEquals(
      "Not Found",
      json_decode($response->getBody(), true)['error']['message']
    );

    $contentType = $response->getHeaders()["Content-Type"][0];
    $this->assertEquals("application/json", $contentType);
  }

  public function testGetBusRouteServerError500()
  {
    $response = $this->http->get('MTLN/30/outbound/490000077D/2020-08-28/999:999?', ['http_errors' => false]);
    $this->assertEquals(500, $response->getStatusCode());

    $this->assertEquals(
      "Internal Server Error",
      json_decode($response->getBody(), true)['error']['message']
    );

    $contentType = $response->getHeaders()["Content-Type"][0];
    $this->assertEquals("application/json", $contentType);
  }
}
