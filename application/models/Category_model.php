<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    private $table = 'category';
  
    /**
     * CONSTRUCTOR | LOAD DB
    */
    public function __construct() {
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
        if(!empty($id)){
            $query = $this->db->get_where($this->table, ['category_id' => $id])->row_array();
        }else{
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
        $data = $this->db->update($this->table , $data, array('category_id'=>$id));
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
        $this->db->delete($this->table, array('category_id'=>$id));
        return $this->db->affected_rows();
    }
}
