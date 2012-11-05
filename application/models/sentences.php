<?php
class Sentences extends CI_Model{

	/**
	 * This function loads sentences by language
	 * @since 1.0
	 * @access public
	 * @param string $language The language to search for
	 * @param integer $limit    An optional number of rows to select
	 */
	public function Load ($language,$limit = null) {
		$this->load->library("sentence");
		$SentenceTemplate = new Sentence();
		if (!is_null($limit)) {
			$this->db->limit($limit);
		}
		$query = $this->db->from($SentenceTemplate->Database_Table)->select("id")->where(array("language" => $language))->get();
		$rows = array();
		if ($query->num_rows() === false || $query->num_rows() == 0) return false;
		foreach ($query->result() as $row) {
			$Sentence = new Sentence();
			$Sentence->Load($row->id);
			$rows[] = $Sentence;
		}
		return $rows;
	}
}
?>