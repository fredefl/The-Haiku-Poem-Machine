<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->library('Lang');
		$Language = new Lang();
		$data = self::Settings($Language,"Hjem");
		$this->load->view('home_view',$data);
	}
	
	/*
	*A function that translate all the requiered text and gets all the requiered settings from the config files
	* @param {Object} Language    An instance of the Lang library
	* @param {String} PageTitle   The Language in the Culture Format specified in illutio_users.languages
	* @return {Array} Settings   Returns and array in the accepted format form CodeIgniter load->view
	*/
	private function Settings($Language,$PageTitle){
		if($this->input->get('lang',TRUE) != ""){
			$Lang = $this->input->get('lang',TRUE);
		}
		else{
			$Lang = "da-DK";	
		}
		$SupportedLanguages = $this->config->item('supported_languages');
		if($Lang != "da-DK"){
			if(!array_key_exists($Lang,$SupportedLanguages)){
				$Lang = "en-GB";
			}
		}
		$LangString = $Language->GetLanguage($Lang);
		if(!isset($LangString["Language"])){
			$LangString["Language"] = "Dansk";
			$LangString["Country"] = "Danmark";
			$Lang = "da-DK";
		}
		if($Lang == "da-DK"){
			$LangString["Language"] = "Dansk";
			$LangString["Country"] = "Danmark";
		}
		$Time = $Language->Translate("Tid",$Lang);
		$All = $Language->Translate("Alle Digte",$Lang);
		$IdDialog = $Language->Translate("Vælg id",$Lang);
		$IdLabel = $Language->Translate("Skriv digtets Id",$Lang);
		$TextDataArray = array(
			'TimeInterval' => 'Vælg tids interval',
			'NameData' => 'Forfatter',
			'NameDataText' => 'Ønskede forfatters navn:',
			'TimeDataText' => 'Skriv kun hele tal',
			'Hours' => 'Timer',
			'Minute' => 'Minutter',
			'Sec' => 'Sekunder',
			'Days' => 'Dage',
			'Months' => 'Måneder',
			'Years' => 'År',
			'Week' => 'Uger' ,
			'Search' => 'Søg',
			'FiveSyllables' => 'Skriv en sætning på 5 stavelser:',
			'WriteASentece' => 'Skriv en sætning',
			'Name' => 'Skriv dit navn',
			'Save' => 'Gem',
			'Syllables' => 'Skriv en sætning på {0} stavelser:'
		);
		
		$TextData = self::TextData($TextDataArray,$Language,$Lang);
		$Creator = $Language->Translate("Forfatter",$Lang);
		$CurrentTime = time();
		$Page_Title = "Haiku - ".$Language->Translate($PageTitle,$Lang)." - ".$LangString["Language"];
		$Settings = array(
			'assets_url' => $this->config->item('assets_url'),
			'image_url' => $this->config->item('image_url'),
			'css_url' => $this->config->item('css_url'),
			'js_url' => $this->config->item('js_url'),
			'base_url' => $this->config->item('base_url'),
			'fonts_url' => $this->config->item('fonts_url'),
			'base_url' => $this->config->item('base_url'),
			'lang' => $LangString["Language"],
			'country' => $LangString["Country"],
			'langcode' => $Lang,
			'page_title' => $Page_Title,
			'time' => $Time,
			'creator' => $Creator,
			'all' => $All,
			'current_time' => $CurrentTime,
			'text_data' => $TextData,
			'id_dialog' => $IdDialog,
			'id_label' => $IdLabel
		);
		return $Settings;
	}
	
	/*
	*Translates all the information specified in the first parameters to third perameter language using the Lang library specified in the Language perameter
	* @param {Array} Input    The input array specified with "Title" => "data"
	* @param {Object} Language    An instance of the Lang library
	* @param {String}	Lang    The Language in the Culture Format specified in illutio_users.languages
	* @return {Array} Output	   Returns an arrat in the format "Title" => "Translated text"
	*/
	private function TextData($Input,$Language,$Lang){
		$Output = array();
		foreach($Input as $Name => $Value){	
			$Output[$Name] = $Language->Translate($Value,$Lang);
		}
		return $Output;
	}
}
