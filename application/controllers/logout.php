<?php
class Logout extends CI_Controller{
    function __construct()
	{
		parent::__construct();
        $this->load->model(MODEL_ION_AUTH);
	}
    function index()
    {
        $this->ion_auth->logout();
        redirect($this->config->item('base_url'));
    }
}