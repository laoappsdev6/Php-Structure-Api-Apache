<?php
class DatabaseController
{
    private $conn;
    protected $show_errors = true;

    public function __construct()
    {
        $this->conn = new mysqli(dbhost, dbuser, dbpass, dbname);

        if (!$this->conn) {
            $this->error($this->conn->connect_error);
        }

        $this->conn->set_charset(dbcharset);
    }

    public function __destruct()
    {
        $this->conn->close();
    }

    public function query(string $sql)
    {
        try {
            $data = null;
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
                if (!$results) {
                    return $data;
                } else {
                    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
                        $data[] = $row;
                    }
                    mysqli_free_result($results);
                    return $data;
                }
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function lastID()
    {
        return $this->conn->insert_id;
    }

    public function autocommit()
    {
        return $this->conn->autocommit(false);
    }

    public function commit()
    {
        return $this->conn->commit();
    }

    public function rollback()
    {
        return $this->conn->rollback();
    }

    public function error($error)
    {
        if ($this->show_errors) {
            exit($error);
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
}
