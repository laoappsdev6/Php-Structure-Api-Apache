<?php
require_once "validate.model.php";
require_once "../services/services.php";

class LoginModel
{
    public $username;
    public $password;
    public $token;
    public function __construct($object)
    {
        validateEmptyObject($object, "Data");

        foreach ($object as $property => $value) {
            if (property_exists('LoginModel', $property)) {
                $this->$property = $value;
            }
        }
    }

    function validatelogin()
    {
        if ($this->username == "" && $this->password == "") {
            PrintJSON("", Message::emptyUserAndPass, 0);
            die();
        } else if ($this->username == "") {
            PrintJSON("", Message::userEmpty, 0);
            die();
        } elseif ($this->password == "") {
            PrintJSON("", Message::passEmpty, 0);
            die();
        }
    }
}
