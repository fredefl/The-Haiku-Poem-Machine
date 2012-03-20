<?php
class Adddata{

	private $CI = ''; //An instance of Codde Igniter

	public function Adddata(){
		$this->CI =& get_instance(); // Create an instance of CI
	}
	
	//Load Data
	public function SaveData($POST){
		$this->CI->load->model('Addfield');
		$Field1 = $POST["Field1"];
		$Field2 = $POST["Field2"];
		$Field3 = $POST["Field3"];
		$Creator = $POST["Creator"];
		$Lang = $POST["Lang"];
		$this->CI->Addfield->AddToDB(array($this->CI->db->escape_str($Field1),$this->CI->db->escape_str($Field2),$this->CI->db->escape_str($Field3)),$this->CI->db->escape_str($Lang),$this->CI->db->escape_str($Creator));
	}
	
	/*
	//Load Data
	public function SaveData($POST){
		$this->CI->load->model('Addfield');
		$Field1 = $POST["Field1"];
		$Field2 = $POST["Field2"];
		$Field3 = $POST["Field3"];
		$Creator = $POST["Creator"];
		$Lang = $POST["Lang"];
		$this->CI->Addfield->AddToDB(array($this->CI->db->escape_str($Field1),$this->CI->db->escape_str($Field2),$this->CI->db->escape_str($Field3)),$this->CI->db->escape_str($Lang),$this->CI->db->escape_str($Creator));
	}
	*/
	
	
}
?>