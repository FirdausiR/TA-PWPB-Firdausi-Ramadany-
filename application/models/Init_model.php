<?php defined("BASEPATH") or exit(); 

class Init_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function login($post) {
		$post['password'] = sha1($post['password']);
		$post = $this->db->escape_str($post);

		$q = $this->db->get_where("user", $post);


		if($q->num_rows() > 0) {
			foreach($q->result_array() as $data) {
				$this->session->set_userdata("id", $data['username']);
				$this->session->set_userdata("akses", $data['akses']);

				redirect("admin/p/home");
			}
		}
		else {
			$this->session->set_userdata("msg", "<div class='alert alert-danger'>Kombinasi username / password tidak benar !</div>");
			redirect();
		}
	}

}

?>