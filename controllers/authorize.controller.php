<?php

class LoginController
{
    public function __construct()
    {
    }
    public function checkLogin(object $u)
    {
        $db = new PDODBController();

        $sql = "select id,username,role,created_at,updated_at from users
                where username='$u->username' and password='$u->password'";
        $data = $db->query($sql);

        if ($data > 0) {
            $row = $data[0];

            $token = array("Token" => registerToken($row), "data" => $row,);

            PrintJSON($token, Message::loginOk, 1);
        } else {

            $sql = "select * from users where username='$u->username'";
            $name = $db->query($sql);

            $sql1 = "select * from users where password='$u->password'";
            $pass = $db->query($sql1);

            if ($name == 0 && $pass == 0) {
                PrintJSON("", Message::wrongUserAndPass, 0);
            } else if ($name > 0 && $pass == 0) {
                PrintJSON("", Message::wrongPass, 0);
            } else if ($name == 0 && $pass > 0) {
                PrintJSON("", Message::wrongUser, 0);
            } else if ($name > 0 && $pass > 0) {
                PrintJSON("", Message::noAuthorize, 0);
            }
        }
    }
}
