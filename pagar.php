<?php

ini_set("display_errors", "1");
error_reporting(E_ALL);

if (!isset($_POST['producto'], $_POST['precio'])) {
     exit('Hubo un error!');
}

/*// prueba de que index se comnica con pagar
echo "<pre>";
     var_dump($_POST);
echo "</pre>"; */

// namespace/ruta de las clases de paypal
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

// enlazo pagar.php con las librerías de paypal que están contenidas en config.php
require 'config.php';

// declaro las variables para leer lo que introduce el usuario en el index
$producto = htmlspecialchars($_POST['producto']); // htmlspecialchars es para sanitizar
$precio = htmlspecialchars($_POST['precio']);
$precio = (float) $precio;
//var_dump($precio);
$envio = 0;
$total = $precio + $envio;

// Instancio/creo los objetos de paypal
$compra = new Payer();
$compra->setPaymentMethod('paypal');

$articulo = new Item();
$articulo->setName($producto)
          ->setCurrency('MXN')
          ->setQuantity(1)
          ->setPrice($precio);

/* pruebas
echo $articulo->getName();
echo $articulo->getCurrency();
echo $articulo->getQuantity();
echo $articulo->getPrice(); */

$listaArticulos = new ItemList();
$listaArticulos->setItems(array($articulo));

$detalles = new Details();
$detalles->setShipping($envio)
          ->setSubtotal($precio);

$cantidad = new Amount();
$cantidad->setCurrency('MXN')
          ->setTotal($total)
          ->setDetails($detalles);

$transaccion = new Transaction();
$transaccion->setAmount($cantidad)
          ->setItemList($listaArticulos)
          ->setDescription('Pago ')
          ->setInvoiceNumber(uniqid()); // Este podría ser id de la bd; como todavía no la hacemos, sustituimos con f php uniqid();

echo $transaccion->getInvoiceNumber();

$redireccionar = new RedirectUrls();
$redireccionar->setReturnUrl(URL_SITIO . "/pago_finalizado.php?exito=true")
          ->setCancelUrl(URL_SITIO . "/pago_finalizado.php?exito=false");

echo $redireccionar->getReturnUrl();

//Comprobar que estamos tomando/leyendo los datos de la url

$pago = new Payment();
$pago->setIntent('sale')
     ->setPayer($compra)
     ->setRedirectUrls($redireccionar)
     ->setTransactions(array($transaccion));

try {
     $pago->create($apiContext);
} catch (PayPal\Exception\PayPalConnectionException $pce) {
     echo "<pre>";
          print_r(json_decode($pce->getData()));
          exit;
     echo "</pre>";
}

$aprobado = $pago->getApprovalLink();

header("Location: {$aprobado}");















//
