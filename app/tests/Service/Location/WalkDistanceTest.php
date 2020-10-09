<?php

namespace App\Tests\Service\Location;

use PHPUnit\Framework\TestCase;
use App\Service\Location\WalkDistance;

class WalkDistanceTest extends TestCase
{
  public function testCalculateDistance(): void
  {
    $walkService = new WalkDistance(1.4);

    $result1 = $walkService->calculateDistance(5);
    $result2 = $walkService->calculateDistance(10);

    $this->assertEquals($result1, 420.0);
    $this->assertEquals($result2, 840.0);
  }
}
