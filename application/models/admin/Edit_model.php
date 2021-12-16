<?php defined("BASEPATH") or exit();

class Edit_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function barang($post) {
		$post = $this->db->escape_str($post);

		$post['harga'] = preg_replace("/\D/", "", $post['harga']);

		$this->db->where("idbarang", $post['idbarang']);
		if($this->db->update("barang", $post))
			return json_encode(['status' => "ok", "msg" => "Barang telah di edit"]);
		else
			return json_encode(['status' => "error", "msg" => "Terjadi kesalahan saat mengedit"]);
	}

}

?>