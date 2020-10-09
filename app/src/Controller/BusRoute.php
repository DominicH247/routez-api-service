<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Service\BusStop\BusStopInterface;

use App\Service\BusRoute\BusRouteService;

class BusRoute extends AbstractFOSRestController
{
  private $busRouteService;

  public function __construct(BusRouteService $busRouteService)
  {
    $this->busRouteService = $busRouteService;
  }

  /**
   * @Rest\Get("/route/{operator}/{line}/{direction}/{atcocode}/{date}/{time}")
   */
  public function getBusRoute(
    string $operator,
    string $line,
    string $direction,
    string $atcocode,
    string $date,
    string $time
  ): View {

    $result = $this->busRouteService->fetchBusRoute([
      'operator' => $operator,
      'line' => $line,
      'direction' => $direction,
      'atcocode' => $atcocode,
      'date' => $date,
      'time' => $time
    ]);

    return $this->view($result, Response::HTTP_OK);
  }
}
