<?php
class Sentenceclass{
	private $CI = ''; //An instance of Codde Igniter
	private $Sentences = array(
								'boxTitle' => '',
								'selectTitle' => '',
								'5' => array(),
								'7' => array()
								);
								
	public function SentenceClass(){
		$this->CI =& get_instance(); // Create an instance of CI	
	}
	
	public function SetSelectTitle ($Title) {
		$this->Sentences['selectTitle'] = $Title;	
	}
	
	public function SetBoxTitle ($Title) {
		$this->Sentences['boxTitle'] = $Title;	
	}
	
	public function AddSentence($SentenceNumber, $Sentence){
		$this->Sentences[$SentenceNumber][] = $Sentence;
	}
	
	public function ToJson(){
		return json_encode($this->Sentences);
	}
}
?>