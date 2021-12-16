<?php defined("BASEPATH") or exit();

class Edit extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model("admin/edit_model", "e");
	}

	private function barang($post) {
		$post = $this->corelib->escape($post);

		return $this->e->barang($post);
	}

	public function touch($func) {
		switch($func) {
			case "barang" :
				echo self::barang($_POST);
				break;
		}
	}

}

?>