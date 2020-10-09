<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;

class ExceptionListener
{
  private $event;

  private $data = [
    'error' => [
      'code' => null,
      'message' => null
    ]
  ];

  /**
   * @param ExceptionEvent $event
   */
  public function onKernelException(ExceptionEvent $event)
  {
    $this->event = $event;

    $exception = $this->event->getThrowable();

    switch (true) {
      case $exception instanceof HttpExceptionInterface:
        $this->createHttpException($exception);
        break;
      case $exception instanceof ClientExceptionInterface:
        $this->createClientException($exception);
        break;
      default:
        $this->createDefaultException($exception);
    }
  }

  protected function createResponse(int $code, string $message)
  {

    $response = new JsonResponse();

    $this->data['error']['code'] = $code;
    $this->data['error']['message'] = $message;

    $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    $response->setData($this->data);
    $response->setStatusCode($code);
    $response->headers->set("Content-Type", "application/json");

    $this->event->setResponse($response);
  }

  protected function createHttpException(object $exception)
  {
    $code = $exception->getStatusCode();
    $message = str_replace('"', '', $exception->getMessage());

    $this->createResponse($code, $message);
  }

  protected function createClientException(object $exception)
  {
    $code = $exception->getCode();
    $message = JsonResponse::$statusTexts[$code];

    $this->createResponse($code, $message);
  }

  protected function createDefaultException($exception)
  {
    $code = 500;
    $message = 'Internal Server Error';

    $this->createResponse($code, $message);
  }
}
