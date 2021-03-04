<?php
class User {
	private $dbHost     = "localhost";
    private $dbUsername = "Admin";
    private $dbPassword = "h2epapprojfinal";
    private $dbName     = "bdhelp2everyone";
    private $userTbl    = 'tblvoluntario';
		/*private $dbHost     = "localhost";
		private $dbUsername = "Admin";
		private $dbPassword = "h2epapprojfinal";
		private $dbName     = "googlelogin";
		private $userTbl    = 'users';*/

	function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
    }

	function checkUser($userData = array()){
		date_default_timezone_set('Europe/Lisbon');
        if(!empty($userData)){
            //Check whether user data already exists in database
            $prevQuery = "SELECT * FROM ".$this->userTbl." WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
            $prevResult = $this->db->query($prevQuery);
            if($prevResult->num_rows > 0){
							$linha=mysqli_fetch_array($prevResult);
								if($linha["oauth_uid"] && $linha["oauth_provider"]){
									//Update user data if already exists
									$query = "UPDATE ".$this->userTbl." SET Nome = '".$userData['first_name']."', Apelido = '".$userData['last_name']."', Email = '".$userData['email']."', modified = '".date("Y-m-d H:i:s")."' WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
									$update = $this->db->query($query);
									echo "sucesso";
									$_SESSION['user']=$linha["Utilizador"];
									header('Location: ./../index.php');
								}else{
									//Update user data if already exists
									$query = "UPDATE ".$this->userTbl." SET Nome = '".$userData['first_name']."', Apelido = '".$userData['last_name']."', Email = '".$userData['email']."', modified = '".date("Y-m-d H:i:s")."' WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
									$update = $this->db->query($query);
								}
            }else{
								$prevQuery2 = "SELECT * FROM ".$this->userTbl." WHERE Email = '".$userData['email']."'";
								$prevResult2 = $this->db->query($prevQuery2);
								$row=mysqli_fetch_array($prevResult2);
								if($row["Utilizador"]){
									//Update user data if already exists
									$query = "UPDATE ".$this->userTbl." SET Nome = '".$userData['first_name']."', Apelido = '".$userData['last_name']."', Email = '".$userData['email']."', modified = '".date("Y-m-d H:i:s")."', oauth_provider = '".$userData['oauth_provider']."', oauth_uid = '".$userData['oauth_uid']."' WHERE Email = '".$userData['email']."'";
									$update = $this->db->query($query);
									echo "Editar";
									$_SESSION['user']=$row["Utilizador"];
									header('Location: ./../index.php');
								}else{
									echo "Inserir";
									header('Location: ./register.php?Nome='.$userData['first_name'].'&Apelido='.$userData['last_name'].'&Email='.$userData['email'].'');
									//Insert user data
	                //$query = "INSERT INTO ".$this->userTbl." SET oauth_provider = '".$userData['oauth_provider']."', oauth_uid = '".$userData['oauth_uid']."', Nome = '".$userData['first_name']."', Apelido = '".$userData['last_name']."', Email = '".$userData['email']."', created = '".date("Y-m-d H:i:s")."', modified = '".date("Y-m-d H:i:s")."'";
	                //$insert = $this->db->query($query);
								}
            }

            //Get user data from the database
            $result = $this->db->query($prevQuery);
            $userData = $result->fetch_assoc();
        }

        //Return user data
        return $userData;
    }
}
?>
