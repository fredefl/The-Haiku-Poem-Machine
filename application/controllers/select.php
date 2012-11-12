<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Select extends CI_Controller {

	/**
	 * This funtion outputs the available sentences for a language
	 * @since 1.0
	 * @access public
	 */
	public function index () {
		$this->load->model("sentences");

		$sentences = $this->sentences->Load($this->ui_helper->language);
		/*if ($sentences === false) {
			echo json_encode(array("error_message" => $this->lang->line("errors_no_sentences_found"),"status" => "false"));
			return;
		}*/

		$outputSentences = array();

		$box = array(
			"boxTitle" => $this->lang->line("ajax_title"),
			"selectTitle" => $this->lang->line("ajax_select_title")
		);
		$outputSentences = array();
		if (is_array($sentences)) {
			foreach ($sentences as $sentence) {
				$outputSentences[$sentence->syllabels][] = trim($sentence->sentence);
			}
		}
		
		header('Content-type: application/json');
		echo json_encode(self::_merge($box,array("sentences" => $outputSentences,"selects" => array("5","7","5"))));
	}

	/**
	 * This function merges the arrats leaving the keys the same
	 * @return array
	 * @since 1.0
	 * @access private
	 * @param array array1,array2
	 */
	private function _merge () {
		$return = array();
		foreach (func_get_args() as $arg) {
			foreach ($arg as $key => $value) {
				$return[$key] = $value;
			}
		}
		return $return;
	}
}
?>