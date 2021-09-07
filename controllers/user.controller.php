<?php

class UserController
{
    public $conn;
    public function __construct()
    {
        $this->conn = new PDODBController();
    }
    public function add(object $data)
    {
        $sql = "insert into users (username,password,role,created_at,updated_at,isActive) 
                values ('$data->username','$data->password','$data->role','$data->created_at','$data->updated_at','$data->isActive')";
        $this->conn->insert($sql);
    }
    public function update(object $data)
    {
        $sql = "update users set username='$data->username',password='$data->password',role='$data->role',
                isActive='$data->isActive',updated_at='$data->updated_at' where id='$data->id'";
        $this->conn->update($sql);
    }
    public function delete(object $data)
    {
        $sql = "delete from users where id='$data->id'";
        $this->conn->delete($sql);
    }

    public function changePassword(object $data)
    {
        $sql = "update users set password='$data->newPassword' where id='$data->id'";
        $this->conn->update($sql);
    }

    public function listAll()
    {
        $sql = "select * from users";
        $this->conn->selectAll($sql);
    }
    public function listPage(object $data)
    {
        $sqlCount = "select count(*) as num from users";

        $sqlPage = "select * from users ";
        if (isset($data->keyword) && !empty($data->keyword)) {
            $sqlPage .= " where
                        username like '%$data->keyword%' or
                        role like '%$data->keyword%'
                        ";
        }
        $orderBy = "id";
        $this->conn->selectPage($data, $sqlCount, $sqlPage, $orderBy);
    }
    public function listOne(object $data)
    {
        $sql = "select * from users where id='$data->id'";
        $this->conn->selectOne($sql);
    }
}
