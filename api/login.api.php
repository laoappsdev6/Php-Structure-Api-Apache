<?php
require_once("../controllers/authorize.controller.php");
require_once("../models/login.model.php");

try {

  $json = json_decode(file_get_contents('php://input'), true);

  $controll = new LoginController();
  $log = new LoginModel($json);

  $log->validatelogin();
  $controll->checkLogin($log);
} catch (Exception $e) {
  $error = $e->getMessage();
  PrintJSON("", "$error", 0);
}
