<?php

namespace App\Service\Location;

interface BoundingBoxInterface
{
  /**
   * Generates bounding box based on user location coords and distance
   * @return array
   * @param array array of coordinates
   * @param integer distance in meters
   */
  public function generateBoundingBox(float $distance, array $userLocation): array;
}
