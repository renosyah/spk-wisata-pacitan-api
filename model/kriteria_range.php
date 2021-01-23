<?php

// menggabungkan kode dari file result_query.php
// yg mana result_query digunakan sebagai
// object yg digunakan untuk hasil
include_once ("result_query.php");

class kriteria_range {
    public $id;
    public $kriteria_id;
    public $nama;
    public $deskripsi;
    public $nilai;
 
    public function __construct(){
    }

    public function set($data){
        $this->id = (int) $data->id;
        $this->kriteria_id = $data->kriteria_id;
        $this->nama = $data->nama;
        $this->deskripsi = $data->deskripsi;
        $this->nilai = $data->nilai;
    }

    public function add($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "INSERT INTO kriteria_range (kriteria_id,nama,deskripsi,nilai) VALUES (?,?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('issd',$this->kriteria_id, $this->nama, $this->deskripsi, $this->nilai);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error =  "error at add new kriteria_range : ".$stmt->error;
            $result_query->data = "not ok";
        }
        $stmt->close();
        return $result_query;
    }
    
    public function one($db) {
        $result_query = new result_query();
        $one = new kriteria_range();
        $query = "SELECT id,kriteria_id,nama,deskripsi,nilai FROM kriteria_range WHERE id=? LIMIT 1";
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
        $one->kriteria_id = $result['kriteria_id'];
        $one->nama = $result['nama'];
        $one->deskripsi = $result['deskripsi'];
        $one->nilai = $result['nilai'];
        $result_query->data = $one;
        $stmt->close();
        return $result_query;
    }
 
    public function all($db,$list_query) {
        $result_query = new result_query();
        $all = array();
        $query = "SELECT 
                    id,kriteria_id,nama,deskripsi,nilai 
                FROM 
                    kriteria_range
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
            $result_query-> error = "error at query all kriteria_range : ".$stmt->error;
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
            $one = new kriteria_range();
            $one->id = $result['id'];
            $one->kriteria_id = $result['kriteria_id'];
            $one->nama = $result['nama'];
            $one->deskripsi = $result['deskripsi'];
            $one->nilai = $result['nilai'];
            array_push($all,$one);
        }
        $result_query->data = $all;
        $stmt->close();
        return $result_query;
    }

    public function update($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "UPDATE kriteria_range SET kriteria_id = ?,nama = ?,deskripsi = ?,nilai = ? WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('issdi',$this->kriteria_id, $this->nama, $this->deskripsi,$this->nilai,$this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at update one kriteria_range : ".$stmt->error;
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
        $query = "DELETE FROM kriteria_range WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at delete one kriteria_range : ".$stmt->error;
            $result_query->data = "not ok";
            $stmt->close();
            return $result_query;
        }
        $stmt->close();
        return $result_query;
    }
}


?>