<?php defined("BASEPATH") or exit(); 

class Delete_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function barang($post) {
		$post = $this->db->escape_str($post);

		if($this->db->delete("barang", $post))
			return json_encode(['status' => "ok", "msg" => "Barang telah di hapus"]);
		else
			return json_encode(['status' => "error", "msg" => "Terjadi kesalahan saat menghapus"]);
	}

}

?>