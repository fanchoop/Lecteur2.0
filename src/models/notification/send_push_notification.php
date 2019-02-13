<?php
include_once __DIR__.'/../../../vendor/autoload.php';
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

$publicKey = "BBI0WCCLl9BKOvNHBDapUkLwjXq3Qjz1SdKUvsg1ycEoCkne/NKj+SSM0sq3rJdYJwFl/hmVaLIyUFzlp+53vI8=";
$privateKey = "G5i5LurY/pIN4fXc/t7cVkvoGD3smqKNeNJxc9frWtg=";
// ON RECUP LA SUBCRIPTION DEPUIS LA BD (bon la c'est du post)
$subscription = Subscription::create(json_decode(file_get_contents('php://input'), true));
$auth = array(
    'VAPID' => array(
        'subject' => 'https://github.com/fanchoop/Lecteur2.0',
        'publicKey' => $publicKey,
        'privateKey' => $privateKey,
    ),
);
$webPush = new WebPush($auth);
$res = $webPush->sendNotification(
    $subscription['endpoint'],
    "Hello!",
    $subscription['key'],
    $subscription['token'],
    true
);