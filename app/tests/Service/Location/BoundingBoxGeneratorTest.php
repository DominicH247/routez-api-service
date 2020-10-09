<?php

namespace App\Tests\Service\Location;

use PHPUnit\Framework\TestCase;
use App\Service\Location\BoundingBoxGenerator;
use App\Utility\BoundingBoxUtility;

class BoundingBoxGeneratorTest extends TestCase
{
  /**
   * Returns an empty array if falsey values supplied
   */
  public function testReturnEmptyObject(): void
  {
    $utility = new BoundingBoxUtility();
    $service = new BoundingBoxGenerator($utility, [], 0);
    $result = $service->generateBoundingBox(0, []);

    $this->assertEquals($result, []);
  }

  /**
   * if valid arguments supplied it returns a array containing min max of lat and long
   */
  public function testReturnBoundingBox(): void
  {
    $userLocation = [
      'latitude' => 53.801277,
      'longitude' => -1.548567
    ];
    $distance = 420;

    $utility = new BoundingBoxUtility();
    $service = new BoundingBoxGenerator($utility, $userLocation, $distance);

    $result = $service->generateBoundingBox($distance, $userLocation);

    $this->assertEquals([
      'max_latitude' => 53.8050573780378,
      'max_longitude' => -1.5421675043582261,
      'min_latitude' => 53.797496621962196,
      'min_longitude' => -1.554966495641774
    ], $result);
  }
}
