<?php
class Poems extends CI_Model{

	/**
	 * This function loads up poems using the poem class
	 * @param string $language The language of the poems to load
	 * @param integer $limit    An optional max number of rows to load
	 * @param string $order_by The row to order by
	 * @param string $order    The order to order the row by
	 * @since 1.0
	 * @access public
	 * @return array
	 */
	public function Load ($language, $limit = null, $order_by = null,$order = "asc") {
		$this->load->library("poem");
		$PoemTemplate = new Poem();
		$this->db->from($PoemTemplate->Database_Table)->select("id")->where(array("language" => $language));
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