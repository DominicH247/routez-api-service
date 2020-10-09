<?php

namespace App\Service\Api;

use App\Service\Api\ApiInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TransportApi implements ApiInterface
{
  const BASE_URI = "https://transportapi.com/v3/uk/";

  private $apiAuth;

  private $http;

  public function __construct(HttpClientInterface $httpClient, string $transport_api_id, string $transport_api_key)
  {
    $this->http = $httpClient;
    $this->apiAuth = [
      'app_id' => $transport_api_id,
      'app_key' => $transport_api_key,
    ];
  }

  /**
   * Fetches result from the transport api
   * @param string api uri
   * @param array query params
   * @return array
   */
  public function fetch(string $busStopUri, array $queryParams): array
  {
    $params = array_merge($this->apiAuth, $queryParams);

    return $this->http->request('GET', self::BASE_URI . $busStopUri, [
      'query' => $params,
    ])->toArray();
  }
}
