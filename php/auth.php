<?php
	if( isset($_POST['email']) && isset($_POST['password']) )
	{
		include "../db_conn.php";
		include "form-validator.php";
		$email=$_POST['email'];
		$password=$_POST['password'];

		$text="Email";
		$location="../login.php";
		$ms="error";
		is_empty($email,$text,$location,$ms,"");

		$text="Password";
		$location="../login.php";
		$ms="error";
		is_empty($password,$text,$location,$ms,"");
		$sql="select * from admin where email=?";
		$stmt=$conn->prepare($sql);
		$stmt->execute([$email]);
		if($stmt->rowCount()==1)
			{
				$user=$stmt->fetch();
				$user_id=$user['id'];
				$user_email=$user['email'];
				$user_password=$user['password'];
				if($email === $user_email)
				{
					if(password_verify($password,$user_password))
						{
							if(!isset($_SESSION)){ session_start(); }
							$_SESSION['user_id']=$user_id;
							$_SESSION['user_email']=$user_email;							
							header("Location:../admin.php");
							// header("Location:../login.php?error=successfulLogin");							
						}
					else
						{
						 $em="Incorrect  password";
						 header("Location:../login.php?error=$em");
						}
				}
				else
				{
				$em="Unnecessary check";
				header("Location:../login.php?error=$em");
				}
			}
		else 
			{
				$em="Incorrect username or password";
				header("Location:../login.php?error=$em");
			}
	}
	else
	{
		$em="Something is wrong";
		header("Location:../login.php?error=$em");
	}
?>