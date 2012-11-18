<?php
class Ui_Helper {

	/**
	 * An instance of CodeIgniter
	 * @since 1.0
	 * @access private
	 * @var object
	 */
	private $_CI = null;

	/**
	 * The current language
	 * @since 1.0
	 * @access public
	 * @var string
	 */
	public $language = "english";

	/**
	 * The standard language files to load
	 * @since 1.0
	 * @access public
	 * @var array
	 */
	public $languageFiles = array(
		"home",
		"ajax",
		"navigate",
		"errors",
		"info",
		"pages"
	);

	/**
	 * The construtor
	 * @since 1.0
	 * @access public
	 */
	public function __construct () {
		session_start();
		$this->_CI =& get_instance();
		$this->_CI->load->library("input");
		$this->_CI->load->helper("cookie");

		if ($this->_CI->input->get("language") !== false && in_array($this->_CI->input->get("language"), $this->_CI->config->item("supported_languages"))) {
			$this->language = $this->_CI->input->get("language");
			$_SESSION["language"] = $this->language;
		} else if (isset($_SESSION["language"]) && in_array($_SESSION["language"], $this->_CI->config->item("supported_languages"))) {
			$this->language = $_SESSION["language"];
		}

		$this->batch_load_lang_files($this->languageFiles);
	}

	/**
	 * This function loads up lang files using an array
	 * @param  array  $files The array of file without extension and _lang
	 * @since 1.0
	 * @access public
	 */
	public function batch_load_lang_files ( array $files ) {
		$this->languageFiles = array_unique(array_merge($this->languageFiles,$files));
 		foreach ($files as $file) {
 			if (is_file(FCPATH."application/language/".$this->language."/".$file."_lang.php")) {
 				$this->_CI->lang->load($file, $this->language);
 			}
 		}
	}

	/**
	 * This function returns all the needed settings variables for the controller
	 * @since 1.0
	 * @access public
	 * @param array $extraSettings The extra settings to merge in
	 */
	public function ControllerInfo ($extraSettings = null) {
		$settings = array(
			"html5_shiv_url" => $this->_CI->config->item("html5_shiv_url"),
			"jquery_ui_js_url" => $this->_CI->config->item("jquery_ui_js_url"),
			"jquery_ui_css_url" => $this->_CI->config->item("jquery_ui_css_url"),
			"jquery_url" => $this->_CI->config->item("jquery_url"),
			"assets_url" => $this->_CI->config->item("assets_url"),
			"image_url" => $this->_CI->config->item("image_url"),
			"css_url" => $this->_CI->config->item("css_url"),
			"js_url" => $this->_CI->config->item("js_url"),
			"fonts_url" => $this->_CI->config->item("fonts_url"),
			"base_url" => base_url(),
			"language" => $this->language,
			"current_time" => time()
		);
		if (!is_null($extraSettings)) {
			return array_unique(array_merge($settings,$extraSettings));
		} else {
			return $settings;
		}
	}
}
?>