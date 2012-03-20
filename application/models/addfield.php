<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Addfield extends CI_Model{
	
	//The Constructor
	function __construct()
    {
        parent::__construct(); // Call the Model constructor
    }	
	
	public function AddToDB($Array,$Lang,$Creator){
		$Wovels = array("a","e","i","o","u","y","æ","ø","å");
		foreach($Array as $Name){
			$Length = 0;
			foreach($Wovels as $Wovel){
				$Length = substr_count(strtolower($Name),$Wovel)+$Length;
			}
			$data = array(
			   'Sentence' => $Name,
			   'Language' => $Lang,
			   'Creator' => $Creator,
			   'Length' => $Length
			);
			$this->db->insert('Haiku',$data);
		}
	}
	
	/*
		public function AddToDB($Array,$Lang,$Creator){
		$Wovels = array("a","e","i","o","u","y","æ","ø","å");
		foreach($Array as $Name){
			$Length = 0;
			foreach($Wovels as $Wovel){
				$Length = substr_count(strtolower($Name),$Wovel)+$Length;
			}
			$data = array(
			   'Sentence' => $Name,
			   'Language' => $Lang,
			   'Creator' => $Creator,
			   'Length' => $Length
			);
			$this->db->insert('Haiku',$data);
		}
		$data2 = array(
				"Field1" => $Array[0],
				"Field2" => $Array[1],
				"Field3" => $Array[2],
				"Language" => $Lang,
				"Creator" => $Creator,
				"Time" => time()
		);
		
		$this->db->insert('Haiku_Poem',$data2);
	}
	*/	
	
}
?>