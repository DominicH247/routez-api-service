<?php

namespace App\Service\Api;

interface ApiInterface {
  public function fetch(string $uri, array $queryParams): array;
}