<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Live extends CI_Controller {
	
	public function index(){
		self::GetData("da-DK");
	}
	
	private function GetData($Lang = "da-DK"){
		$this->load->model('Load_Heiku');
		$Data = $this->Load_Heiku->Live_Feed_Poem($Lang);
		self::MakeHTML($Data,$Lang);
	}
	
	private function MakeHTML($Data,$Lang){
		$BaseUrl = $this->config->item('base_url');
		$HTML = "";
		foreach($Data as $Array){
			if($Lang != "da-DK"){
				//Set Read More Link with Language
				$HTML .= '<a href="'.$BaseUrl.'output?id='.$Array["Id"].'&lang='.$Lang.'">';
			}
			else{
				//Set Read More Link
				$HTML .= '<a href="'.$BaseUrl.'output?id='.$Array["Id"].'">';	
			}
			//Set Creator
			$HTML .= "<p>".$Array["Creator"]."</p>";
			//Lines
			$HTML .= $Array["Field1"]."<br>";
			$HTML .= $Array["Field2"]."<br>";
			$HTML .= $Array["Field3"]."<br>";
			//End Link Tag
			$HTML .= "</a>";
		}
		echo $HTML;
	}
	
	public function Language($Lang = "da-DK"){
		self::GetData($Lang);
	}
}
?>