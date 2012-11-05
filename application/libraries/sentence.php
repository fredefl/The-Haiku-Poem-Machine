<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Sentence extends Std_Library{

	/**
	 * The database identifier for the sentence
	 * @since 1.0
	 * @access public
	 * @var integer
	 */
	public $id = null;

	/**
	 * The actual sentence
	 * @since 1.0
	 * @access public
	 * @var string
	 */
	public $sentence = null;

	/**
	 * The language of the sentence
	 * @var string
	 * @since 1.0
	 * @access public
	 */
	public $language = null;

	/**
	 * The number of syllabels in the sentence
	 * @since 1.0
	 * @access public
	 * @var integer
	 */
	public $syllabels = null;

	############ Class Settings ###################

	/**
	 * This variable stores the database table for the class
	 * @var string
	 * @access public
	 * @since 1.0
	 */
	public $Database_Table = "sentences";

	/**
	 * This is the concstructor, it configurates the std library
	 * @since 1.0
	 * @access public
	 */
	public function __construct(){
		parent::__construct();
		$this->_INTERNAL_EXPORT_INGNORE = array(
			"CI",
			"Database_Table",
			"_CI"
		);
		$this->_INTERNAL_NOT_ALLOWED_DUBLICATE_ROWS = 	array(
			"sentence"
		);
		$this->_INTERNAL_DATABASE_EXPORT_INGNORE = array("id");
	}

	/**
	 * This function saves the sentence and checks if the sentence is in the correct format
	 * @since 1.0
	 * @access public
	 * @return boolean
	 */
	public function Save () {
		if (!is_null($this->sentence) && !is_null($this->language)) {
			return parent::Save();
		} else {
			return false;
		}
	}
}
?>