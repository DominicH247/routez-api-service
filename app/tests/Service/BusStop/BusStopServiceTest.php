<?php

namespace Tests\Service\BusStop;

use PHPUnit\Framework\TestCase;

use App\Service\BusStop\BusStopService;
use App\Service\Api\TransportApi;
use App\Service\Location\BoundingBoxGenerator;
use App\Service\Location\WalkDistance;

class BusStopServiceTest extends TestCase
{
  private $transportApiService;
  private $walkDistanceService;
  private $boundingBoxGeneratorService;
  private $busStopService;

  public function setUp(): void
  {
    $this->transportApiService = $this->createMock(TransportApi::class);
    $this->transportApiService->method('fetch')->willReturn(["SOME DATA"]);

    $this->walkDistanceService = $this->createMock(WalkDistance::class);
    $this->walkDistanceService->method('calculateDistance')->willReturn(135.5);

    $this->boundingBoxGeneratorService = $this->createMock(BoundingBoxGenerator::class);
    $this->boundingBoxGeneratorService->method('generateBoundingBox')->willReturn(['SOME DATA']);

    $this->busStopService = new BusStopService(
      $this->transportApiService,
      $this->walkDistanceService,
      $this->boundingBoxGeneratorService
    );
  }

  public function tearDown(): void
  {
    $this->transportApiService = null;
    $this->walkDistanceService = null;
    $this->boundingBoxGeneratorService = null;
    $this->busStopService = null;
  }

  public function testFetchBusStopByCode()
  {
    $result = $this->busStopService->fetchBusStopByCode('490000077D');

    $this->assertEquals(["SOME DATA"], $result);
  }

  public function testFetchNearestBusStop()
  {
    $result = $this->busStopService->testFetchNearestBusStop(['userLocation']);

    $this->assertEquals(["SOME DATA"], $result);
  }
}
