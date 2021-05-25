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
  $temperatura = $request->get('temperatura');
  $rpm = $request->get('rpm');
  $voltaje = $request->get('voltaje');

  Return $temperatura;
});

$app->get('/ordenLed', function () use ($app) {
  $conexion = pg_connect("host=ec2-107-20-153-39.compute-1.amazonaws.com port=5432 dbname=dfc71v1qi0g38p user=wcqmzhukfzyezr password=1d9be4c010f92a3f6cb01d222f0528ddd2e51f8b3e2089d03994e5b3732387dc");

  $query = "SELECT * FROM on_off WHERE id>1 ORDER BY fecha DESC LIMIT 1";
  $consulta = pg_query($conexion, $query);
  $datos = pg_fetch_row($consulta);
  return $datos;
});

$app->run();
