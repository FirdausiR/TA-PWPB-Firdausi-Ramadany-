<?php defined("BASEPATH") or exit(); 

class Insert_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function barang($post) {
		$post['idbarang'] = $this->corelib->rand_text_generator();
		$post['harga'] = preg_replace("/\D/", "", $post['harga']);

		$post = $this->db->escape_str($post);

		if($this->db->insert("barang", $post))
			return json_encode(["status" => "ok", "msg" => "Barang telah di tambahkan"]);
		else
			return json_encode(["status" => "error", "msg" => "Terjadi kesalahan saat menambah barang"]);
	}

	public function stok($post) {
		$post = $this->db->escape_str($post);

		for ($i=0; $i < count($post['idbarang']); $i++) { 
			$data = array(
				"idbarang" => $post['idbarang'][$i],
				"masuk" => $post['masuk'][$i],
				"terjual" => "0",
				"updated_at" => date("Y-m-d")
   			);

   			$this->db->insert("stok", $data);
		}

		return json_encode(['msg' => "stok barang telah di tambah"]);
	}

}

?>