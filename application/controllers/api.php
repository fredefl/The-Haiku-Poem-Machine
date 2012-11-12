<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends CI_Controller {

	/**
	 * This function saves a Poem
	 * @since 1.0
	 * @access public
	 */
	public function Save () {
		$this->load->library("poem");
		$Poem = new Poem();
		if ($_SERVER['REQUEST_METHOD'] == "POST" && file_get_contents("php://input") !== false)  {
			$this->load->library("poem");
			$Poem = new Poem();
			$Poem->Import(json_decode(file_get_contents("php://input"),true));
			if (empty($Poem->language) || empty($Poem->creator) || empty($Poem->sentences) || !empty($Poem->sentences) && count($Poem->sentences) == 0) {
				header("Status: 404 Bad Request");
			}
			$Poem->Save();
		} else {
			header("Status: 404 Bad Request");
		}
	}
}