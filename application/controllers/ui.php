<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ui extends CI_Controller {

	/**
	 * This function loads up the view with the mode set to view collection
	 * @since 1.0
	 * @access public
	 * @param string $identifier The collection identifier
	 */
	public function ViewCollection ($identifier = null) {
		self::_Load_Collection($identifier, "view");
	}

	/**
	 * This function checks if a collection exists and add
	 * @param string $identifier The collection identifier
	 * @param string $mode       The operation "mode", options are atm "create" or "view"
	 * @since 1.0
	 * @access private
	 */
	private function _Load_Collection ($identifier = null, $mode = "view") {
		$this->load->library("collection");
		$Collection = new Collection();
		if ($Collection->Load(array("identifier" => $identifier))) {
			$this->load->view("home_view",$this->ui_helper->ControllerInfo(array(
				"collection" => $Collection->identifier,
				"mode" => $mode
			)));
		} else {
			show_404();
		}
	}

	/**
	 * This function loads up the home view with the collection info
	 * @since 1.0
	 * @access public
	 * @param string $identifier The collection identifier
	 */
	public function CreatePoemCollection ($identifier = null) {
		self::_Load_Collection($identifier, "create");
	}

	/**
	 * This function "loads" up the data for the standard collection
	 * @since 1.0
	 * @access public
	 */
	public function Home () {
		self::CreatePoemCollection($this->config->item("home_collection_identifier"));
	}

	/**
	 * This function shows a poem found by it's string identifier
	 * @param string $identifier The poem stirng identifier
	 * @since 1.0
	 * @access public
	 */
	public function ViewPoem ($identifier = null) {
		$this->load->library("poem");
		$Poem = new Poem();
		if ($Poem->Load(array("identifier" => $identifier))) {
			$this->load->view("poem_view",$this->ui_helper->ControllerInfo(array(
				"poem" => $Poem
			)));
		} else {
			self::Home();
		}
	}

	/**
	 * This function shows the collections view
	 * @since 1.0
	 * @access public
	 */
	public function Collections () {
		$this->load->model("collections");
		$collections = $this->collections->Find($this->ui_helper->language);
		$this->load->view("collections_view",$this->ui_helper->ControllerInfo());
	}
}
?>