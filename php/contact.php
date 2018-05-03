<?php
	$array = array("firstname" => "", "name" => "", "email" => "", "phone" => "", "message" => "", "firstnameError" => "", "nameError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => false);

	$emailTo = "jcharles.b@icloud.com";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$array["firstname"] = verifyInput($_POST["firstname"]);
		$array["name"] = verifyInput($_POST["name"]);
		$array["email"] = verifyInput($_POST["email"]);
		$array["phone"] = verifyInput($_POST["phone"]);
		$array["message"] = verifyInput($_POST["message"]);
		$array["isSuccess"] = true;
		$emailText = "";
		
		if (empty($array["firstname"])){
			$array["firstnameError"] = "Veuillez insérer votre prénom…";
			$array["isSuccess"] = false;
		} else $emailText .= "Prénom: {$array['firstname']}\n";
		
		if (empty($array["name"])){
			$array["nameError"] = "Veuillez insérer votre nom…";
			$array["isSuccess"] = false;
		} else $emailText .= "Nom: {$array['name']}\n";		
		
		if (!isEmail($array["email"])){
			$array["emailError"] = "Veuillez insérer un email valide…";
			$array["isSuccess"] = false;
		} else $emailText .= "Email: {$array['email']}\n\n";
		
		if (!isPhone($array["phone"])){
			$array["phoneError"] = "Veuillez n'insérer que des chiffres et des espaces…";
			$array["isSuccess"] = false;
		} else $emailText .= "Téléphone: {$array['phone']}\n\n";
		
		if (empty($array["message"])){
			$array["messageError"] = "Veuillez insérer votre message…";
			$array["isSuccess"] = false;
		} else $emailText .= "Message: {$array['message']}\n\n";

		if ($array["isSuccess"]) {
			$headers = "From: {$array['firstname']} {$array['name']} <{$array['email']}>\nReply-To: {$array['email']}";
			mail($emailTo, "Une personne vous a contacté via votre site.", $emailText, $headers);
		}
		
		echo json_encode($array);
	}
	
	function isEmail($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
	function isPhone($phone){
		return preg_match("/^[0-9 ]*$/", $phone);
	}
	
	function verifyInput($data) {
		$var = trim($data);
		$var = stripslashes($data);
		$var = htmlspecialchars($data);
		return $data;
	}
?>
