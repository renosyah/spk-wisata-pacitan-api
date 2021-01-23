<?php

// menggabungkan kode dari file result_query.php
// yg mana result_query digunakan sebagai
// object yg digunakan untuk hasil
include("result_query.php");

class kriteria {
    public $id;
    public $nama;
    public $deskripsi;
    public $nilai;
    public $attribut;
 
    public function __construct(){
    }

    public function set($data){
        $this->id = (int) $data->id;
        $this->nama = $data->nama;
        $this->deskripsi = $data->deskripsi;
        $this->nilai = $data->nilai;
        $this->attribut = $data->attribut;
    }

    public function add($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "INSERT INTO kriteria (nama,deskripsi,nilai,attribut) VALUES (?,?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ssds', $this->nama, $this->deskripsi, $this->nilai, $this->attribut);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error =  "error at add new kriteria : ".$stmt->error;
            $result_query->data = "not ok";
        }
        $stmt->close();
        return $result_query;
    }
    
    public function one($db) {
        $result_query = new result_query();
        $one = new kriteria();
        $query = "SELECT id,nama,deskripsi,nilai,attribut FROM kriteria WHERE id=? LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();      
        if ($stmt->error != ""){
            $result_query-> error = "error at query one kriteria: ".$stmt->error;
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
        $one->deskripsi = $result['deskripsi'];
        $one->nilai = $result['nilai'];
        $one->attribut = $result['attribut'];
        $result_query->data = $one;
        $stmt->close();
        return $result_query;
    }
 
    public function all($db,$list_query) {
        $result_query = new result_query();
        $all = array();
        $query = "SELECT 
                    id,nama,deskripsi,nilai,attribut
                FROM 
                    kriteria
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
            $result_query-> error = "error at query all kriteria : ".$stmt->error;
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
            $one = new kriteria();
            $one->id = $result['id'];
            $one->nama = $result['nama'];
            $one->deskripsi = $result['deskripsi'];
            $one->nilai = $result['nilai'];
            $one->attribut = $result['attribut'];
            array_push($all,$one);
        }
        $result_query->data = $all;
        $stmt->close();
        return $result_query;
    }

    public function update($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "UPDATE kriteria SET nama = ?,deskripsi = ?,nilai = ?,attribut = ? WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ssdsi', $this->nama, $this->deskripsi,$this->nilai,$this->attribut,$this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at update one kriteria : ".$stmt->error;
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
        $query = "DELETE FROM kriteria WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at delete one kriteria : ".$stmt->error;
            $result_query->data = "not ok";
            $stmt->close();
            return $result_query;
        }
        $stmt->close();
        return $result_query;
    }
}


?>