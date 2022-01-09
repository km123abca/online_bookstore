<?php
include "func-generalhelper.php";
if(!isset($_SESSION)){ session_start(); }
if( true  && (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) ))
{

 include "../db_conn.php";
 if(isset($_GET['id']))
 	{
 		$id=$_GET['id'];
 		
 		if(empty($id))
 			{
 				$em="id was not present among the GET parameters";
 				header("Location:../admin.php?error=$em");
 				exit;
 			}
 		else
 			{ 	
 				$sql2="SELECT * FROM books WHERE id=?";
 				$stmt2=$conn->prepare($sql2);
 				$stmt2->execute([$id]);

 				if($stmt2->rowCount() > 0)
 					{
 						$the_book=$stmt2->fetch();
 						$cover=$the_book['cover'];
 						$file=$the_book['file'];

 						$sql="DELETE FROM books WHERE id=?";
 						$stmt=$conn->prepare($sql);
 						$res=$stmt->execute([$id]);	

 						
 						if($res)
		 					{
		 					unlink("../uploads/files/books/".$file);
		 					unlink("../uploads/cover/".$cover);
			  				$sm="Book successfully deleted";
			 				header("Location:../admin.php?success=$sm&id=$id");
			 				exit;
		 					}
		 				else
		 					{
			  				$em="Error while accessing db";
			 				header("Location:../edit-author.php?error=$em&id=$id");
			 				exit;
		 					}
 						

 					}
 				else
 					{
	 				$em="Book to delete not found in the database";
	 				header("Location:../admin.php?error=$em");
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
