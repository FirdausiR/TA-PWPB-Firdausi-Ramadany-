<?php defined("BASEPATH") or exit(); 

require APPPATH."/third_party/mpdf/vendor/autoload.php";

class Init extends CI_Controller {

	private $pdf;

	public function __construct() {
		parent::__construct();
		$this->load->model("report/init_model", "i");
		
		$this->pdf = new Mpdf\Mpdf();
	}

	public function export($data) {
		switch($data) {
			case "barang" :
				return self::barang();
				break;
		}
	}

	private function barang() {
		$table = $this->i->get_table(['table' => "v_barang"]);
		
		$css = file_get_contents("./dist/css/bootstrap.min.css");

		$output = "";
		$output .= "<table align=\"center\" width=\"100%\" class=\"text-center table table-bordered\">";
		
		$output .= "<thead>";
		$output .= "<tr>";
		$output .= "<th class=\"text-center\">ID Barang</th>";
		$output .= "<th class=\"text-center\">Nama</th>";
		$output .= "<th class=\"text-center\">Stok</th>";
		$output .= "<th class=\"text-center\">Harga (Rp)</th>";
		$output .= "<th class=\"text-center\">Diskon (%)</th>";
		$output .= "<th class=\"text-center\">Pajak (%)</th>";
		$output .= "<th class=\"text-center\">Terjual</th>";
		$output .= "<th class=\"text-center\">Total semua</th>";
		$output .= "<th class=\"text-center\">Terkahir di update</th>";
		$output .= "</tr>";
		$output .= "</thead>";

		$output .= "<tbody>";
			foreach($table as $t):
			$output .= "<tr>";
			$output .= "<td>".$t['idbarang']."</td>";
			$output .= "<td>".$t['nama']."</td>";
			$output .= "<td>".$t['stok']."</td>";
			$output .= "<td>".$t['harga']."</td>";
			$output .= "<td>".$t['diskon']."</td>";
			$output .= "<td>".$t['pajak']."</td>";
			$output .= "<td>".$t['terjual']."</td>";
			$output .= "<td>".$t['total']."</td>";
			$output .= "<td>".date("d-m-Y", strtotime($t['last_modified']))."</td>";
			$output .= "</tr>";
			endforeach;
		$output .= "</tbody>";
		
		$output .= "</table>";

		$this->pdf->addPage("L");
		$this->pdf->WriteHtml($css, 1);
		$this->pdf->WriteHtml($output, 2);
		$this->pdf->Output();
		exit();
	}

}

?>