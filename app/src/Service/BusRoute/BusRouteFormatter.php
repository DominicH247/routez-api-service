<?php

namespace App\Service\BusRoute;

class BusRouteFormatter
{
  public function formatRoutes(array $routes)
  {
    $coords = [];
    $stops = [];

    foreach ($routes['stops'] as $stop) {
      if (isset($stop['next']['coordinates'])) {
        array_push($coords, ...$stop['next']['coordinates']);
      } else {
        array_push($coords, [$stop['latitude'], $stop['longitude']]);
      }

      array_push($stops, [
        'time' => $stop['time'],
        'name' => $stop['name'],
        'atcocode' => $stop['atcocode'],
        'latitude' => $stop['latitude'],
        'longitude' => $stop['longitude']
      ]);
    }

    return [
      'route' => $coords,
      'stops' => $stops
    ];
  }
}
