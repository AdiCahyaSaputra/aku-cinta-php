<?php

function route($url, $callback)
{
  preg_match_all('/\{(.*?)\}/', $url, $matches);

  $uriParams = $matches[1];
  $currentUri = rtrim($_SERVER['REQUEST_URI'], '/');

  if (count($uriParams) > 0) {
    $parsedUrl = preg_replace('/\{(.*?)\}/', ':param', $url);

    $splittedCurrentUri = explode('/', $currentUri);
    $splittedParsesUrl = explode('/', $parsedUrl);

    $params = [];

    foreach($splittedParsesUrl as $idx => $urlSegment) {
      if($urlSegment === ':param') {
        $paramValue = $splittedCurrentUri[$idx];

        $params[] = $paramValue;
        $splittedParsesUrl[$idx] = $paramValue;
      }
    }

    if (implode('/', $splittedParsesUrl) === $currentUri) {

      $callback($params);

      exit;
    }
  }

  if ($url === $currentUri) {
    $callback();

    exit;
  }
}
