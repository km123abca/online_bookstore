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
 				$sql2="SELECT * FROM books WHERE author_id=?";
 				// store2debug("SELECT * FROM books WHERE author_id=".$id);
 				$stmt2=$conn->prepare($sql2);
 				$stmt2->execute([$id]);

 				if($stmt2->rowCount() > 0)
 					{
					$books=$stmt2->fetchAll(); 						
					$em="The books ";
					foreach ($books as $key => $book) 
						{
						$em=$em.$book['title'].", ";
						$em=substr($em, 0,strlen($em)-2)." uses this author, first delete those titles or change author in those";
						header("Location:../admin.php?error=$em");
		 				exit;
						}
 					}
 				else
 					{
 						/*
 					$sm="hurray, can be deleted";
					header("Location:../admin.php?success=$sm");
					exit;*/
	 				$sql="DELETE FROM author WHERE id=?";
					$stmt=$conn->prepare($sql);
					$res=$stmt->execute([$id]); 						
					if($res)
	 					{		 					
		  				$sm="Author successfully deleted";
		 				header("Location:../admin.php?success=$sm&id=$id");
		 				exit;
	 					}
 					else
	 					{
		  				$em="Error while accessing db";
		 				header("Location:../admin.php?error=$em&id=$id");
		 				exit;
	 					}
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
