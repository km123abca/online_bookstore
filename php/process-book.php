<?php
if(!isset($_SESSION)){ session_start(); }
if( true  && (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) ))
{

 include "../db_conn.php";
 include "form-validator.php";
 include "func-file-upload.php";
 if(isset($_POST['book_title']) && 
 	isset($_POST['book_author']) && 
 	isset($_POST['book_category']) && 
 	isset($_POST['book_desc'])  && 
 	isset($_FILES['book_cover']) && 
 	isset($_FILES['book_file'])
 		 
   )
 	{
 		$book_title=$_POST['book_title'];
 		$book_author=$_POST['book_author'];
 		$book_category=$_POST['book_category'];
 		$book_desc=$_POST['book_desc'];
 		$book_cover=$_FILES['book_cover'];
 		$book_file=$_FILES['book_file'];
 		is_empty($book_title,"book title",'../add-book.php',"error",'');
 		is_empty($book_author,"book author",'../add-book.php',"error",'');
 		is_empty($book_category,"book category",'../add-book.php',"error",'');
 		is_empty($book_desc,"book description",'../add-book.php',"error",'');

 		$allowed_exs=array("jpg","jpeg","png");
 		$path="cover";
 		$book_cover=upload_file($_FILES['book_cover'],$allowed_exs,$path)

 		if($book_cover['status']=="error")
 			{
 				$em=$book_cover['data'];
 				header('Location:../add-book.php?error=$em');
 			}
 		else
 			{
 				
 			}

 		
 	
 			
 	}
 else
 	{
 		header('Location:../add-book.php?error=somethingmissing');
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
