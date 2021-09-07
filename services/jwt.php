<?php
require_once "vendor/firebase/php-jwt/src/BeforeValidException.php";
require_once "vendor/firebase/php-jwt/src/ExpiredException.php";
require_once "vendor/firebase/php-jwt/src/SignatureInvalidException.php";
require_once "vendor/firebase/php-jwt/src/JWT.php";
require_once "../controllers/validate.controller.php";

function registerToken($user)
{
    $key = "31ZlkkPKf2kBSARuYmwpfes6FyobGOfF";
    $payload = array(
        "iss" => 'laoapps.com',
        "aud" => "jwt.laoapps.com",
        "iat" => 1356999524,
        "nbf" => 1357000000,
        "data" => $user,
        "updatetime" => tickTime()
    );
    $jwt = JWT::encode($payload, $key);

    return $jwt;
}
function getDetailsToken($jwt)
{
    try {
        $key = "31ZlkkPKf2kBSARuYmwpfes6FyobGOfF";
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $decoded_array = (array) $decoded;

        $user = $decoded_array['data'];
        // print_r($user);
        // check user from database;
        $details = (object)array();
        if (isset($user)) {
            $details->timezone =  $user->timezone;
            $details->client_time_zone =  $user->client_time_zone;
            $details->lang =  $user->lang;
            $details->date_fmt =  $user->date_fmt;
            $details->time_fmt =  $user->time_fmt;
            $details->sond_alarm =  $user->sond_alarm;
            $details->popup_alarm =  $user->popup_alarm;
            $details->unit_distance =  $user->ud;
            $details->unit_fuel =  $user->uf;
            $details->unit_temperature =  $user->ut;
            $details->unit_speed =  $user->us;
            $details->okind = $user->okind;
            $details = json_encode($details);
            return $details;
        }
    } catch (\Exception $e) {
        //die($e);
        return null;
    }
    // finally {
    //     //optional code that always runs
    // }
    return null;
}
function authorizeToken($jwt)
{
    try {
        $key = "31ZlkkPKf2kBSARuYmwpfes6FyobGOfF";
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $decoded_array = (array) $decoded;

        $user = $decoded_array['data'];
        // print_r($user);
        // check user from database;
        if (isset($user)) {
            return $user->password;
        }
    } catch (\Exception $e) {
        //die($e);
        return null;
    }

    return null;
}
function checkToken($jwt)
{
    try {
        $key = "31ZlkkPKf2kBSARuYmwpfes6FyobGOfF";
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $decoded_array = (array) $decoded;

        $user = $decoded_array['data'];
        // print_r($user);die();
        // check user from database;

        if (isset($user)) {

            $sql = "select * from users where id='$user->id' and isActive = 1";
            validateNotAvailable($sql, "Sorry, You do not have access to the system!", '');
            return $user->id;
        }
    } catch (\Exception $e) {
        //die($e);
        return -1;
    }
    return -1;
}
function allDetailsToken($jwt)
{
    $key = "31ZlkkPKf2kBSARuYmwpfes6FyobGOfF";
    $decoded = JWT::decode($jwt, $key, array('HS256'));
    $decoded_array = (array) $decoded;

    $user = $decoded_array['data'];
    // print_r($user);
    // check user from database;
    if (isset($user)) {
        return $user;
    }
    return null;
}
function unitSpeedToken($jwt)
{
    $key = "31ZlkkPKf2kBSARuYmwpfes6FyobGOfF";
    $decoded = JWT::decode($jwt, $key, array('HS256'));
    $decoded_array = (array) $decoded;

    $user = $decoded_array['data'];
    // print_r($user);
    // check user from database;
    if (isset($user)) {
        return $user->us;
    }
    return 0;
}
function timeZoneToken($jwt)
{
    $key = "31ZlkkPKf2kBSARuYmwpfes6FyobGOfF";
    $decoded = JWT::decode($jwt, $key, array('HS256'));
    $decoded_array = (array) $decoded;

    $user = $decoded_array['data'];
    // print_r($user);
    // check user from database;
    if (isset($user)) {
        return $user->client_time_zone;
    }
    return 0;
}
function refreshToken($jwt)
{
    $key = "31ZlkkPKf2kBSARuYmwpfes6FyobGOfF";
    $decoded = JWT::decode($jwt, $key, array('HS256'));
    $decoded_array = (array) $decoded;
    return registerToken($decoded_array['data']);
}
function tickTime()
{
    $mt = microtime(true);
    $mt =  $mt * 1000; //microsecs
    return (string)$mt * 10; //100 Nanosecs
}
