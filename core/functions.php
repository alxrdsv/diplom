<?php
class functions {
	
	public $conn;

	function __construct() {
		$this->conn = $db_connect = mysqli_connect('localhost', 'root', '123', 'bd') or die(mysqli_error());
	}

	function parseUri() {
		$uri = $_SERVER['REQUEST_URI'];
		$uri = explode('/', $uri);
		if (strstr($uri[2], '?')) {
			$uri = explode('?', $uri[2]);
			$uri = $uri[0];
		} else {
			$uri = $uri[2];
		}
		return $uri;
	}

	function pageInclude() {
		
		$segment = $this->parseUri();
		$instance = new self();
						
		$segment = (!isset($_SESSION['user_in'])) ? 'auth' : ((empty($segment) && isset($_SESSION['user_in'])) ? 'map' : $segment);

		if ($segment != 'auth') {
			require_once($_SERVER['DOCUMENT_ROOT'].'/diplom/tpl/header.php');
		}
		
		if (file_exists($_SERVER['DOCUMENT_ROOT'].'/diplom/pages/'.$segment.'.php')) {
			require_once($_SERVER['DOCUMENT_ROOT'].'/diplom/pages/'.$segment.'.php');
		} else {
			//require_once($_SERVER['DOCUMENT_ROOT'].'/diplom/pages/404.php');
		}
		
		if ($segment != 'auth') {
			require_once($_SERVER['DOCUMENT_ROOT'].'/diplom/tpl/footer.php');
		}
		
	}

	function redirect($to) {
		header("Location: /" . ltrim($to, '/'));
		exit;
	}

}

$instance = new functions;
	
?>





