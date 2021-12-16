<?php defined("BASEPATH") or exit();

class Corelib {

	private $c = null;

	public function __construct() {
		$this->c =& get_instance();
	}

	public function escape($string = []) {
		$string = $this->c->security->xss_clean($string);

		foreach($string as $key => $val) {
			if(is_array($string[$key])) {
				foreach($string[$key] as $key_arr => $val_arr) {
					$string[$key][$key_arr] = htmlentities($val_arr);
					$string[$key][$key_arr] = strip_tags($val_arr);
					$string[$key][$key_arr] = trim($val_arr);
				}
			}
			else {
				$string[$key] = htmlentities($val);
				$string[$key] = strip_tags($val);
				$string[$key] = trim($val);
			}
		}

		return $string;
	}

	public function rand_text_generator() {
		$string = "ABCDEFG12345";
		$output = "";

		for($i = 0; $i <= 5; $i++) {
			$output .= $string[rand($i, strlen($string) - 1)];
		}
		return $output;
	}

}

?>