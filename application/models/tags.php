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
}
?>