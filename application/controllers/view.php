<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class View extends CI_Controller {

	public function index()
	{
		$this->load->library('Lang');
		$Language = new Lang();
		if(self::GetData() != ""){
			$Get = self::GetData();
		}
		else{
			$Get = array();	
		}
		if(!count($Get)>0){
			$Settings = self::Settings($Language,"Digte");
			$this->load->model("Load_Heiku");
			$Data = $this->Load_Heiku->Load_Poems_View($Settings["langcode"]);
			$Poems["data"] = self::MakeHTML($Data,$Language,$Settings["langcode"]);
			$Output = array_merge($Poems,$Settings);
			$this->load->view('all_view',$Output);
		}
		else{
			//Creator Search
			if(isset($Get["creator"])){ //Get the data from $_GET["creator"]
				$Settings = self::Settings($Language,"Digte"); //Get all the settings from self::Settings();
				$this->load->model("Load_Heiku"); //Load the Load_Heiku model
				$Data = $this->Load_Heiku->Load_Poems_Creator($Get["creator"],$Settings["langcode"]); //Get All Poems by the specified creator
				$Poems["data"] = self::MakeHTML($Data,$Language,$Settings["langcode"]); //Make it to the right HTML syntax
				$Output = array_merge($Poems,$Settings); //Merge the Settings array and the array containing all the poem data in HTML format
				$this->load->view('all_view',$Output); //Load the view and send the merged array
			}
			
			//Time Search
			if(isset($Get["time"])){
				$Settings = self::Settings($Language,"Digte");
				$this->load->model("Load_Heiku");
				$Data = $this->Load_Heiku->Load_Poems_Time($Get["time"],$Settings["langcode"]);
				$Poems["data"] = self::MakeHTML($Data,$Language,$Settings["langcode"]);
				$Output = array_merge($Poems,$Settings);
				$this->load->view('all_view',$Output);
			}
		}
	}
	
	private function GetData(){
		$Data = array();
		$Gets = array("creator","time","page");
		foreach($Gets as $Get){
			if($this->input->get($Get,TRUE) != ""){
				$Data[$Get] = $this->input->get($Get,TRUE);
			}
		}
		return $Data;
	}
	
	/*
	*MakeHTML loop through all the data Specified in @param Data and make the required HTML 
	* @param
	* @param
	* @param
	* @return
	*/
	private function MakeHTML($Data,$Language,$Lang){
		$HTML = "";
		if(count($Data)>0){
			foreach($Data as $Array){
				$HTML .= '<div id="box">';
				$HTML .= '<div class="text" style="font-family:bonzai; font-size: 250%;">';  
				$HTML .= '<a href="'.$this->config->item('base_url').'output?id='.$Array["Id"].'">'; 
				$HTML .= '<p class="title">'.$Array["Creator"]."</p>";
				$HTML .= $Array["Field1"].'<br>';
				$HTML .= $Array["Field2"].'<br>';
				$HTML .= $Array["Field3"].'<br>';
				$HTML .= '</a>';	
				$HTML .= '</div>';
				$HTML .= '</div>';         
			}
		}
		else{
			$HTML .= '<div id="box">';
			$HTML .= '<div class="text" style="font-family:bonzai; font-size: 250%;">';   
			$HTML .= '<p class="title">'.$Language->Translate("Ingen Digte er tilgængelige",$Lang).'</p>';
			$HTML .= "<br><br><br><br>";	
			$HTML .= '</div>';
			$HTML .= '</div>';         
		}
		return $HTML;
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
		if($Lang == "da-DK"){
			$LangString["Language"] = "Dansk";
			$LangString["Country"] = "Danmark";
		}
		$LangString = $Language->GetLanguage($Lang);
		if(!isset($LangString["Language"])){
			$LangString["Language"] = "Dansk";
			$LangString["Country"] = "Danmark";
			$Lang = "da-DK";
		}
		$Return = $Language->Translate("Tilbage",$Lang);
		$Time = $Language->Translate("Efter Tid",$Lang);
		$All = $Language->Translate("Alle Digte",$Lang);
		$Print = $Language->Translate("Print",$Lang);
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
			'Search' => 'Søg'
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
			'return' => $Return,
			'time' => $Time,
			'creator' => $Creator,
			'print' => $Print,
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
?>