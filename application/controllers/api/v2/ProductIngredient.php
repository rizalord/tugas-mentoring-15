<?php

/**
 * Product class.
 * 
 * @extends REST_Controller
 */
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class ProductIngredient extends REST_Controller
{

    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
     */
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();
        $this->load->library('Authorization_Token');
        $this->load->model('Product_model');
        $this->load->model('ProductIngredient_model');
    }

    /**
     * SHOW | GET method.
     *
     * @return Response
     */
    public function index_get($id)
    {
        $product = $this->Product_model->show($id);
        
        if (empty($product)) {
            $this->response([
                'message' => 'Product not found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

        $data = $this->ProductIngredient_model->showWhereProductId($id);

        $this->response([
            'message' => 'Product Ingredient fetched successfully.',
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    /**
     * INSERT | POST method.
     *
     * @return Response
     */
    public function index_post($id)
    {
        $product = $this->Product_model->show($id);

        if (empty($product)) {
            $this->response([
                'message' => 'Product not found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

        $input = $this->_post_args['data'];

        foreach ($input as $key => $value) {
            $input[$key]['product_id'] = $id;
        }

        $this->ProductIngredient_model->deleteWhereProductId($id);
        $this->ProductIngredient_model->insertBatch($input);

        $data = $this->ProductIngredient_model->showWhereProductId($id);

        $this->response([
            'message' => 'Product Ingredient updated successfully.',
            'data' => $data
        ], REST_Controller::HTTP_CREATED);
    }
}
