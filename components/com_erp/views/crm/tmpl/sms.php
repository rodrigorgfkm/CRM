<?php defined('_JEXEC') or die;
// Required if your environment does not handle autoloading
require __DIR__ . '\vendor\autoload.php';

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$sid = 'AC70182d73673e257ab8c6a8751fe907c9';
$token = 'AC70182d73673e257ab8c6a8751fe907c9';
$client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!
$client->messages->create(
    // the number you'd like to send the message to
    '+59172594874',
    [
        // A Twilio phone number you purchased at twilio.com/console
        'from' => '+12677298514',
        // the body of the text message you'd like to send
        'body' => 'Hola esto es una prueba'
    ]
);
?>