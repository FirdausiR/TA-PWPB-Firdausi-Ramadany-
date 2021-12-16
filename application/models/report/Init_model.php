<?php defined("BASEPATH") or exit(); 

class Init_model extends CI_Model {
	public function __construct() {
		$this->load->database();
	}

	public function get_table($data = []) {

		return $this->db
		->select(isset($data['select']) ? $data['select'] : "*")
		->from($data['table'])
		->get()
		->result_array();
	}
}

?>