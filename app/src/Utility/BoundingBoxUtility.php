<?php

namespace App\Utility;

class BoundingBoxUtility
{
  /**
   * Radius of Earth in m
   */
  const EARTH_RADIUS = 6371e3;

  /**
   * Rad degree
   */
  const RAD = 0.01745;

  /**
   * One degree of latitude ~ 111.1 km
   */
  const ONE_LAT = 111.1;

  /**
   * Convert distance in m to Km
   * @return float
   * @param float distance in m 
   */
  public function distanceToKm(float $distance): float
  {
    return $distance / 1000;
  }
}
