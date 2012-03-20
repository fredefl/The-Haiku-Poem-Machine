<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Save_Heiku extends CI_Model{
	
	//The Constructor
	function __construct()
    {
        parent::__construct(); // Call the Model constructor
    }
	
	//Update Poem
	private function Update_Poem($Array){
		$this->db->update('Haiku_Poem', $Array, array('Id' => $Array["Id"]));
		return $Array["Id"];
	}
	
	//Update Sentence
	private function Update_Sentence($Array){
		$this->db->update('Haiku', $Array, array('Id' => $Array["Id"]));
		return $Array["Id"];
	}
	
	//Save Sentece To DB
	private function Save_Sentence_DB($Array){
		$this->db->insert("Haiku",$Array);
		return $this->db->insert_id();
	}
	
	//Save Sentece To DB
	private function Save_Poem_DB($Array){
		$this->db->insert("Haiku_Poem",$Array);
		return $this->db->insert_id();
	}
	
	//Save Sentence
	private function Save_Sentence($Array){
		$Data = array();
		$Data["Sentence"] = $this->db->escape_str($Array["Sentence"]);
		$Data["Language"] = $this->db->escape_str($Array["Language"]);
		$Data["Creator"] = $this->db->escape_str($Array["Creator"]);
		if(array_key_exists("Length",$Array)){
			$Data["Length"] = $this->db->escape_str($Array["Length"]);
		}
		else{
			$Data["Length"] = $this->db->escape_str(self::Sentence_Calculate_Length($Array["Sentence"]));
		}
		if(array_key_exists("Id",$Array)){
			$Data["Id"] = $this->db->escape_str($Array["Id"]);
			$Id = self::Update_Sentence($Data);
		}
		else{
			$Id = self::Save_Sentence_DB($Data);
		}
		return $Id;
	}
	
	//Save Sentence Array
	public function Save_Sentence_Array($Array){
		$Id = self::Save_Sentence($Array);
		return $Id;
	}
	
	//Sentence Calculate Length
	private function Sentence_Calculate_Length($Sentence){
		$Wovels = array("a","e","i","o","u","y","æ","ø","å");
		$Length = 0;
		foreach($Wovels as $Wovel){
			$Length = substr_count(strtolower($Sentence),$Wovel)+$Length;
		}
		return $Length;
	}
	
	//Save Sentence Variables
	public function Save_Sentence_Variable($Sentence,$Language,$Creator,$Length = NULL,$Id = NULL){
		$Data = array();
		$Data["Sentence"] = $this->db->escape_str($Sentence);
		$Data["Language"] = $this->db->escape_str($Language);
		$Data["Creator"] = $this->db->escape_str($Creator);
		if(!is_null($Length)){
			$Data["Length"] = $this->db->escape_str($Length);
		}
		else{
			$Data["Length"] = $this->db->escape_str(self::Sentence_Calculate_Length($Sentence));
		}
		if(!is_null($Id)){
			$Data["Id"] = $this->db->escape_str($Id);
			$Id = self::Update_Sentence($Data);
		}
		else{
			$Id = self::Save_Sentence_DB($Data);
		}
		return $Id;
	}
	
	//Save Sentence Class
	public function Save_Sentence_Class(&$Sentence){
		$Data = array();
		$Data["Sentence"] = $this->db->escape_str($Sentence->Sentence);
		$Data["Language"] = $this->db->escape_str($Sentence->Language);
		$Data["Creator"] = $this->db->escape_str($Sentence->Creator);
		//If Length is not set, then set it else get the Length
		if(!property_exists($Sentence,"Length")){
			$Data["Length"] = $this->db->escape_str(self::Sentence_Calculate_Length($Sentence->Sentence));
		}
		else{
			$Data["Length"] = $this->db->escape_str($Sentence->Length);	
		}
		//If the property Id is set go to the update method is set.
		if(property_exists($Sentence,"Id")){
			$Data["Id"] = $this->db->escape_str($Sentence->Id);
			$Id = self::Update_Sentence($Data);
		}
		else{
			$Id = self::Save_Sentence_DB($Data);
		}
		return $Id;
	}
	
	//Save Poem
	public function Save_Poem($Array){
		$Data = array();
		$Data["Field1"] = $this->db->escape_str($Array["Field1"]);
		$Data["Field2"] = $this->db->escape_str($Array["Field2"]);
		$Data["Field3"] = $this->db->escape_str($Array["Field3"]);
		$Data["Language"] = $this->db->escape_str($Array["Language"]);
		$Data["Creator"] = $this->db->escape_str($Array["Creator"]);
		$Data["Time"] = time();
		if(array_key_exists("Id",$Array)){
			$Data["Id"] = $this->db->escape_str($Array["Id"]);
			$Id = self::Update_Poem($Data);
		}
		else{
			$Id = self::Save_Poem_DB($Data);
		}	
		return $Id;
	}
	
	//Save Poem Array
	public function Save_Poem_Array($Array){
		$Id = self::Save_Poem($Array);
		return $Id;
	}
	
	//Save Poem Variables
	public function Save_Poem_Variable($Field1,$Field2,$Field3,$Language = NULL,$Creator = NULL,$Id = NULL){
		$Data = array();
		$Data["Field1"] = $this->db->escape_str($Field1);
		$Data["Field2"] = $this->db->escape_str($Field2);
		$Data["Field3"] = $this->db->escape_str($Field3);
		$Data["Time"] = time();
		if(!is_null($Language)){
			$Data["Language"] = $this->db->escape_str($Language); 
		}
		if(!is_null($Creator)){
			$Data["Creator"] = $this->db->escape_str($Creator);
		}
		if(!is_null($Id)){
			$Data["Id"] = $this->db->escape_str($Id);
			$Id = self::Update_Poem($Data);	
		}
		else{
			$Id = self::Save_Poem($Data);
		}
		return $Id;
	}
	
	//Save Poem Class
	public function Save_Poem_Class(&$Poem){
		$Data = array();
		$Data["Field1"] = $this->db->escape_str($Poem->Field1); 
		$Data["Field2"] = $this->db->escape_str($Poem->Field2);
		$Data["Field3"] = $this->db->escape_str($Poem->Field3);
		$Data["Language"] = $this->db->escape_str($Poem->Language);
		$Data["Creator"] = $this->db->escape_str($Poem->Creator);
		$Data["Time"] = time();
		if(property_exists($Poem,"Id")){
			$Data["Id"] = $this->db->escape_str($Poem->Id);
			$Id = self::Update_Poem($Data);
		}
		else{
			$Id = self::Save_Poem($Data);	
		}
		return $Id;
	}
}
?>