<?php defined("BASEPATH") or exit(); 

class Load extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if(!$this->session->has_userdata("akses") && $this->session->userdata("akses") != "1") redirect();

		$this->load->model("admin/load_model", "l");
	}

	public function pages($page = "home") {
		$this->load->a_template($page);
	}

	private function barang($post) {
		return $this->l->barang($post);
	}

	private function part_barang($post) {
		$post = $this->corelib->escape($post);

		return $this->l->part_barang($post);
	}

	private function grafik_barang() {
		return $this->l->grafik_barang();
	}

	public function touch($func) {
		switch($func) {
			case "barang" :
				echo self::barang($_POST);
				break;
			case "part_barang" :
				echo self::part_barang($_POST);
				break;
			case "grafik-barang" :
				echo self::grafik_barang();
				break;
		}
	}

}

?>