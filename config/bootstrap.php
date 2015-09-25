<?php

use JWT\JWT;
use CBase\Query\Query;
use Slimvc\Translator;
use Mailgun\Mailgun;

define('APP_PATH', dirname(__FILE__));
define('APP_NAME', 'Kanban');
if (!defined('CURLOPT_FORBID_REUSE')) {
    define('CURLOPT_FORBID_REUSE', 0);
}

$libConfig = [
  'pdo'        => new PDO('mysql:host=127.0.0.1;dbname=kanban', 'root', ''),
  'apikey'     => 'secret',
  'mailgunKey' => 'key'
];

$jwt = new JWT();
$jwt->setIssuer('http://localhost')
    ->setAudience('http://localhost')
    ->setIssuedAt(time())
    ->sign($libConfig['apikey'])
    ->getToken();

$db = new Query($libConfig);
$tr = new Translator('pl');
$mg = new Mailgun($libConfig['mailgunKey']);

return [
    'db'     => $db,
    'jwt'    => $jwt,
    'tr'     => $tr,
    'mg'     => $mg,
    'apikey' => &$libConfig['apikey']
];
