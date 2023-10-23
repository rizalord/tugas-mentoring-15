<?php

/**
 * Welcome class.
 * 
 * @extends REST_Controller
 */
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Welcome extends REST_Controller
{

    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Authorization_Token');
    }

    public function index_get()
    {
        $this->response([
            'message' => 'Mentoring 15 REST API dan JWT',
            'data' => null
        ], REST_Controller::HTTP_OK);
    }
}
