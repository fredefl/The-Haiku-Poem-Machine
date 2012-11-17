<?php
class Collections extends CI_Model{

	/**
	 * This function queries all the collections that are available for the users language
	 * @param string  $language The users language
	 * @param integer  $limit    An optional limit of collections
	 * @param integer $offset   An optional pageinate offset
	 * @param string  $order_by An optional row to sort by
	 * @param string  $order    The sort order "asc" or "desc"
	 * @param array $fields The collection fields to load
	 * @since 1.0
	 * @access public
	 * @return array
	 */
	public function Find ($language = null,$limit = null,$offset = 0,$order_by = "time_created",$order = "desc",$fields = array("identifier","creator","name","description","time_created")) {
		$this->load->library("collection");
		$collectionIds = array();
		$query = $this->db->from("collection_languages")->where(array("language" => $language))->select("collection_id")->get();
		if ($query->num_rows() == 0 || $query->num_rows() === false) return false;

		foreach ($query->result() as $row) {
		 	$collectionIds[] = $row->collection_id;
		}

		 $this->db->from("collections")->where_in("id",$collectionIds)->select("id");

		if (!is_null($limit)) {
			$this->db->limit($limit,$offset);
		}
		if (!is_null($order_by)) {
			$this->db->order_by($order_by,$order);
		}

		$query = $this->db->get();

		if ($query->num_rows() == 0 || $query->num_rows() === false) return false;

		$collections = array();

		foreach ($query->result() as $row) {
		 	$Collection = new Collection();
		 	$Collection->Load($row->id,false,$fields);
		 	$collections[] = $Collection;
		}
		return $collections;
	}
}
?>