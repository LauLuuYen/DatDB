<?php
    header("Access-Control-Allow-Origin: *");
    
    ini_set("display_errors",1);
    ini_set("display_startup_errors",1);
    error_reporting(E_ALL & ~E_NOTICE);
    include 'include/config.php';
  
  function result($success, $message) {
    $response['success'] = $success;
    $response['message'] = $message;
    echo json_encode($response);
  }
  
class Login
{

	public function __construct($email, $password)
	{
		//echo "Haxxor";
		$this->email = $email;
		$this->password = $password;
		
	}
	
	private function checkInputs()
	{
		return true;
	}
	
	private function authenticate()
	{
	    $this->conn = connectDB();
	    
		$stmt = $this->conn->prepare("SELECT * FROM Users WHERE email = ?");
		$stmt->bindValue(1, $this->email);
		$stmt->execute();		
		$registrants = $stmt->fetchAll();
		
		if(count($registrants) == 0) 
		{
			result(false, "User already exists");
			return;
		}
		
		echo json_encode($registrants);
		
		
	}
	
	
}

$login = new Login('zoolander@mayfair.com', 'abc123');
$login->authenticate();
?>
