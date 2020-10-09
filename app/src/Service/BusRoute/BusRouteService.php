<?php

namespace App\Service\BusRoute;

use App\Service\Api\TransportApi;
use App\Service\BusRoute\BusRouteFormatter;

class BusRouteService
{
  private $transportApi;
  private $busRouteFormatter;

  public function __construct(TransportApi $transportApi, BusRouteFormatter $busRouteFormatter)
  {
    $this->transportApi = $transportApi;
    $this->busRouteFormatter = $busRouteFormatter;
  }

  /**
   * fetch the bus route for specified service departing from bus stop
   * @return array bus route coordinates
   * @param array args for retrieval of route
   */
  public function fetchBusRoute(array $args): array
  {
    $operator = $args['operator'];
    $line = $args['line'];
    $direction = $args['direction'];
    $atcocode = $args['atcocode'];
    $date = $args['date'];
    $time = $args['time'];

    $uri = "bus/route/{$operator}/{$line}/{$direction}/{$atcocode}/{$date}/{$time}/timetable.json";

    $queryParams = [
      'edge_geometry' => true,
      'stops' => 'onward'
    ];

    $routes = $this->transportApi->fetch($uri, $queryParams);

    return $this->busRouteFormatter->formatRoutes($routes);
  }
}
