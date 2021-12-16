<?php defined("BASEPATH") or exit(); 

class Delete extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model("admin/delete_model",  "d");
	}

	private function barang($post) {
		$post = $this->corelib->escape($post);

		return $this->d->barang($post);
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