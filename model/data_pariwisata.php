<?php

// menggabungkan kode dari file result_query.php
// yg mana result_query digunakan sebagai
// object yg digunakan untuk hasil
include("result_query.php");

class data_pariwisata {
    public $id;
    public $kategori_id;
    public $nama;
    public $deskripsi;
    public $lokasi;
 
    public function __construct(){
    }

    public function set($data){
        $this->id = (int) $data->id;
        $this->kategori_id = $data->kategori_id;
        $this->nama = $data->nama;
        $this->deskripsi = $data->deskripsi;
        $this->lokasi = $data->lokasi;
    }

    public function add($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "INSERT INTO data_pariwisata (kategori_id,nama,deskripsi,lokasi) VALUES (?,?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('isss',$this->kategori_id, $this->nama, $this->deskripsi, $this->lokasi);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error =  "error at add new data_pariwisata : ".$stmt->error;
            $result_query->data = "not ok";
        }
        $stmt->close();
        return $result_query;
    }
    
    public function one($db) {
        $result_query = new result_query();
        $one = new data_pariwisata();
        $query = "SELECT id,kategori_id,nama,deskripsi,lokasi FROM data_pariwisata WHERE id=? LIMIT 1";
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
        $one->kategori_id = $result['kategori_id'];
        $one->nama = $result['nama'];
        $one->deskripsi = $result['deskripsi'];
        $one->lokasi = $result['lokasi'];
        $result_query->data = $one;
        $stmt->close();
        return $result_query;
    }
 
    public function all($db,$list_query) {
        $result_query = new result_query();
        $all = array();
        $query = "SELECT 
                    id,kategori_id,nama,deskripsi,lokasi
                FROM 
                    data_pariwisata
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
            $result_query-> error = "error at query all data_pariwisata : ".$stmt->error;
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
            $one = new data_pariwisata();
            $one->id = $result['id'];
            $one->kategori_id = $result['kategori_id'];
            $one->nama = $result['nama'];
            $one->deskripsi = $result['deskripsi'];
            $one->lokasi = $result['lokasi'];
            array_push($all,$one);
        }
        $result_query->data = $all;
        $stmt->close();
        return $result_query;
    }

    public function update($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "UPDATE data_pariwisata SET kategori_id = ?,nama = ?,deskripsi = ?,lokasi = ? WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('isssi',$this->kategori_id, $this->nama, $this->deskripsi,$this->lokasi,$this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at update one data_pariwisata : ".$stmt->error;
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
        $query = "DELETE FROM data_pariwisata WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at delete one data_pariwisata : ".$stmt->error;
            $result_query->data = "not ok";
            $stmt->close();
            return $result_query;
        }
        $stmt->close();
        return $result_query;
    }
}


?>