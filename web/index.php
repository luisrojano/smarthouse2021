<?php

use Symfony\Component\HttpFoundation\Request;

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

$app->get('/consulta/{nombre}/{apellido}/{edad}', function(Request $request) use($app) {
  $app['monolog']->addDebug('logging output.');

  $nombre = $request->query->get('nombre');
  $apellido = $request->query->get('apellido');
  $edad = $request->query->get('edad');

  return "Bienvenido a una consulta " . $nombre . " " . $apellido ". Tu edad es " . $edad;
});

$app->run();
