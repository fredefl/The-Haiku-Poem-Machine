<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Live extends CI_Controller {
		
	/**
	 * This function outputs the latest poems
	 * use $_GET["limit"] to specify the number of rows
	 * @since 1.0
	 * @access public
	 */
	public function index(){
		header('Content-type: application/json');
		$this->load->library("input");
		$this->load->model("poems");

		$limit = 3;

		if ($this->input->get("limit") !== false) {
			$limit = $this->input->get("limit");
		}

		$poems = $this->poems->Load($this->ui_helper->language,$limit,"time_created","desc");

		if ($poems === false) {
			echo json_encode(array("error_message" => $this->lang->line("errors_no_sentences_found"),"status" => "false"));
			return;
		}

		$result = array();
		foreach ($poems as $poem) {
			$result["poems"][] = $poem->Export();
		}

		echo json_encode($result);
	}
}
?>