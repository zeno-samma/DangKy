<?php
// if (!defined('IN_ECS')) {
//     die('Hacking attempt');
// }

// Thiet lap ket noi mysql
class connectMySQL {
	
	private $dbhost = 'localhost';
	
	private $dbuser = 'root';	// USER MYSQL
	
	private $dbpass = '1234';	// PASSWORD MYSQL
	
	// Ham connect toi mysql va database
	public function connect($db) {
		
		// Ham ket noi toi mysql
		$conn = mysql_connect($this->dbhost,$this->dbuser,$this->dbpass) or die ('Ket noi toi may chu that bai!');
		
		// Ham chon database
		$db_conn = mysql_select_db($db,$conn) or die ('Khong tim thay CSDL '.$db.' trong he thong!');
				
	}
	
	public function close(){
		global $conn;
		@mysql_close($conn);
	}
}


?>