<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller {

	/**
	 * This funtion outputs the available sentences for a language
	 * @since 1.0
	 * @access public
	 */
	public function index () {
		$this->load->model("sentences");
		$this->load->library('Sentenceclass');
		$SentenceClass = new Sentenceclass();

		$sentences = $this->sentences->Load($this->ui_helper->language);
		if ($sentences === false) {
			echo json_encode(array("error_message" => $this->lang->line("errors_no_sentences_found"),"status" => "false"));
			return;
		}
		
		$SentenceClass->SetBoxTitle($this->lang->line("ajax_title"));
		$SentenceClass->SetSelectTitle($this->lang->line("ajax_syllabels"));

		foreach ($sentences as $sentence) {
			$SentenceClass->AddSentence($sentence->syllabels,trim($sentence->sentence));
		}
		
		header('Content-type: application/json');
		echo $SentenceClass->ToJson();
	}
}
?>