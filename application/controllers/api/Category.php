<?php

/**
 * Category class.
 * 
 * @extends REST_Controller
 */
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Category extends REST_Controller
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
        $this->load->model('Category_model');
    }

    /**
     * SHOW | GET method.
     *
     * @return Response
     */
    public function index_get($id = 0)
    {
        $headers = $this->input->request_headers();
        if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status']) {
                // ------- Main Logic part -------
                if (!empty($id)) {
                    $data = $this->Category_model->show($id);
                } else {
                    $data = $this->Category_model->show();
                }
                $this->response([
                    'message' => 'Category fetched successfully.',
                    'data' => $data
                ], REST_Controller::HTTP_OK);
                // ------------- End -------------
            } else {
                $this->response([
                    'message' => 'Authentication failed'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response([
                'message' => 'Authentication failed'
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * INSERT | POST method.
     *
     * @return Response
     */
    public function index_post()
    {
        $headers = $this->input->request_headers();
        if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status']) {
                // ------- Main Logic part -------
                $input = $this->input->post();
                $id = $this->Category_model->insert($input);
                $data = $this->Category_model->show($id);

                $this->response([
                    'message' => 'Category created successfully.',
                    'data' => $data
                ], REST_Controller::HTTP_CREATED);
                // ------------- End -------------
            } else {
                $this->response([
                    'message' => 'Authentication failed'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response([
                'message' => 'Authentication failed'
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * UPDATE | PUT method.
     *
     * @return Response
     */
    public function index_put($id)
    {
        $headers = $this->input->request_headers();
        if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status']) {
                // ------- Main Logic part -------
                $headers = $this->input->request_headers();
                $data['category_name'] = $headers['category_name'];
                $response = $this->Category_model->update($data, $id);
                $category = $this->Category_model->show($id);

                $response > 0
                    ? $this->response([
                        'message' => 'Category updated successfully.',
                        'data' => $category
                    ], REST_Controller::HTTP_OK)
                    : $this->response([
                        'message' => 'Not updated',
                        'errors' => [],
                    ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                // ------------- End -------------
            } else {
                $this->response([
                    'message' => 'Authentication failed'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response([
                'message' => 'Authentication failed'
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * DELETE method.
     *
     * @return Response
     */
    public function index_delete($id)
    {

        $headers = $this->input->request_headers();
        if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status']) {
                // ------- Main Logic part -------
                $response = $this->Category_model->delete($id);

                $response > 0
                    ? $this->response([
                        'message' => 'Category deleted successfully.',
                        'data' => null
                    ], REST_Controller::HTTP_OK)
                    : $this->response([
                        'message' => 'Not deleted',
                        'errors' => [],
                    ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                // ------------- End -------------
            } else {
                $this->response([
                    'message' => 'Authentication failed'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response([
                'message' => 'Authentication failed'
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}
