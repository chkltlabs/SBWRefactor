<?php

class User
{

    const DSN = "mysql:host=127.0.01;dbname=sb_db;port=3306;charset=utf8mb4";
    const USER = 'db_user';
    const PASSWORD = 'db_pass';

    const ATTR_ARRAY = ['id','name','alias','addresss','phone','email','password'];

    function __construct($attributes = [])
    {
        //if the array passed to the constructor is not empty
        if(!empty($attributes)){
            //loop through possible values
            foreach (self::ATTR_ARRAY as $attr){
                //if the array passed to the constructor has the given value set, and it is not set to NULL
                if(isset($attributes[$attr]) && $attributes[$attr] !== null){
                    //dynamically set an object level var with a matching name to the current $attr entry
                    $this->$attr = $attributes[$attr];
                }
            }
        }

    }

    function create()
    {
        $setAttrs = [];
        $insertClause = "INSERT INTO users(";
        $valuesClause = " VALUES (";
        //loop through possible values, and if they are set, add them to the sql
        foreach (self::ATTR_ARRAY as $attr){
            if(isset($this->$attr)){
                $insertClause .= "$attr, ";
                $valuesClause .= " ?,";
                $setAttrs[] = $this->$attr;
            }
        }
        //remove trailing comma from final concats
        $insertClause = substr($insertClause, 0, -1);
        $valuesClause = substr($valuesClause, 0, -1);
        //complete strings and concat into $sql
        $insertClause .= ')';
        $valuesClause .= ')';
        $sql = $insertClause . $valuesClause;

        try {
            $this->runPDO($sql, $setAttrs);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }

    function read($id)
    {
        if($id == null && isset($this->id)){
            $id = $this->id;
        }
        //if we are still missing an id, do nothing. cant read without an id
        if($id == null){
            return;
        }

        $sql = "SELECT * FROM users WHERE id = ?";

        try {
            $statement = $this->runPDO($sql, [$id]);
            return $statement->fetch();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }

    function update($id)
    {

        if($id == null && isset($this->id)){
            $id = $this->id;
        }
        //if we are still missing an id, do nothing. cant update without an id
        if($id == null){
            return;
        }

        $setAttrs = [];
        $sql = "UPDATE users SET ";
        //loop through possible values, and if they are set, add them to the sql
        foreach (self::ATTR_ARRAY as $attr){
            if(isset($this->$attr) && $attr !== 'id'){
                $sql .= "$attr=?, ";
                $setAttrs[] = $this->$attr;
            }
        }
        //remove trailing comma from final concats
        $sql = substr($sql, 0, -1);
        //concat where clause
        $sql .= "WHERE id=$id";

        try {
            $this->runPDO($sql, $setAttrs);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }

    function delete($id)
    {
        if($id == null && isset($this->id)){
            $id = $this->id;
        }
        //if we are still missing an id, do nothing. cant delete without an id
        if($id == null){
            return;
        }

        $sql = "DELETE FROM users WHERE id = ?";

        try {
            $this->runPDO($sql, [$id]);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }

    function runPDO($sql, $params)
    {
        $pdo = new PDO(DSN, USER, PASSWORD, []);

        $statement = $pdo->prepare($sql);

        $statement->execute($params);

        return $statement;
    }
}