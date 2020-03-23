<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    parent::__construct();
	}
	
	public function index()
	{
		$response = array('status' => $this->uri->segment(3, 0));

		   $this->output
        		->set_status_header(200)
        		->set_content_type('application/json', 'utf-8')
        		->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
	}
}
