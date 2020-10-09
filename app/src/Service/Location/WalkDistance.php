<?php

namespace App\Service\Location;

class WalkDistance
{
  /**
   * average walking speed in m/s
   */
  const AVG_WALK_SPEED = 1.4;

  /**
   * Calculates distance walked in meters
   * @param integer time in min
   * @return integer distance in m
   */
  public function calculateDistance(float $time): float
  {
    $distance = self::AVG_WALK_SPEED * ($time * 60);

    return $distance;
  }
}
