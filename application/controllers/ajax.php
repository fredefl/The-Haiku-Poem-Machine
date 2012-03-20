<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller {

	public function index()
	{
		self::GetData("da-DK");
	}
	
	private function GetData($Lang = "da-DK"){
		$this->load->model('Load_Heiku');
		$this->load->library('Sentenceclass');
		$SentenceClass = new Sentenceclass();
		$this->load->library('Lang');
		$Language = new Lang();
		//---------------LANGUAGE---------------
		$Data = $this->Load_Heiku->Load_Sentences($Lang);
		$SentenceClass->SetBoxTitle($Language->Translate('Haiku Digtemaskinen',$Lang));
		$SentenceClass->SetSelectTitle($Language->Translate('Stavelser',$Lang));
		//---------------LANGUAGE---------------
		foreach ($Data as $Id => $Value) {
			$Sentence = trim($Value['Sentence']);
			$Length = $Value['Length'];	
			$SentenceClass->AddSentence($Length,$Sentence);
		}
		header('Content-type: application/json');
		echo $SentenceClass->ToJson();
	}
	
	public function Language($Lang = "da-DK"){
		self::GetData($Lang);
	}
}
?>