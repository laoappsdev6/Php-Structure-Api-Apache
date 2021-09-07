<?php

require_once "../controllers/validate.controller.php";
require_once "validate.model.php";
require_once "../services/services.php";

class UserModel
{
    public int $id = 0;
    public string $username;
    public string $password;
    public string $role;
    public string $created_at;
    public string $updated_at;
    public string $isActive;

    public string $newPassword;
    public string $newRole;

    public $page;
    public $limit;
    public $keyword;

    public function __construct(array $object, string $method)
    {
        if ($method !== Usermethod::listAll) {
            validateEmptyObject($object, "Data");
        }

        foreach ($object as $property => $value) {
            if (property_exists('UserModel', $property)) {
                $this->$property = $value;
            }
        }

        $this->created_at = dateTime();
        $this->updated_at = dateTime();
    }

    public function validateAll()
    {
        foreach ($this as $key => $value) {
            $this->validate($key, $value);
        }
    }

    public function validate($key, $value)
    {
        switch ($key) {
            case 'username':
                validateEmpty($value, $key);
                $sql = "select * from users where username='$value' and id !='$this->id'";
                validateAlreadyExist($sql, $key, $value);
                break;
            case 'password':
                validateEmpty($value, $key);
                break;
            case 'role':
                validateEmpty($value, $key);
                break;
        }
    }

    public function checkId()
    {
        $sql = "select * from users where id='$this->id'";
        validateNotAvailable($sql, "UserId", $this->id);
    }

    public function validateNewPassword()
    {
        validateEmpty($this->newPassword, "New password");
    }
}
