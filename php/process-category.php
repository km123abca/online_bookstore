<?php
if(!isset($_SESSION)){ session_start(); }
if( true  && (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) ))
{

 include "../db_conn.php";
 if(isset($_POST['category']))
 	{
 		$name=$_POST['category'];
 		if(empty($name))
 			{
 				$em="The category name is required";
 				header("Location:../add-category.php?error=$em");
 				exit;
 			}
 		else
 			{
 				$sql="INSERT INTO categories (name) VALUES (?)";
 				$stmt=$conn->prepare($sql);
 				$res=$stmt->execute([$name]);	
 				if($res)
 					{
	  				$sm="Category successfully created";
	 				header("Location:../add-category.php?success=$sm");
	 				exit;
 					}
 				else
 					{
	  				$em="Error while accessing db";
	 				header("Location:../add-category.php?error=$em");
	 				exit;
 					}
 			}
 	}
 else
 	{
 		header('Location:../admin.php');
 		exit;
 	}

}
else
{
	$err="Attack attempted";
	header("location:login.php?error=$err");
	exit;
	// echo $_SESSION['user_id'];
}
?>
