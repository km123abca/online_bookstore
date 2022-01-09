<?php
include "func-generalhelper.php";
if(!isset($_SESSION)){ session_start(); }
if( true  && (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) ))
{

 include "../db_conn.php";
 if(isset($_POST['id']))
 	{
 		$name=$_POST['category'];
 		$id=$_POST['id'];
 		if(empty($name) || empty($id))
 			{
 				$em="The category name is required";
 				header("Location:../edit-category.php?error=$em");
 				exit;
 			}
 		else
 			{ 				
 				$sql="UPDATE categories SET name=? WHERE id=?";
 				$stmt=$conn->prepare($sql);
 				$res=$stmt->execute([$name,$id]);	
 				if($res)
 					{

	  				$sm="Category successfully updated";
	 				header("Location:../edit-category.php?success=$sm&id=$id");
	 				exit;
 					}
 				else
 					{
	  				$em="Error while accessing db";
	 				header("Location:../edit-category.php?error=$em&id=$id");
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
