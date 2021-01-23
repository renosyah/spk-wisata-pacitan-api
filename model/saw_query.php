<?php

// class list query
// ini adalah class yg nantinya akan dijadikan
// object untuk query data-data yg banyak
// ke database
class saw_query {

    public $list_kriteria_ranges;
    public $offset;
    public $limit;

    // konstruksi
    // fungsi yg akan dipanggil saat
    // membuat object
    public function __construct(){
    }

    public function set($data){
        $this->list_kriteria_ranges = $data->list_kriteria_ranges;
        $this->offset = (int)$data->offset;
        $this->limit = (int)$data->limit;
    }
}

?>