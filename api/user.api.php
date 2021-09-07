<?php
require_once "../controllers/user.controller.php";
require_once "../models/user.model.php";

try {
    // Initialization();
    $method = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new UserController();
    $model = new UserModel($json, $method);

    switch ($method) {
        case Usermethod::add:
            $model->validateAll();
            $control->add($model);
            break;
        case Usermethod::update:
            $model->checkId();
            $model->validateall();
            $control->update($model);
            break;
        case Usermethod::delete:
            $model->checkId();
            $control->delete($model);
            break;
        case Usermethod::changePassword:
            $model->validateNewPassword();
            $control->changePassword($model);
            break;
        case Usermethod::listAll:
            $control->listALL();
            break;
        case Usermethod::listPage:
            $control->listPage($model);
            break;
        case Usermethod::listOne:
            $control->listOne($model);
            break;
        default:
            PrintJSON("", Message::methodNotFound, 0);
            break;
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    PrintJSON("", "$error", 0);
}
