<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{
    private $table = 'product';

    /**
     * CONSTRUCTOR | LOAD DB
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * SHOW | GET method.
     *
     * @return Response
     */
    public function show($id = 0)
    {
        if (!empty($id)) {
            $query = $this->db->get_where($this->table, ['product_id' => $id])->row_array();
        } else {
            $query = $this->db->get($this->table)->result();
        }
        return $query;
    }

    /**
     * INSERT | POST method.
     *
     * @return Response
     */
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * UPDATE | PUT method.
     *
     * @return Response
     */
    public function update($data, $id)
    {
        $data = $this->db->update($this->table, $data, array('product_id' => $id));
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    /**
     * DELETE method.
     *
     * @return Response
     */
    public function delete($id)
    {
        $this->db->delete($this->table, array('product_id' => $id));
        return $this->db->affected_rows();
    }
}
