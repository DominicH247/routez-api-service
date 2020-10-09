<?php

namespace Tests\Service\BusRoute;

use PHPUnit\Framework\TestCase;

use App\Service\Api\TransportApi;
use App\Service\BusRoute\BusRouteFormatter;
use App\Service\BusRoute\BusRouteService;

class BusRouteServiceTest extends TestCase
{
  private $transportApiService;
  private $busRouteFormatter;

  public function setUp(): void
  {
    $this->transportApiService = $this->createMock(TransportApi::class);
    $this->transportApiService->method('fetch')->willReturn(['COORDINATES']);

    $this->busRouteFormatter = $this->createMock(BusRouteFormatter::class);
    $this->busRouteFormatter->method('formatRoutes')->willReturn(['COORDINATES', 'FORMATTED ROUTES']);
  }

  public function tearDown(): void
  {
    $this->transportApiService = null;
    $this->busRouteFormatter = null;
  }

  public function testFetchBusRoute(): void
  {
    $busRouteService = new BusRouteService($this->transportApiService, $this->busRouteFormatter);

    $args = [
      'operator' => 'TEST',
      'line' => 'TEST',
      'direction' => 'TEST',
      'atcocode' => 'TEST',
      'date' => 'TEST',
      'time' => 'TEST'
    ];

    $result = $busRouteService->fetchBusRoute($args);

    var_dump($result);

    $this->assertEquals(['COORDINATES', 'FORMATTED ROUTES'], $result);
  }
}
