<?php

function validateAlreadyExist(string $sql, string $key, $value)
{
    $db = new PDODBController();
    $name = $db->query($sql);
    if ($name > 0) {
        PrintJSON("", $key . ": " . $value . Message::already, 0);
        die();
    }
}
function validateNotAvailable(string $sql, string $key, $value)
{
    $db = new PDODBController();
    $name = $db->query($sql);
    if ($name == 0) {
        PrintJSON("", $key . ": " . $value  . Message::exists, 0);
        die();
    }
}
function validateUuid(string $sql)
{
    $db = new PDODBController();
    $name = $db->query($sql);
    return $name;
}
