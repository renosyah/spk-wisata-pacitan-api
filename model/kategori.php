<?php

// menggabungkan kode dari file result_query.php
// yg mana result_query digunakan sebagai
// object yg digunakan untuk hasil
include("result_query.php");

class kategori {
    public $id;
    public $nama;
    public $deskripsi;
    public $url_gambar;
 
    public function __construct(){
    }

    public function set($data){
        $this->id = (int) $data->id;
        $this->nama = $data->nama;
        $this->deskripsi = $data->deskripsi;
        $this->url_gambar = $data->url_gambar;
    }

    public function add($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "INSERT INTO kategori (nama,deskripsi,url_gambar) VALUES (?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sss', $this->nama, $this->deskripsi,$this->url_gambar);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error =  "error at add new kategori : ".$stmt->error;
            $result_query->data = "not ok";
        }
        $stmt->close();
        return $result_query;
    }
    
    public function one($db) {
        $result_query = new result_query();
        $one = new kategori();
        $query = "SELECT id,nama,deskripsi,url_gambar FROM kategori WHERE id=? LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();      
        if ($stmt->error != ""){
            $result_query-> error = "error at query one kategori: ".$stmt->error;
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
        $one->url_gambar = $result['url_gambar'];
        $result_query->data = $one;
        $stmt->close();
        return $result_query;
    }
 
    public function all($db,$list_query) {
        $result_query = new result_query();
        $all = array();
        $query = "SELECT 
                    id,nama,deskripsi,url_gambar
                FROM 
                    kategori
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
            $result_query-> error = "error at query all kategori : ".$stmt->error;
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
            $one = new kategori();
            $one->id = $result['id'];
            $one->nama = $result['nama'];
            $one->deskripsi = $result['deskripsi'];
            $one->url_gambar = $result['url_gambar'];
            array_push($all,$one);
        }
        $result_query->data = $all;
        $stmt->close();
        return $result_query;
    }

    public function update($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "UPDATE kategori SET nama = ?,deskripsi = ?,url_gambar = ? WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sssi', $this->nama, $this->deskripsi,$this->url_gambar,$this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at update one kategori : ".$stmt->error;
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
        $query = "DELETE FROM kategori WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at delete one kategori : ".$stmt->error;
            $result_query->data = "not ok";
            $stmt->close();
            return $result_query;
        }
        $stmt->close();
        return $result_query;
    }
}


?>