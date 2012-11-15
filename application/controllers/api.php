<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends CI_Controller {

	/**
	 * This function saves a Poem
	 * @since 1.0
	 * @param string $identifier The collection identifier
	 * @access public
	 */
	public function Save ($identifier = null) {
		$Collection = self::_Check_Collection($identifier);		

		$this->load->library("poem");
		$Poem = new Poem();
		if ($_SERVER['REQUEST_METHOD'] == "POST" && file_get_contents("php://input") !== false && $Collection !== false)  {
			$this->load->library("poem");
			$Poem = new Poem();
			$Poem->Import(json_decode(file_get_contents("php://input"),true));
			if (empty($Poem->language) || empty($Poem->creator) || empty($Poem->sentences) || !empty($Poem->sentences) && count($Poem->sentences) == 0) {
				header("Status: 404 Bad Request");
			}
			$Poem->Save();
			$Collection->Import(array("poems" => $Poem->id));
			$Collection->Save();
		} else {
			header("Status: 400 Bad Request");
		}
	}

	/**
	 * This function outputs the {x} newest poems from a specific collection or all collections
	 * @since 1.0
	 * @access public
	 * @param string $identifier An optional string identifier for a collection
	 */
	public function Live ($identifier = null) {
		header('Content-type: application/json');

		$this->load->library("input");
		$this->load->model("poems");
		$Collection = self::_Check_Collection($identifier);

		$limit = $this->config->item("home_live_limit");

		if ($this->input->get("limit") !== false) {
			$limit = $this->input->get("limit");
		}

		if ($Collection !== false) {
			$poems = $this->poems->Load($this->ui_helper->language,$limit,"time_created","desc",$Collection->id);
			
		} else {
			$poems = $this->poems->Load($this->ui_helper->language,$limit,"time_created","desc");
		}

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

	/**
	 * This function loads up a collection by it's string identifier
	 * @since 1.0
	 * @access public
	 * @param string $identifier The string identifier
	 */
	public function Collection ($identifier = null) {
		$Collection = self::_Check_Collection($identifier);
		header("Content-Type: application/json");
		if ($Collection !== false) {
			echo json_encode($Collection->Export());
		} else {
			header("Status: 400 Bad Request");
		}
	}

	/**
	 * This function checks if a collection can be loaded
	 * @since 1.0
	 * @access private
	 * @param stirng $identifier The collection identifier
	 */
	private function _Check_Collection ($identifier = null) {
		$this->load->library("Collection");
		$Collection = new Collection();
		if ($Collection->Load(array("identifier" => $identifier))) {
			return $Collection;
		} else {
			return false;
		}
	}

	/**
	 * This function outputs the avaiable sentences and the collection data
	 * @since 1.0
	 * @access public
	 * @param string $identifier The collection identifier
	 */
	public function Select ($identifier = null) {
		$Collection = self::_Check_Collection($identifier);
		header("Content-Type: application/json");
		if ($Collection !== false) {
			self::_Load_Sentences($Collection);
		} else {
			header("Status: 400 Bad Request");
		}
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

	/**
	 * This function loads up and outputs all the available sentences
	 * @since 1.0
	 * @access private
	 * @param string $Collection The collection that is being viewed
	 */
	private function _Load_Sentences (&$Collection) {
		$this->load->model("sentences");

		$sentences = $this->sentences->Load($this->ui_helper->language);

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
		echo json_encode(self::_merge($box,array("sentences" => $outputSentences,"selects" => $Collection->selects)));
	}

	/**
	 * This function outputs
	 * @param string $identifier The string identifier for the poem
	 * @since 1.0
	 * @access public
	 */
	public function Poem ($identifier = null) {
		$this->load->library("poem");
		$Poem = new Poem();
		if ($Poem->Load(array("identifier" => $identifier))) {
			header('Content-type: application/json');
			echo json_encode($Poem->Export());
		} else {
			header("Status: 404 Not Found");
		}
	}
}