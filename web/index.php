<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Register view rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// Our web handlers

$app->get('/', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('index.twig');
});

$app->get('/consulta/{primer_nombre}/{apellido}/{edad}', function($primer_nombre, $apellido, $edad) use($app) {
  
  $app['monolog']->addDebug('logging output.');

  $primer_nombre = $primer_nombre;

  $ano_nac = 2021 - $edad;

  return "Bienvenido a una consulta " . $primer_nombre . " " . $apellido . ". Todo parece indicar que naciste en el año " . $ano_nac;
});


$app->post('/ordenLed', function (Request $request) use ($app) {
  $temperatura = $request->request->get('title');

  Return $temperatura;
});

$app->run();
