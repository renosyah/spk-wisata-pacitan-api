<?php

// menggabungkan kode dari file result_query.php
// yg mana result_query digunakan sebagai
// object yg digunakan untuk hasil
include_once ("result_query.php");
include("kriteria.php");
include("data_pariwisata.php");
include("data_pariwisata_attribut.php");

class saw {
    public $data_pariwisata;
    public $list_data_pariwisata_attribut;
    public $nilai_saw;
 
    public function __construct(){
    }
 
    public function all($db,$list_query) {

        $criteriaRangesArray = array();
        $list_kriteria = array();
        foreach($list_query->list_kriteria_ranges as $d) {
            foreach($d->list_kriteria_ranges as $di) {
                array_push($criteriaRangesArray,$di->kriteria_range_id);
            }

            $kriteria = new kriteria();
            $kriteria->id = $d->kriteria_id;
            array_push($list_kriteria,$kriteria->one($db)->data);
        }

        $criteriaRanges = implode(",", $criteriaRangesArray);
 
        $result_query = new result_query();
        $all = array();
        $query = "SELECT 
                    at.data_pariwisata_id
                FROM 
                    data_pariwisata_attribut at
                INNER JOIN
                    data_pariwisata dp
                ON
                    dp.id = at.data_pariwisata_id
                WHERE
                    dp.kategori_id = ?
                GROUP BY 
                    at.data_pariwisata_id
                LIMIT ? 
                OFFSET ?";
        $stmt = $db->prepare($query);
        $offset = $list_query->offset;
        $limit =  $list_query->limit;
        $kategori_id = $list_query->kategori_id;
        $stmt->bind_param('iii' ,$kategori_id, $limit, $offset);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at query all saw : ".$stmt->error;
            
            $response = new saw_response();
            $response->list_kriteria = $list_kriteria;
            $response->list_hasil = array();
        
            $result_query->data = $response;
            return $result_query;
        }
        $rows = $stmt->get_result();
        if($rows->num_rows == 0){
            $stmt->close();

            $response = new saw_response();
            $response->list_kriteria = $list_kriteria;
            $response->list_hasil = array();
        
            $result_query->data = $response;
            return $result_query;
        }

        while ($result = $rows->fetch_assoc()){
            $one = new saw();

            $data_pariwisata = new data_pariwisata();
            $data_pariwisata->id = $result['data_pariwisata_id'];
            $one_data_pariwisata = $data_pariwisata->one($db)->data;
            $one->data_pariwisata = $one_data_pariwisata;

            $data_pariwisata_attribut = new data_pariwisata_attribut();
            $list_data_pariwisata_attribut = $data_pariwisata_attribut->allByPariwisataID($db,$data_pariwisata->id,$criteriaRanges)->data;
            $one->list_data_pariwisata_attribut = $list_data_pariwisata_attribut;

            $one->nilai_saw = 0.0;

            array_push($all,$one);
        }
        $result_query->data = hitungSAW($list_kriteria,$all);
        $stmt->close();
        return $result_query;
    } 
}

function hitungSAW($list_kriteria,$list_saw){
    $response = new saw_response();
    $response->list_kriteria = $list_kriteria;
    $response->list_hasil = array();

    $minMax = getMinMax($list_kriteria, $list_saw);
    $response->min_max = $minMax;
    
    $normalize = normalize($minMax, $list_saw);

    foreach ($normalize as $v) {

        $cm = array();
        foreach ($list_kriteria as $cv) {
            $cm["kriteria-id-".$cv->id] = $cv->nilai;
        }

        $result = new Saw();
        $result->data_pariwisata = $v->data_pariwisata;
        $result->list_data_pariwisata_attribut = $v->list_data_pariwisata_attribut;
        $result->nilai_saw = 0.0;

        foreach ($v->list_data_pariwisata_attribut as $aa) {
            if (isset($cm["kriteria-id-".$aa->kriteria_range->kriteria_id])){               
                $result->nilai_saw += $cm["kriteria-id-".$aa->kriteria_range->kriteria_id] * $aa->kriteria_range->nilai;
            }
        }

        array_push($response->list_hasil,$result);
    }

    usort($response->list_hasil, function($a, $b) {return strcmp($b->nilai_saw, $a->nilai_saw);});

    return $response;
}

function getMinMax($list_kriteria,$list_saw){
    $results = array();
    foreach ($list_kriteria as $criteria) {
        foreach($list_saw as $d) {
            switch ($criteria->attribut) {
                case "COST":
                    if (isset($results["kriteria-id-".$criteria->id])){
                        $holder = $results["kriteria-id-".$criteria->id];
                        $min = getMin($criteria, $d->list_data_pariwisata_attribut);
                        $results["kriteria-id-".$criteria->id] = $min->nilai < $holder->nilai ? $min : $holder;
                    } else {
                        $results["kriteria-id-".$criteria->id] = getMin($criteria, $d->list_data_pariwisata_attribut);
                    }
                    break;
                case "BENEFIT":
                    if (isset($results["kriteria-id-".$criteria->id])){
                        $holder = $results["kriteria-id-".$criteria->id];
                        $max = getMax($criteria, $d->list_data_pariwisata_attribut);
                        $results["kriteria-id-".$criteria->id] = $max->nilai > $holder->nilai ? $max : $holder;
                    } else {
                        $results["kriteria-id-".$criteria->id] = getMin($criteria, $d->list_data_pariwisata_attribut);  
                    }
                    break;
                default:
                    break;
            }            
        }
    }
    return $results;   
}

function normalize($min_max,$list_saw){
    $results = array();
    foreach ($list_saw as $v) {
        $result = new Saw();
        $result->data_pariwisata = $v->data_pariwisata;
        $result->list_data_pariwisata_attribut = array();
        $result->nilai_saw = 0.0;

        foreach ($v->list_data_pariwisata_attribut as $d) {
            $value = 0.0;
            $cr = $min_max["kriteria-id-".$d->kriteria_range->kriteria_id];
            switch ($cr->attribut) {
            case "COST":
                $value = $cr->nilai / $d->kriteria_range->nilai;
                break;
            case "BENEFIT":
                $value = $d->kriteria_range->nilai / $cr->nilai;
                break;
            default:
                break;
            }
            $aa = new data_pariwisata_attribut();
            $aa->id = $d->id;
            $aa->data_pariwisata_id = $d->data_pariwisata_id;
            $aa->kriteria_range = $d->kriteria_range;
            $aa->kriteria_range->nilai = $value;

            array_push($result->list_data_pariwisata_attribut,$aa);
        }
        array_push($results,$result);
    }
    return $results;
}

class saw_response {

    public $list_kriteria;
    public $min_max;
    public $list_hasil;

    public function __construct(){
    }
}

class min_max {
	public $attribut;
    public $nilai;

    public function __construct(){
    }
}

function getMin($kriteria,$list_data_pariwisata_attribut){
    $min = new min_max();
    $min->attribut = $kriteria->attribut;
    $holder = 0;
	foreach ($list_data_pariwisata_attribut as $v)  {
        if ($v->kriteria_range->kriteria_id == $kriteria->id){
            if ($v->kriteria_range->nilai < $holder) {
                $holder = $v->kriteria_range->nilai;
            }
            if ($holder == 0){
                $holder = $v->kriteria_range->nilai;
            }
		}
    }
    $min->nilai = $holder;
	return $min;
}

function getMax($kriteria,$list_data_pariwisata_attribut){
    $min = new min_max();
    $min->attribut = $kriteria->attribut;
    $holder = 0;
	foreach ($list_data_pariwisata_attribut as $v)  {
        if ($v->kriteria_range->kriteria_id == $kriteria->id){
            if ($v->kriteria_range->nilai > $holder) {
                $holder = $v->kriteria_range->nilai;
            }
            if ($holder == 0){
                $holder = $v->kriteria_range->nilai;
            }
		}
    }
    $min->nilai = $holder;
	return $min;
}

?>