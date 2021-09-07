<?php
require_once "jwt.php";
require_once "request.php";
require_once "../config/config.php";
require_once '../controllers/databaseSQLI.controller.php';
require_once '../controllers/databasePDO.controller.php';

error_reporting(E_ALL ^ E_NOTICE);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept,Token,M,Authorization");

function PrintJSON($data, string $message, int $status)
{
    $f = '{"data":%s,"message":"%s","status":"%s"}';
    if ($data) {
        if (is_array($data)) {
            printf($f, json_encode($data), $message, $status);
        } else {
            printf($f, $data, $message, $status);
        }
    } else {
        printf($f, "[]", $message, $status);
    }
}

function Pagination(int $numRow, array $data, int $limit,  int $page)
{
    $allPage = ceil($numRow / $limit);
    return array("Data" => $data, "Page" => $page, "Pagetotal" => $allPage, "Datatotal" => $numRow);
}

function Initialization()
{
    $token = isset(getallheaders()[token]) ? getallheaders()[token] : "";

    if (!empty($token) || $token != "") {
        $check = checkToken($token);
        if ($check > -1) {
            $id = $check;
            $_SESSION["userid"] = $id;
            $_SESSION['pass'] = authorizeToken($token);
        } else {
            PrintJSON("", Message::noAuthorize, 0);
        }
    } else {
        PrintJSON("", Message::noToken, 0);
    }
}

function GetMethod()
{
    return isset(getallheaders()[method]) ? getallheaders()[method] : "";
}

function base64_to_jpeg(string $base64_string, string $output_file)
{
    $ifp = fopen($output_file, "wb");
    fwrite($ifp, base64_decode($base64_string));
    fclose($ifp);
    return ($output_file);
}

function dateTime()
{
    date_default_timezone_set(timeZone);
    return date("Y-m-d H:i:s");
}

function formatDate(string $date)
{
    date_default_timezone_set(timeZone);
    $date = new DateTime($date);
    return $date->format('Y-m-d H:i:s');
}
