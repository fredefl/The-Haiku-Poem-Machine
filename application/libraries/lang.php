<?php
class Lang{

	private $CI = ''; //An instance of Codde Igniter

	public function Lang(){
		$this->CI =& get_instance(); // Create an instance of CI
	}
	
	public function Translate($Input,$Language){
		$Output = "";
		$Query = $this->CI->db->get_where("Haiku_Translation",array("da-DK" => $Input));
		foreach ($Query->result_array() as $Row)
		{
			if(isset($Row[$Language])){
				$Output = $Row[$Language];
			}
			else{
				$Output = $Input;
			}
		}
		return $Output;
	}
	
	/*
	*A function to create a Language Box
	* @param {String} Language    An instance of the Lang library
	* @return {Html} LangData   Returns the language box options in html
	*/
	private function LanguageBox($Language){
		$Lang = array();
		$LangData = "";
		$Lang = $Language->CountrySelection();
		$LangData = '<select name="Language" id="Language">';
		foreach($Lang as $Code => $Language){
			if($Code == "da-DK"){
				$LangData .= '<option value="'.$Code.'" selected>'.$Language.'</option>';
			}
			else{
				$LangData .= '<option value="'.$Code.'">'.$Language.'</option>';
			}
		}
		$LangData = '</select>';
		return $LangData;
	}
	
	public function GetLanguage($Code){
		$SupportedLanguages = $this->CI->config->item('supported_languages');
		if($Code != "da-DK"){
			if(!array_key_exists($Code,$SupportedLanguages)){
				$LCode = "en-GB";
			}
		}
		$Data = array();
		$Query = $this->CI->db->get_where("Languages",array("Code" => $this->CI->db->escape_str($Code)));
		foreach ($Query->result() as $Row)
		{	
			$Data["Country"] = $Row->Country;
			$Data["Language"] = $Row->Language;
		}
		return $Data;
	}
	
	public function ListLanguages(){
		$Lang = array();
		$Query = $this->CI->db->get("Languages");
		foreach ($Query->result() as $Row)
		{
			if(!isset($Lang[$Row->Code])){
				$Lang[$Row->Code] = array("Code" => $Row->Code,"Language" => $Row->Language,"Country" => $Row->Country);	
			}
		}
	}
	
	public function LanguageSelection(){
		$Lang = array();
		$Query = $this->CI->db->get("Languages");
		foreach ($Query->result() as $Row)
		{
			if(!isset($Lang[$Row->Code])){
				$Lang[$Row->Code] = $Row->Language;	
			}
		}
		return $Lang;
	}
	
	public function CountrySelection(){
		$Lang = array();
		$Query = $this->CI->db->get("Languages");
		foreach ($Query->result() as $Row)
		{
			if(!isset($Lang[$Row->Code])){
				$Lang[$Row->Code] = $Row->Country;	
			}
		}
		return $Lang;
	}
}
?>