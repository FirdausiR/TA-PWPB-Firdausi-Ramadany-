<?php defined("BASEPATH") or exit();  

class Insert extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model("admin/insert_model", "i");
	}

	private function barang($post) {
		$post = $this->corelib->escape($post);

		return $this->i->barang($post);
	}

	private function stok($post) {
		$post = $this->corelib->escape($post);

		return $this->i->stok($post);
	}

	public function touch($func) {
		switch($func) {
			case "barang" :
				echo self::barang($_POST);
				break;
			case "stok" :
				echo self::stok($_POST);
				break;
		}
	}

}

?>