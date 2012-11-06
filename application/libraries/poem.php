<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Poem extends Std_Library{

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
	public $sentences = null;

	/**
	 * The name of the poems creator
	 * @since 1.0
	 * @access public
	 * @var string
	 */
	public $creator = null;

	/**
	 * The name of the poem
	 * @var string
	 * @since 1.0
	 * @access public
	 */
	public $name = null;

	/**
	 * A short description of the poem
	 * @since 1.0
	 * @access public
	 * @var string
	 */
	public $description = null;

	/**
	 * The poems language
	 * @since 1.0
	 * @access public
	 * @var string
	 */
	public $language = null;

	/**
	 * The time the poem was created
	 * @since 1.0
	 * @access public
	 * @var integer
	 */
	public $time_created = null;

	############ Class Settings ###################

	/**
	 * This variable stores the database table for the class
	 * @var string
	 * @access public
	 * @since 1.0
	 */
	public $Database_Table = "poems";

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
		$this->_INTERNAL_CREATED_TIME_PROPERTY = array("time_created");
		$this->_INTERNAL_LOAD_FROM_CLASS = array(
			"sentences" => "Sentence"
		);
		$this->_INTERNAL_FORCE_ARRAY = array("sentences");
		$this->_INTERNAL_DATABASE_EXPORT_INGNORE = array("id");
		$this->_INTERNAL_LINK_PROPERTIES = array("sentences" => array("poem_sentences",array("poem_id" => "id"),"sentence_id"));
	}
}
?>