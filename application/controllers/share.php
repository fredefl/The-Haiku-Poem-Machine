<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Share extends CI_Controller {

	public function index()
	{
		redirect($this->config->item('base_url'));
	}
}