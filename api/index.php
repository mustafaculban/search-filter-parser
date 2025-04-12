<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DevJoys\Parser\SearchFilterParser;

$app = AppFactory::create();

$app->post('/parse-filters', function (Request $request, Response $response) {
    $body = $request->getBody()->getContents();
    $data = json_decode($body, true);

    $parser = new SearchFilterParser();
    $sql = $parser->parse($data);

    $payload = json_encode(['sql' => $sql]);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();