<?php

namespace App\Service\BusStop;

use App\Service\Api\TransportApi;
use App\Service\Location\BoundingBoxGenerator;
use App\Service\Location\WalkDistance;

class BusStopService
{
  private $transportApi;
  private $walkDistanceService;
  private $boundingBoxGeneratorService;

  public function __construct(
    TransportApi $transportApi,
    WalkDistance $walkDistanceService,
    BoundingBoxGenerator $boundingBoxGeneratorService
  ) {
    $this->transportApi = $transportApi;
    $this->walkDistanceService = $walkDistanceService;
    $this->boundingBoxGeneratorService = $boundingBoxGeneratorService;
  }

  /** 
   * Returns bus stop details by its atcocode from transport api
   * @param string bus stop atcocode
   * @return array bus stop detail by atcocode
   */
  public function fetchBusStopByCode(string $atcocode)
  {
    $uri = "bus/stop/{$atcocode}/live.json";

    $queryParams = [
      'group' => 'no',
      'limit' => '5',
      'nextbuses' => 'no'
    ];

    return $this->transportApi->fetch($uri, $queryParams);
  }

  /**
   * Fetch nearest bus stops based on user location from transport api
   * @param array $userLocation array of coords for user location
   * @return array an array of bus stops withing bounding box
   */
  public function fetchNearestBusStops(array $userLocation): array
  {
    $distance = $this->walkDistanceService->calculateDistance($userLocation['distance_mins']);
    $boundingBox = $this->boundingBoxGeneratorService->generateBoundingBox($distance, $userLocation['userLocation']);

    $uri = "places.json";
    $queryParams = [
      'lat' => $userLocation['userLocation']['latitude'],
      'lon' => $userLocation['userLocation']['longitude'],
      'max_lat' => $boundingBox['max_latitude'],
      'max_lon' => $boundingBox['max_longitude'],
      'min_lat' => $boundingBox['min_latitude'],
      'min_lon' => $boundingBox['min_longitude'],
      'type' => 'bus_stop'
    ];

    return $this->transportApi->fetch($uri, $queryParams);
  }
}
