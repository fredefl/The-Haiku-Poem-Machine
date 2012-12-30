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
			header("Status: 404 Not Found");
			echo json_encode(array("error" => "400"));
			die();
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
	 * This endpoint outputs all the poems assosiated with a tag
	 * @since 1.0
	 * @access public
	 * @param string $tag The tag to search for
	 */
	public function GetPoemByStringTag ($tag) {
		$this->load->library("tag");
		$TagObject = new Tag();
		if ($TagObject->Load(array("tag" => $tag))) {
			$this->load->model("tags");
			$poems = $this->tags->GetPoemsByTag($TagObject->id);
			if ($tag !== false) {
				echo json_encode(array("poems" => $poems));
			} else {
				echo json_encode(array("error" => "404"));
			}
		} else {
			echo json_encode(array("error" => "404"));
		}
	}

	/**
	 * This endpoint outputs all the poems assosiated with a tag
	 * @since 1.0
	 * @access public
	 * @param integer $tag The id of the tag to search for
	 */
	public function GetPoemByIdTag ($tag) {
		$this->load->model("tags");
		$poems = $this->tags->GetPoemsByTag($tag);
		if ($poems !== false) {
			echo json_encode(array("poems" => $poems));
		} else {
			echo json_encode(array("error" => "404"));
		}
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
	 * This function outputs all the avaiable tags,
	 * use $_GET["limit"] to limit the amount of tags shown,
	 * and use $_GET["search"] to search
	 * @since 1.0
	 * @access public
	 */
	public function GetTags () {
		$this->load->model("tags");

		$limit = null;
		$search = null;

		if (isset($_GET["limit"])) {
			$limit = $_GET["limit"];
		}

		if (isset($_GET["search"])) {
			$search = $_GET["search"];
		}

		$tags = $this->tags->Get($limit, $search);

		if ($tags !== false) {
			echo json_encode(array("tags" => $tags));
		} else {
			echo json_encode(array("error_message" => $this->lang->line("errors_no_tags_found"),"error" => "404"));
		}
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

	/**
	 * This function creates a collection
	 * @since 1.0
	 * @access public
	 */
	public function CreateCollection () {
		if ($_SERVER['REQUEST_METHOD'] == "POST" && file_get_contents("php://input") !== false)  {
			$this->load->library("collection");
			$Collection = new Collection();
			$Collection->Import(json_decode(file_get_contents("php://input"),true));

			if ($Collection->Save()) {
				echo json_encode(array("status" => "success","identifier" => $Collection->identifier,"url" => $this->config->item("base_url") . "/" . $Collection->identifier));
			} else {
				echo json_encode(array("status" => "fail"));
			}
		} else {
			header("Status: 404 Not Found");
			echo json_encode(array("error" => "400"));
			die();
		}
	}

	/**
	 * This function outputs the next collections via a HTML template
	 * @since 1.0
	 * @access public
	 */
	public function GetCollections () {
		$page = 1;
		$rowsPerPage = 2;
		$this->load->library("input");
		if ($this->input->get("page") !== false) {
			$page = $this->input->get("page");
		}
		if ($this->input->get("rows") !== false) {
			$page = $this->input->get("rows");
		}
		if ($page == 1) {
			$offset = 0;
		} else if ($page == 2 && $rowsPerPage > 1) {
			$offset = $page+$rowsPerPage-2;
		} else if ($rowsPerPage > 1) {
			$offset = $page+$rowsPerPage-1;
		} else {
			$offset = $page-1;
		}
		if ($offset < 0) {
			$offset = round($page-1);
		}
		header('Content-type: application/json');
		$this->load->model("collections");
		$collections = $this->collections->Find($this->ui_helper->language,$rowsPerPage,$offset);
		if ($collections === false) {
			echo json_encode(array("offset" => $offset,"error_message" => $this->lang->line("errors_no_collections_found")));
			return;
		}
		$output = array();
		foreach ($collections as $key => $collection) {
			if (isset($collections[$key]->time_created)) {
				$collections[$key]->time_created = date($this->lang->line("home_date_time_format"),$collections[$key]->time_created);
			}
			$output[] = $collections[$key]->Export(); 
		}
		echo json_encode(array("offset" => $offset,"collections" => $output,"page" => $page,"pages" => $this->collections->pageLimit($this->ui_helper->language,$rowsPerPage)));
	}
}