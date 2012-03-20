<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Output extends CI_Controller {

	public function index(){
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
		$this->load->library('Lang');
		$Language = new Lang();
		$LangString = $Language->GetLanguage($Lang);
		if(!isset($LangString["Language"])){
			$LangString["Language"] = "Dansk";
			$LangString["Country"] = "Danmark";
			$Lang = "da-DK";
		}
		if($Lang == "da-DK"){
			$LangString["Language"] = "Dansk";
			$LangString["Country"] = "Danmark";
		}
		$Return = $Language->Translate("Tilbage",$Lang);
		$Share = $Language->Translate("Del",$Lang);
		$All = $Language->Translate("Alle Digte",$Lang);
		$Print = $Language->Translate("Print",$Lang);
		$IdDialog = $Language->Translate("Vælg id",$Lang);
		$IdLabel = $Language->Translate("Skriv digtets Id",$Lang);
		if($this->input->get('id',TRUE) != ""){
			#############################Get Data#########################
			$this->load->model("Load_Heiku");
			$Poem = $this->Load_Heiku->Load_Poem($this->input->get('id',TRUE));
			if(isset($Poem["Field1"])){
				$Page_Title = "Haiku - ".$Language->Translate("Digt",$Lang)." - ".$LangString["Language"];
				$Field1 = $Poem["Field1"];
				$Id = $Poem["Id"];
				$Field2 = $Poem["Field2"];
				$Field3 = $Poem["Field3"];
				if(isset($Poem["Creator"])){
					$Creator = $Poem["Creator"];
				}
				else{
					$Creator = "Illution";	
				}
				$Title = $Language->Translate("Digt lavet af ",$Lang)." ".$Creator;
				##############################################################
				$Data = array(
							"Sentence1" => $Field1,
							"Sentence2" => $Field2,
							"Sentence3" => $Field3,
							'Creator' => $Creator,
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
							'title' => $Title,
							'page_title' => $Page_Title,
							'return' => $Return,
							'share' => $Share,
							'print' => $Print,
							'all' => $All,
							'id_dialog' => $IdDialog,
							'id_label' => $IdLabel,
							'search' => $Language->Translate("Søg",$Lang)
				);
				$this->load->view('output_view',$Data);
			}
			else{
				show_error($Language->Translate("Ressurcen var ikke fundet",$Lang));	
			}
		}
		else{
			$Field1 = $this->input->post('sentence1',TRUE);
			$Field2 = $this->input->post('sentence2',TRUE);
			$Field3 = $this->input->post('sentence3',TRUE);
			$Creator = $this->input->post('creator',TRUE);
			if(!isset($Creator)){
				$Creator = "Unknown";
			}
			$Language = $this->input->post('lang',TRUE);
			if($Field1 != "" && $Field2 != "" && $Field3 != ""){
				$PostData = array(
					'Field1' => $Field1,
					'Field2' => $Field2,
					'Field3' => $Field3,
					'Language' => $Language,
					'Creator' => $Creator
				);
				$this->load->model('Save_Heiku');
				$Insert_Id = $this->Save_Heiku->Save_Poem($PostData);	
				$Language = new Lang();
				$Title = $Language->Translate("Digt lavet af ",$Lang)." ".$Creator;
				$Page_Title = "Haiku - ".$Language->Translate("Output",$Lang)." - ".$LangString["Language"];

				redirect($this->config->item('base_url')."output?id=".$Insert_Id);
			}
			else{
				$Language = new Lang();
				$ErrorCode = $Language->Translate("Du mangler at udfylde et felt",$Lang);
				$ErrorCode = trim($ErrorCode);
				show_error($ErrorCode);	
			}
		}
	}

}

?>
	
	