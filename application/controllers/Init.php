<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Init extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model("init_model", "i");
	}

	public function index() {
		$this->load->view("login");
	}

	public function page_not_found() {
		$this->load->view("error-404");
	}

	public function login() {
		$post = $this->corelib->escape($_POST);

		return $this->i->login($post);
	}

	public function logout() {
		session_destroy();
		redirect();
	}
}
