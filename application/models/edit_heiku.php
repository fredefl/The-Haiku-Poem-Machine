<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Edit_Heiku extends CI_Model{
	
	//The Constructor
	function __construct()
    {
        parent::__construct(); // Call the Model constructor
    }
	
	//Save Sentence To DB
	private function Save_Sentence_DB($Array){
		$this->db->update('Haiku', $Array, array('Id' => $Array["Id"]));
	}
	
	//Save Poem To DB
	private function Save_Poem_DB($Array){
		$this->db->update('Haiku_Poem', $Array, array('Id' => $Array["Id"]));
	}
	
	//Insert Sentence To DB
	private function Insert_Sentence_DB($Array){
		$this->db->insert('Haiku',$Array);
	}
	
	//Insert Poem To DB
	private function Insert_Poem_DB($Array){
		$this->db->insert('Haiku_Poem',$Array);
	}
	
	//Edit Poem Array
	public function Edit_Poem_Array($Array){
		self::Edit_Poem($Array);
	}
	
	//Edit Poem Variables
	public function Edit_Poem_Variable($Field1,$Field2,$Field3,$Language = NULL,$Creator = NULL,$Id = NULL){
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
			self::Save_Poem_DB($Data);	
		}
		else{
			self::Insert_Poem_DB($Data);
		}
	}
	
	//Edit Poem Class
	public function Edit_Poem_Class(&$Poem){
		$Data = array();
		$Data["Field1"] = $this->db->escape_str($Poem->Field1); 
		$Data["Field2"] = $this->db->escape_str($Poem->Field2);
		$Data["Field3"] = $this->db->escape_str($Poem->Field3);
		$Data["Time"] = time();
		$Data["Language"] = $this->db->escape_str($Poem->Language);
		$Data["Creator"] = $this->db->escape_str($Poem->Creator);
		if(property_exists($Poem,"Id")){
			$Data["Id"] = $this->db->escape_str($Poem->Id);
			self::Save_Poem_DB($Data);
		}
		else{
			self::Insert_Poem_DB($Data);	
		}
	}
	
	//Edit Sentence Array
	public function Edit_Sentence_Array($Array){
		self::Edit_Sentence($Array);
	}
	
	//Edit Sentence
	public function Edit_Sentence($Array){
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
			self::Save_Sentence_DB($Data);
		}
		else{
			self::Insert_Sentence_DB($Data);
		}
	}
	
	//Edit Poem
	public function Edit_Poem($Array){
		$Data = array();
		$Data["Field1"] = $this->db->escape_str($Array["Field1"]);
		$Data["Field2"] = $this->db->escape_str($Array["Field2"]);
		$Data["Field3"] = $this->db->escape_str($Array["Field3"]);
		$Data["Language"] = $this->db->escape_str($Array["Language"]);
		$Data["Creator"] = $this->db->escape_str($Array["Creator"]);
		$Data["Time"] = time();  
		if(array_key_exists("Id",$Array)){
			$Data["Id"] = $this->db->escape_str($Array["Id"]);
			self::Save_Poem_DB($Data);			
		}
		else{
			self::Insert_Poem_DB($Data);
		}
	}
	
	//Edit Sentence Variable
	public function Edit_Sentence_Variable($Sentence,$Language,$Creator,$Length = NULL,$Id = NULL){
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
		if(is_null($Id)){
			self::Insert_Sentence_DB($Data);
		}
		else{
			$Data["Id"] = $this->db->escape_str($Id);
			self::Save_Sentence_DB($Data);
		}
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
	
	//Edit Sentence Class
	public function Edit_Sentence_Class(&$Sentence){
		$Data = array();
		$Data["Sentence"] = $this->db->escape_str($Sentence->Sentence);
		$Data["Language"] = $this->db->escape_str($Sentence->Language);
		$Data["Creator"] = $this->db->escape_str($Sentence->Creator);
		if(property_exists($Sentence,"Length")){
			$Data["Length"] = $this->db->escape_str($Sentence->Length);
		}
		else{
			$Data["Length"] = $this->db->escape_str(self::Sentence_Calculate_Length($Sentence->Sentence));
		}
		if(!property_exists($Sentence,"Id")){
			self::Insert_Sentence_DB($Data);
		}
		else{
			$Data["Id"] = $this->db->escape_str($Sentence->Id);
			self::Save_Sentence_DB($Data);	
		}
	}
}
?>