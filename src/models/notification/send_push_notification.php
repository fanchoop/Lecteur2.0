<?php
include_once __DIR__.'/../../../vendor/autoload.php';
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

$publicKey = "BOF3S21a3AHAk0YpPQSg90hmIkXOAuyAcML2xNSMujigip7wOvLovkOIFZI6xMgnt3Nl16FdWq_Tp7xlR7lGR5U";
$privateKey = "VgAUAebGhoukHl3KRKVZREAZENHs9sllP6Sa_OCSLR4";

// ON RECUP LA SUBCRIPTION DEPUIS LA BD (bon la c'est du post)
$subscription = Subscription::create(json_decode(file_get_contents('php://input'), true));
$auth = array(
    'VAPID' => array(
        'subject' => 'localhost/Lecteur2.0/index.php',
        'publicKey' => $publicKey,
        'privateKey' => $privateKey,
    ),
);
$webPush = new WebPush($auth);
var_dump($webPush);

$res = $webPush->sendNotification(
    $subscription,
    "Hello!",
    true
);