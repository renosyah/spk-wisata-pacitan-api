<?php

// menggabungkan kode dari file result_query.php
// yg mana result_query digunakan sebagai
// object yg digunakan untuk hasil
include_once ("result_query.php");
include_once ("kriteria_range.php");

class data_pariwisata_attribut {
    public $id;
    public $data_pariwisata_id;
    public $kriteria_range;
 
    public function __construct(){
    }

    public function set($data){
        $this->id = (int) $data->id;
        $this->data_pariwisata_id = (int) $data->data_pariwisata_id;
        $this->kriteria_range = $data->kriteria_range;
    }

    public function add($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "INSERT INTO data_pariwisata_attribut (data_pariwisata_id,kriteria_range_id) VALUES (?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ii',$this->data_pariwisata_id,$this->kriteria_range->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error =  "error at add new data_pariwisata_attribut : ".$stmt->error;
            $result_query->data = "not ok";
        }
        $stmt->close();
        return $result_query;
    }
    
    public function one($db) {
        $result_query = new result_query();
        $one = new data_pariwisata_attribut();
        $query = "SELECT id,data_pariwisata_id,kriteria_range_id FROM data_pariwisata_attribut WHERE id=? LIMIT 1";
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
        $one->data_pariwisata_id = $result['data_pariwisata_id'];
 
        $kriteria_range = new kriteria_range();
        $kriteria_range->id = $result['kriteria_range_id'];
        $one->kriteria_range = $kriteria_range->one($db)->data;

        $result_query->data = $one;
        $stmt->close();
        return $result_query;
    }
 
    public function allByPariwisataIdAndKriteriaID($db,$list_query) {
        $result_query = new result_query();
        $all = array();
        $query = "SELECT 
                    dpa.id,dpa.data_pariwisata_id,dpa.kriteria_range_id
                FROM 
                    data_pariwisata_attribut dpa
                INNER JOIN
                    kriteria_range kr
                ON
                    dpa.kriteria_range_id = kr.id 
                WHERE
                    kr.kriteria_id = ?
                AND
                    dpa.data_pariwisata_id = ?
                LIMIT ? 
                OFFSET ?";
        $stmt = $db->prepare($query);
        $kriteria_id = (int) $list_query->kriteria_id;
        $data_pariwisata_id = (int) $list_query->data_pariwisata_id;
        $offset = (int) $list_query->offset;
        $limit = (int) $list_query->limit;
        $stmt->bind_param('iiii',$kriteria_id, $data_pariwisata_id ,$limit, $offset);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query-> error = "error at query all data_pariwisata_attribut : ".$stmt->error;
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
            $one = new data_pariwisata_attribut();
            $one->id = $result['id'];
            $one->data_pariwisata_id = $result['data_pariwisata_id'];

            $kriteria_range = new kriteria_range();
            $kriteria_range->id = $result['kriteria_range_id'];
            $one->kriteria_range = $kriteria_range->one($db)->data;

            array_push($all,$one);
        }
        $result_query->data = $all;
        $stmt->close();
        return $result_query;
    }

    public function all($db,$list_query) {
        $result_query = new result_query();
        $all = array();
        $query = "SELECT 
                    id,data_pariwisata_id,kriteria_range_id
                FROM 
                    data_pariwisata_attribut
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
            $result_query-> error = "error at query all data_pariwisata_attribut : ".$stmt->error;
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
            $one = new data_pariwisata_attribut();
            $one->id = $result['id'];
            $one->data_pariwisata_id = $result['data_pariwisata_id'];

            $kriteria_range = new kriteria_range();
            $kriteria_range->id = $result['kriteria_range_id'];
            $one->kriteria_range = $kriteria_range->one($db)->data;

            array_push($all,$one);
        }
        $result_query->data = $all;
        $stmt->close();
        return $result_query;
    }

    public function allByPariwisataID($db,$pariwisataID,$criteriaRanges) {
        $result_query = new result_query();
        $all = array();
        $query = "SELECT 
                    id,data_pariwisata_id,kriteria_range_id
                FROM 
                    data_pariwisata_attribut
                WHERE
                    data_pariwisata_id = ?
                ORDER BY
                    id ASC";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i',$pariwisataID);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query-> error = "error at query all data_pariwisata_attribut : ".$stmt->error;
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
            $one = new data_pariwisata_attribut();
            $one->id = $result['id'];
            $one->data_pariwisata_id = $result['data_pariwisata_id'];

            $kriteria_range = new kriteria_range();
            $kriteria_range->id = $result['kriteria_range_id'];
            $one->kriteria_range = $kriteria_range->one($db)->data;

            array_push($all,$one);
        }
        $result_query->data = $all;
        $stmt->close();
        return $result_query;
    }

    public function update($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "UPDATE data_pariwisata_attribut SET data_pariwisata_id = ?,kriteria_range_id = ? WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('iii',$this->data_pariwisata_id,$this->kriteria_range->id,$this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at update one data_pariwisata_attribut : ".$stmt->error;
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
        $query = "DELETE FROM data_pariwisata_attribut WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at delete one data_pariwisata_attribut : ".$stmt->error;
            $result_query->data = "not ok";
            $stmt->close();
            return $result_query;
        }
        $stmt->close();
        return $result_query;
    }
}


?>