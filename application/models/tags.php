<?php
class Tags extends CI_Model{

	/**
	 * Returns all the available tags
	 * @since 1.0
	 * @return array|boolean
	 * @param integer $limit The max limit of tags to be returned
	 * @param string $search A search keyword to match
	 * @access public
	 */
	public function Get ($limit = null, $search = null) {
		$this->db->select("tag")->from("tags");

		if (!is_null($limit)) {
			$this->db->limit($limit);
		}

		$this->db->order_by("time_created","desc");

		if (!is_null($search)) {
			$this->db->like("tag",$search);
		}
		
		$query = $this->db->get();

		$tags = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $tag) {
				$tags[] = $tag->tag;
			}

			return $tags;
		} else {
			return false;
		}
	}

	/**
	 * This function returns an array of all the poems,
	 * associated with a tag
	 * @param integer $tag_id The database id of the tag
	 * @param integer $limit  An optional limit of poems to be returned
	 * @return array
	 * @since 1.0
	 * @access public
	 */
	public function GetPoemsByTag ($tag_id, $limit = null) {
		$this->db->select("poem_id")->where(array("tag_id" => $tag_id))->from("poem_tags");
		
		if (!is_null($limit)) {
			$this->db->limit($limit);
		}

		$query = $this->db->get();

		$poems = array();
		$this->load->library("Poem");
		if ($query->num_rows() == 0) return false;

		foreach ($query->result() as $result) {
			$Poem = new Poem();
			if ($Poem->Load($result->poem_id)) {
				$poems[] = $Poem->Export();
			}
		}
		return (count($poems) > 0) ? $poems : false;
	}
}
?>