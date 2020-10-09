<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

use App\Service\BusStop\BusStopService;

class BusStop extends AbstractFOSRestController
{
  private $busStopService;

  public function __construct(BusStopService $busStopService)
  {
    $this->busStopService = $busStopService;
  }

  /**
   * Retrieves bus stop information
   * @Rest\Get("/busStop/{atcocode}", name="bus_stop_by_code")
   */
  public function getBusStopByCode(string $atcocode): View
  {
    $result = $this->busStopService->fetchBusStopByCode($atcocode);

    return $this->view($result, Response::HTTP_OK);
  }

  /**
   * Retrieves nearest bus stops based on geolocation
   * @Rest\Get("/busStop")
   * @QueryParam(name="lat", requirements="[0-9.]+",strict=true, description="latitude")
   * @QueryParam(name="lon", requirements="[-0-9.]+",strict=true, description="longitude")
   * @QueryParam(name="distance_mins", requirements="\d+",strict=true, description="distance in mins")
   * @param ParamFetcher $paramFetcher
   */
  public function getNearestBusStop(ParamFetcher $paramFetcher): View
  {
    $userLocation = [
      'latitude' => $paramFetcher->get('lat'),
      'longitude' => $paramFetcher->get('lon')
    ];

    $distance_mins = $paramFetcher->get('distance_mins');

    $result = $this->busStopService->fetchNearestBusStops([
      'userLocation' => $userLocation,
      'distance_mins' => $distance_mins,
    ]);

    return $this->view($result, Response::HTTP_OK);
  }
}
