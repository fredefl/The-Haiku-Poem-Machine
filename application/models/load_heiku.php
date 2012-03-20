<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Load_Heiku extends CI_Model{
	
	//The Constructor
	function __construct()
    {
        parent::__construct(); // Call the Model constructor
    }
	
	//Load Sentences
	public function Load_Sentences($Language){
		$Data = array();
		$Query = $this->db->get_where("Haiku",array("Language" => $this->db->escape_str($Language)));
		foreach ($Query->result() as $Row)
		{	
			$Data[$Row->Id] = array(
				"Id" => $Row->Id,
				"Language" => $Row->Language,
				"Sentence" => stripslashes($Row->Sentence),
				"Creator" => $Row->Creator,
				"Length" => $Row->Length
			);
		}
		return $Data;
	}
	
	//Load Poems By Creator
	public function Load_Poems_Creator($Creator,$Language){
		$Data = array();
		$Query = $this->db->get_where("Haiku_Poem",array("Creator" => $this->db->escape_str($Creator),"Language" => $this->db->escape_str($Language)));
		foreach($Query->result() as $Row){
			$Data[$Row->Id] = array(
				"Id" => $Row->Id,
				"Field1" => stripslashes($Row->Field1),
				"Field2" => stripslashes($Row->Field2),
				"Field3" => stripslashes($Row->Field3),
				"Time" => $Row->Time,
				"Language" => $Row->Language,
				"Creator" => $Row->Creator
			);
		}
		return $Data;
	}

	//Load Poems By Time
	public function Load_Poems_Time($Time,$Language){
		$Data = array();
		$TimeEval = time() - $this->db->escape_str($Time);
		$this->db->order_by("Time","DESC");
		$Query = $this->db->get_where("Haiku_Poem",array("Time >" => $TimeEval,"Language" => $this->db->escape_str($Language)));
		foreach($Query->result() as $Row){
			$Data[$Row->Id] = array(
				"Id" => $Row->Id,
				"Field1" => stripslashes($Row->Field1),
				"Field2" => stripslashes($Row->Field2),
				"Field3" => stripslashes($Row->Field3),
				"Time" => $Row->Time,
				"Language" => $Row->Language,
				"Creator" => $Row->Creator
			);
		}
		return $Data;
	}
	
	//Load Sentence
	public function Load_Sentence($Id){
		$Data = array();
		$Query = $this->db->get_where("Haiku",array("Id" => $this->db->escape_str($Id)));
		foreach($Query->result() as $Row){
			$Data["Id"] = $Row->Id;
			$Data["Sentence"] = stripslashes($Row->Sentence);
			$Data["Language"] = $Row->Language;
			$Data["Creator"] = $Row->Creator;
			$Data["Length"] = $Row->Length;	
		}
		return $Data;
	}
	
	//Load Sentenes By Length
	public function Load_Sentences_Length($Length){
		$Data = array();
		$Query = $this->db->get_where("Haiku",array("Length" => $this->db->escape_str($Length)));
		foreach($Query->result() as $Row){
			$Data[$Row->Id] = array(
				"Id" => $Row->Id,
				"Sentence" => stripslashes($Row->Sentence),
				"Language" => $Row->Language,
				"Creator" => $Row->Creator,
				"Length" => $Row->Length
			);
		}
		return $Data;
	}
	
	//Load Sentences by Language and Length
	public function Load_Sentences_Language_And_Length($Language,$Length){
		$Data = array();
		$Query = $this->db->get_where("Haiku",array("Language" => $this->db->escape_str($Language),"Length" => $this->db->escape_str($Length)));
		foreach($Query->result() as $Row){
			$Data[$Row->Id] = array(
				"Id" => $Row->Id,
				"Sentence" => stripslashes($Row->Sentence),
				"Language" => $Row->Language,
				"Creator" => $Row->Creator,
				"Length" => $Row->Length
			);
		}
		return $Data;
	}
	
	//Live Feed
	public function Live_Feed_Poem($Lang = NULL,$Time = NULL){
		$Array = array();
		if(is_null($Lang)){
			$Lang = "da-DK";
		}
		if(!is_null($Time)){
			$this->db->limit(3);
			$this->db->order_by("Time","DESC");
			$Query = $this->db->get_where('Haiku_Poem',"Language='$Lang' AND Time>= $Time");

		}
		else{
			$this->db->limit(3);
			$this->db->order_by("Time","DESC");
			$Query = $this->db->get_where('Haiku_Poem',array("Language" => $Lang));
		}
		foreach($Query->result() as $Row){
			$Data["Id"] = $Row->Id;
			$Data["Field1"] = stripslashes($Row->Field1);
			$Data["Field2"] = stripslashes($Row->Field2);
			$Data["Field3"] = stripslashes($Row->Field3);
			$Data["Language"] = $Row->Language;
			$Data["Creator"] = $Row->Creator;
			$Data["Time"] = $Row->Time;
			$Array[$Row->Id] = $Data;
		}
		return $Array;
	}
	
	//Load Poem
	public function Load_Poem($Id){
		$Data = array();
		$Parameters = array("Id" => $this->db->escape_str($Id));
		$Query = $this->db->get_where("Haiku_Poem",$Parameters);
		foreach($Query->result() as $Row){
			$Data["Id"] = $Row->Id;
			$Data["Field1"] = stripslashes($Row->Field1);
			$Data["Field2"] = stripslashes($Row->Field2);
			$Data["Field3"] = stripslashes($Row->Field3);
			$Data["Time"] = $Row->Time;
			$Data["Language"] = $Row->Language;
			$Data["Creator"] = $Row->Creator;
		}
		return $Data;
	}
	
	//Load All Poems By Language
	public function Load_Poems($Language){
		$Data = array();
		$Query = $this->db->get_where("Haiku_Poem",array("Language" => $this->db->escape_str($Language)));
		foreach($Query->result() as $Row){
			$Data[$Row->Id] = array(
				"Id" => $Row->Id,
				"Field1" => stripslashes($Row->Field1),
				"Field2" => stripslashes($Row->Field2),
				"Field3" => stripslashes($Row->Field3),
				"Language" => $Row->Language,
				"Creator" => $Row->Creator,
				"Time" => $Row->Time
			);
		}
		return $Data;
	}
	
	//Load All Poems By Language
	public function Load_Poems_View($Language){
		$Data = array();
		$this->db->order_by("Time","DESC");
		$Query = $this->db->get_where("Haiku_Poem",array("Language" => $this->db->escape_str($Language)));
		foreach($Query->result() as $Row){
			$Data[] = array(
				"Id" => $Row->Id,
				"Field1" => stripslashes($Row->Field1),
				"Field2" => stripslashes($Row->Field2),
				"Field3" => stripslashes($Row->Field3),
				"Language" => $Row->Language,
				"Creator" => $Row->Creator,
				"Time" => $Row->Time
			);
		}
		return $Data;
	}
}
?>