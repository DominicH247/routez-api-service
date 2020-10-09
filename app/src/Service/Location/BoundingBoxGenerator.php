<?php

namespace App\Service\Location;

use App\Service\Location\BoundingBoxInterface;
use App\Utility\BoundingBoxUtility;

class BoundingBoxGenerator implements BoundingBoxInterface
{

  private $boundingBoxUtil;

  public function __construct(BoundingBoxUtility $BoundingBoxUtility)
  {
    $this->boundingBoxUtil = $BoundingBoxUtility;
  }

  public function generateBoundingBox(float $distance, array $userLocation): array
  {
    if (!$userLocation || !$distance) {
      return [];
    }

    $X = $userLocation['longitude'];
    $Y = $userLocation['latitude'];
    // var_dump($X);
    // var_dump($userLocation);

    $radiusKm = $this->boundingBoxUtil->distanceToKm($distance);

    $dY = $radiusKm / $this->boundingBoxUtil::ONE_LAT;
    $dX = $dY / cos($Y * $this->boundingBoxUtil::RAD);

    return [
      'max_latitude' => $Y + $dY,
      'max_longitude' => $X + $dX,
      'min_latitude' => $Y - $dY,
      'min_longitude' => $X - $dX,
    ];
  }
}
