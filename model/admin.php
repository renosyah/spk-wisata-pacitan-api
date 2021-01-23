<?php

// menggabungkan kode dari file result_query.php
// yg mana result_query digunakan sebagai
// object yg digunakan untuk hasil
include("result_query.php");

class admin {
    public $id;
    public $nama;
    public $username;
    public $password;

    public function __construct(){
    }

    public function set($data){
        $this->id = (int) $data->id;
        $this->nama = $data->nama;
        $this->username = $data->username;
        $this->password = $data->password;
    }

    public function add($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "INSERT INTO admin (nama,username,password) VALUES (?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sss', $this->nama, $this->username, $this->password);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error =  "error at add new admin : ".$stmt->error;
            $result_query->data = "not ok";
        }
        $stmt->close();
        return $result_query;
    }
    
    public function one($db) {
        $result_query = new result_query();
        $one = new admin();
        $query = "SELECT id,nama,username,password FROM admin WHERE id=? LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();      
        if ($stmt->error != ""){
            $result_query-> error = "error at query one admin: ".$stmt->error;
            $stmt->close();
            return $result_query;
        }
        $rows = $stmt->get_result();
        if($rows->num_rows == 0){
            $stmt->close();
            return $result_query;
        }
        $result = $rows->fetch_assoc();
        $one->id = $result['id'];
        $one->nama = $result['nama'];
        $one->username = $result['username'];
        $one->password = $result['password'];
        $result_query->data = $one;
        $stmt->close();
        return $result_query;
    }

    public function login($db) {
        $result_query = new result_query();
        $one = new admin();
        $query = "SELECT id,nama,username,password FROM admin WHERE username=? LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $this->username);
        $stmt->execute();      
        if ($stmt->error != ""){
            $result_query-> error = "error at query one admin: ".$stmt->error;
            $stmt->close();
            return $result_query;
        }
        $rows = $stmt->get_result();
        if($rows->num_rows == 0){
            $result_query->error = "username or password invalid";
            $stmt->close();
            return $result_query;
        }
        $result = $rows->fetch_assoc();
        $one->id = $result['id'];
        $one->nama = $result['nama'];
        $one->username = $result['username'];
        $one->password = $result['password'];
        if ($one->password != $this->password){
            $result_query->error = "username or password invalid";
            $stmt->close();
            return $result_query;
        }
        $result_query->data = $one;
        $stmt->close();
        return $result_query;
    }

    public function all($db,$list_query) {
        $result_query = new result_query();
        $all = array();
        $query = "SELECT 
                    id,nama,username,password
                FROM 
                    admin
                WHERE
                    ".$list_query->search_by." LIKE ?
                ORDER BY
                    ".$list_query->order_by." ".$list_query->order_dir." 
                LIMIT ? 
                OFFSET ?";
        $stmt = $db->prepare($query);
        $search = "%".$list_query->search_value."%";
        $offset = $list_query->offset;
        $limit =  $list_query->limit;
        $stmt->bind_param('sii',$search ,$limit, $offset);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query-> error = "error at query all kota : ".$stmt->error;
            $stmt->close();
            return $result_query;
        }
        $rows = $stmt->get_result();
        if($rows->num_rows == 0){
            $stmt->close();
            $result_query->data = $all;
            return $result_query;
        }

        while ($result = $rows->fetch_assoc()){
            $one = new admin();
            $one->id = $result['id'];
            $one->nama = $result['nama'];
            $one->username = $result['username'];
            $one->password = $result['password'];
            array_push($all,$one);
        }
        $result_query->data = $all;
        $stmt->close();
        return $result_query;
    }

    public function update($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "UPDATE admin SET nama = ?,username = ?,password = ? WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sssi', $this->nama, $this->username, $this->password,$this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at update one admin : ".$stmt->error;
            $result_query->data = "not ok";
            $stmt->close();
            return $result_query;
        }
        $stmt->close();
        return $result_query;
    }
    
    public function delete($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "DELETE FROM admin WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at delete one admin : ".$stmt->error;
            $result_query->data = "not ok";
            $stmt->close();
            return $result_query;
        }
        $stmt->close();
        return $result_query;
    }
}


?>