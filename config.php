<?php

require 'paypal/autoload.php';

define('URL_SITIO', 'http://127.0.0.1/gil_paypal/');


$apiContext = new \PayPal\Rest\ApiContext(
     new \PayPal\Auth\OAuthTokenCredential(
          'Adx-Khr2UJMFv6KEMFr8gVjgnnEpoxukD_AbfKwp1TO88vkW1vI-mzQfr6RY9AOq4gsDS1qiA1atxG-H', // Cliente ID
          'EHeWBx4qLEjPdLxZNcXn92uGC8K7Wkp5jJF5A9Pq6lozsvjIkvE8D1ucGmQN_1mxXHm3uj2wKoz20pG-'// Secret
          )
);





/* Documentación
*define(): Define una constante con nombre, puede ser de tipo resource (p.e. enlace a un recurso externo).

*/
