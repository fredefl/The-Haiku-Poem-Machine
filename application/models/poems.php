<?php
class Poems extends CI_Model{

	/**
	 * This function loads up poems using the poem class
	 * @param string $language The language of the poems to load
	 * @param integer $limit    An optional max number of rows to load
	 * @param string $order_by The row to order by
	 * @param string $order    The order to order the row by
	 * @param integer collection The collection database id
	 * @since 1.0
	 * @access public
	 * @return array
	 */
	public function Load ($language,$limit = null, $order_by = null,$order = "asc",$collection = null) {
		$this->load->library("poem");
		$PoemTemplate = new Poem();

		$poems = array();
		if (!is_null($collection)) {
			$this->db->from("poem_collections")->select("poem_id")->where(array("collection_id" => $collection));
			$query = $this->db->get();
			
			if ($query->num_rows() === false || $query->num_rows() == 0) return false;

			foreach ($query->result() as $row) {
				$poems[] = $row->poem_id;
			}
		}

		$this->db->from($PoemTemplate->Database_Table)->select("id")->where(array("language" => $language));

		if (count($poems) > 0) {
			$this->db->where_in("id",$poems);
		}
		if (!is_null($limit)) {
			$this->db->limit($limit);
		}
		if (!is_null($order_by)) {
			$this->db->order_by($order_by,$order);
		}
		$query = $this->db->get();

		$rows = array();
		if ($query->num_rows() === false || $query->num_rows() == 0) return false;
		foreach ($query->result() as $row) {
			$Poem = new Poem();
			$Poem->Load($row->id);
			$rows[] = $Poem;
		}
		return $rows;
	}
}
?>