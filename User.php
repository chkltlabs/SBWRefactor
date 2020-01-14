<?php

class User
{

    const DSN = "mysql:host=127.0.01;dbname=sb_db;port=3306;charset=utf8mb4";
    const USER = 'db_user';
    const PASSWORD = 'db_pass';

    function create()
    {

        $name = $_POST['name'];

        $alias = $_POST['alias'];

        $address = $_POST['address'];

        $phone = $_POST['phone'];

        $email = $_POST['email'];

        $password = $_POST['password'];

        $sql = "INSERT INTO users (name, alias, address, phone, email, password) VALUES ( ?, ?, ?, ?, ?, ?) ";

        try {
            $this->runPDO($sql, [$name, $alias, $address, $phone, $email, $password]);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), $e->getCode());
        }


//          These functions are deprecated, and should be replaced with mysqli or PDO
//        $cn = mysql_connect('127.0.0.1', 'db_user', 'db_pass');
//
//        $db = mysql_select_db('sb_db');
//
//        mysql_query('INSERT INTO users '
//
//            . '(name, alias, address, phone, email, password) '
//
//            . 'VALUES '
//
//            . '("$name", "$alias", "$address", "$phone", "$email", "$password"');

    }

    function read()
    {

        $id = $_GET['id'];

        $sql = "SELECT * FROM users WHERE id = ?";

        try {
            $statement = $this->runPDO($sql, [$id]);
            return $statement->fetch();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), $e->getCode());
        }


//          These functions are deprecated, and should be replaced with mysqli or PDO
//        $cn = mysql_connect('127.0.0.1', 'db_user', 'db_pass');
//
//        $db = mysql_select_db('sb_db');
//
//        $result = mysql_query('SELECT * FROM users WHERE id = "$id"');
//
//        $this = mysql_fetch_row($result);

    }

    function update()
    {

        $id = $_POST['id'];

        $name = $_POST['name'];

        $alias = $_POST['alias'];

        $address = $_POST['address'];

        $phone = $_POST['phone'];

        $email = $_POST['email'];

        $password = $_POST['password'];

        $sql = "UPDATE users SET name=?, alias=?, address=?, phone=?, email=?, password=? WHERE id=?";

        try {
            $this->runPDO($sql, [$name, $alias, $address, $phone, $email, $password, $id]);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), $e->getCode());
        }


//          These functions are deprecated, and should be replaced with mysqli or PDO
//        $cn = mysql_connect('127.0.0.1', 'db_user', 'db_pass');
//
//        $db = mysql_select_db('sb_db');
//
//        mysql_query('UPDATE users SET '
//
//            .'name="$name", '
//
//            .'alias="$alias", '
//
//            .'address="$address", '
//
//            .'phone="$phone", '
//
//            .'email="$email", '
//
//            .'password="$password" '
//
//            .'WHERE id ="$id"');

    }

    function delete()
    {

        $id = $_GET['id'];

        $sql = "DELETE FROM users WHERE id = ?";

        try {
            $this->runPDO($sql, [$id]);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

//          These functions are deprecated, and should be replaced with mysqli or PDO
//        $cn = mysql_connect('127.0.0.1', 'db_user', 'db_pass');
//
//        $db = mysql_select_db('sb_db');
//
//        mysql_query('DELETE FROM users WHERE id = "$id"');

    }

    function runPDO($sql, $params)
    {
        $pdo = new PDO(DSN, USER, PASSWORD, []);

        $statement = $pdo->prepare($sql);

        $statement->execute($params);

        return $statement;
    }
}