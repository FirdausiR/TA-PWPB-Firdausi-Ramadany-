<?php defined("BASEPATH") or exit(); 

class Datatable extends CI_Model {

	private $columns;
	private $table;
	private $order;

	public function __construct() {
		$this->load->database();
	}

	public function define($data = []) {
		$this->table = $data['table'];
		$this->columns = $data['columns'];
		$this->order = $data['order'];
	}

	private function count_all_rows() {
		return $this->db
		->select("*")
		->from($this->table)
		->count_all_results();
	}

	public function exec() {
		$this->db->select("*");
		$this->db->from($this->table);

		if(isset($_POST['search']['value'])) {
			foreach(array_values(array_filter($this->order)) as $search)
				$this->db->like(array_values(array_filter($this->order))[0], $_POST['search']['value']);
		}
			
		$this->db->order_by(array_values(array_filter($this->order))[0] , "ASC");

		if(isset($_POST['length']) > 0)
			$this->db->limit($_POST['length'], $_POST['start']);

		$q = $this->db->get();

		return array(
			"data" => $q->result_array(),
			"recordsTotal" => self::count_all_rows(),
			"recordsFiltered" => $q->num_rows()
		);
	}
}

?>