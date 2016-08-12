<?php

/**
 * Created by PhpStorm.
 * User: acer
 * Date: 5/31/2016
 * Time: 9:54 PM
 */
class Vendor_model extends CI_Model
{
    public $table = 'vendor';
    public $id = 'venId';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }

    function get_all()//fungsi untuk memangil semua data admin dari kampus
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }
    function get_all_array()//fungsi untuk memangil semua data admin dari kampus
    {
        $return = array();
        $this->db->order_by($this->id, $this->order);
        $res =  $this->db->get($this->table)->result();
      
        foreach ($res as $key => $value) {
            $return[$value->venId] = $value->venName;
        }
        return $return;
    }




    // get data by id
    function get_by_id($id)//mencari data berdasarkan
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows() {//mencari jumlah semua data yang ada di database
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit
    function index_limit($limit, $start = 0) {//mencacah data di database sesuai batas paginasi
        $this->db->order_by($this->id, $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // get search total rows
    function search_total_rows($keyword = NULL) {//mencari jumlah dari pencarian
        $this->db->like('venKode', $keyword);
        $this->db->or_like('venName', $keyword);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get search data with limit
    function search_index_limit($limit, $start = 0, $keyword = NULL) {//mencacah data sesuai batas paginasi sesuai kunci pencarian
        $this->db->order_by($this->id, $this->order);
        $this->db->like('venKode', $keyword);
        $this->db->or_like('venName', $keyword);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)//insert data ke database
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)//update data di database
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}