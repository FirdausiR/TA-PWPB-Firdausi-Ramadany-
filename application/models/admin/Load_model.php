<?php defined("BASEPATH") or exit(); 

class Load_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function barang($post) {
		$dt = function() use ($post){

			$d = array(
				"table" => "barang",
				"columns" => ['idbarang', 'nama', 'harga', 'stok'],
				"order" => ['idbarang', 'nama', null, null]
			);

			$this->dt->define($d);

			$row = [];
			foreach($this->dt->exec()['data'] as $data) {
				$sub = [];
				$sub[] = $data['idbarang'];
				$sub[] = ucfirst($data['nama']);
				$sub[] = $data['harga'];
				$sub[] = $data['stok'];
				$sub[] = " <a href=\"javascript:void(0)\" class=\"btn btn-danger\" id=\"".$data['idbarang']."\" data-action=\"hapus\">Hapus</a> ";
				$sub[] = " <a href=\"javascript:void(0)\" class=\"btn btn-warning\" id=\"".$data['idbarang']."\" data-action=\"edit\">Edit</a> ";

				$row[] = $sub;
			}

			return json_encode(
				array(
					"draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
					"data" => $row,
					"recordsFiltered" => $this->dt->exec()['recordsFiltered'],
					"recordsTotal" => $this->dt->exec()['recordsTotal']
				)
			);
  		};

  		$select2 = function() use ($post) {
  			$this->db->select("idbarang as id, CONCAT(nama, \" [ \", idbarang, \" ]\") as text");
  			$this->db->from("barang");

  			if(isset($_POST['q'])){
  				$this->db->like("idbarang", $_POST['q']);
  				$this->db->or_like("nama", $_POST['q']);
  			}

  			return json_encode(["items" => $this->db->get()->result(), "pagination" => ["more" => true]]);
  		};

  		return (isset($post['tipe']) && $post['tipe'] == "select2") ? $select2() : $dt(); 
	}

	public function part_barang($post) {
		$post = $this->db->escape_str($post);

		return json_encode($this->db->get_where("barang", $post)->result_array());
	}

	public function grafik_barang() {
		$this->db->select("SUM(masuk) as masuk, SUM(terjual) as terjual, MONTH(updated_at) as updated_at");
		$this->db->from("stok");
		$this->db->group_by("MONTH(updated_at)");

		$q = $this->db->get();

		

		foreach($q->result_array() as $data) {
			$arr[$data['updated_at']] = $data;
		}


		for ($i=1; $i <= 12; $i++) { 
			if(empty($arr[$i])) {
				$arr[$i] = array(
					"terjual" => "0",
					"masuk" => "0",
					"updated_at" => $i
				);
			}
		}

		$return = [];
		for ($i=1; $i <= 12 ; $i++) { 
			$return['terjual'][] = $arr[$i]['terjual'];
			$return['masuk'][] = $arr[$i]['masuk'];
		}

		return json_encode($return);

	}

}

?>