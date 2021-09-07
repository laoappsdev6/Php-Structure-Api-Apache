<?php

class PDODBController
{
    private $conn;
    private string $dbhost = dbhost;
    private string $dbuser = dbuser;
    private string $dbpass = dbpass;
    private string $dbname = dbname;
    private string $charset = dbsetname;

    public function __construct()
    {
        try {
            $options = [PDO::MYSQL_ATTR_INIT_COMMAND => $this->charset];
            $this->conn = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname", $this->dbuser, $this->dbpass, $options);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function __destruct()
    {
        $this->conn == null;
    }

    public function query(string $sql)
    {
        if (empty($sql)) {
            return false;
        }
        if (!$this->conn) {
            return false;
        }

        $results = $this->conn->query($sql);

        if (!$results) {
            return false;
        }
        if (!(preg_match("/select/i", $sql) || preg_match("/show/i", $sql))) {
            return true;
        } else {
            $rows = $results->fetchAll(PDO::FETCH_ASSOC);
            if (count($rows) === 0) {
                return null;
            } else {
                return $rows;
            }
        }
    }

    public function insert(string $sql)
    {
        try {
            $data = $this->query($sql);
            if ($data) {
                PrintJSON("", Message::addSuccess, 1);
            } else {
                PrintJSON("", Message::addFail, 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function update(string $sql)
    {
        try {
            $data = $this->query($sql);
            if ($data) {
                PrintJSON("", Message::updateSuccess, 1);
            } else {
                PrintJSON("", Message::updateFail, 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function delete(string $sql)
    {
        try {
            $data = $this->query($sql);
            if ($data) {
                PrintJSON("", Message::deleteSuccess, 1);
            } else {
                PrintJSON("", Message::deleteFail, 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function selectAll(string $sql)
    {
        try {
            $data = $this->query($sql);
            PrintJSON($data, Message::listAll, 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function selectPage(object $data, string $sqlCount, string $sqlPage, string $orderBy)
    {
        try {
            $page = $data->page;
            $limit = $data->limit;

            $dataCount = $this->query($sqlCount);
            $numRow = $dataCount[0]['num'];

            if ($numRow > 0) {

                $offset = (($page - 1) * $limit);

                $by = " order by {$orderBy} desc limit $limit offset $offset";

                $data = $this->query($sqlPage . $by);
                $dataList = $data;
            } else {
                $dataList = [];
            }
            $myPage = Pagination($numRow, $dataList, $limit, $page);

            PrintJSON($myPage, Message::listPage, 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function selectOne(string $sql)
    {
        try {
            $data = $this->query($sql);
            PrintJSON($data, Message::listOne, 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function lastID()
    {
        return $this->conn->lastInsertId();
    }

    public function beginTran()
    {
        return $this->conn->beginTransaction();
    }

    public function execut($sql)
    {
        $this->conn->exec($sql);
    }

    public function commit()
    {
        return $this->conn->commit();
    }

    public function rollback()
    {
        return $this->conn->rollback();
    }
}
