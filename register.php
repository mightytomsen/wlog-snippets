<?php


include('Connection.php');


class Register
{


	private $_error = [
		"emptyerror" => "Bitte fülle alle Felder aus!",
		"mailerror" => "Deine E-mail Adresse ist ungültig!",
		"repwerror" => "Deine Passwörter stimmen nicht überein, bitte überprüfe deine Angaben!",
		"existmailerror" => "Diese E-mail Adresse wird bereits benutzt!",
		"existaccountnameerror" => "Dieser Benutzername ist bereits vergeben!",
		"bothexisterror" => "E-mail und Benutzername ist bereits vergeben!"
	];


	public function __construct()
	{
		session_start();
		if (isset($_SESSION['username'])) {
			header("Location: ./index.php");
			exit;
		}
	}


	public function register($username, $mail, $password, $repassword)
	{
		$connection = Connection::get();


		if (!empty($username) && !empty($mail) && !empty($password) && !empty($repassword)) {
			if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
				$existcheck = $connection->query("SELECT * FROM users WHERE username = '" . $connection->real_escape_string($username) . "' OR mail = '" . $connection->real_escape_string($mail) . "'");
				if ($existcheck->num_rows > 0) {
					$existcheck = $existcheck->fetch_object();




					if ($existcheck->username == $username && $existcheck->mail == $mail) {
						echo $this->_error["bothexisterror"];
					} elseif ($existcheck->mail == $mail) {
						echo $this->_error["existmailerror"];
					} elseif ($existcheck->username == $username) {
						echo $this->_error["existaccountnameerror"];
					}
				} else {
					if ($password == $repassword) {
						$password = md5($password);
						$userimport = $connection->query("INSERT INTO users (username, password, mail) VALUES ('$username', '$password', '$mail')");
						$user_query = $connection->query("SELECT * FROM users WHERE id = '" . $connection->insert_id . "'");
						$user = $user_query->fetch_object();


						$_SESSION['username'] = $user->username;
						$_SESSION['password'] = $user->password;
						header("Location: ./index.php");
						exit;


					} else {
						echo $this->_error["repwerror"];
					}
				}
			} else {
				echo $this->_error["mailerror"];
			}
		} else {
			echo $this->_error["emptyerror"];
		}
	}
}