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
 		$user_input="title=".$book_title."&category=".$book_category."&description=".$book_desc."&author=".$book_author;
 		is_empty($book_title,"book title",'../add-book.php',"error",$user_input);
 		is_empty($book_author,"book author",'../add-book.php',"error",$user_input);
 		is_empty($book_category,"book category",'../add-book.php',"error",$user_input);
 		is_empty($book_desc,"book description",'../add-book.php',"error",$user_input);

 		$allowed_exs=array("jpg","jpeg","png");
 		$path="cover/";
 		$book_cover=upload_file($_FILES['book_cover'],$allowed_exs,$path);

 		if($book_cover['status']=="error")
 			{
 				$em=$book_cover['data'];
 				$stat=$book_cover['status'];
 				header('Location:../add-book.php?error='.$em."&".$user_input);
 				exit;
 			}
 		else
 			{
 				$allowed_exs=array("pdf","docx","txt");
 				$path="files/books/";
 				$file=upload_file($book_file,$allowed_exs,$path); 		
 				if($file['status']=='error')
 					{
 						$em=$file['data'];
 						header('Location:../add-book.php?error='.$em."&".$user_input);
 						exit;
 					}
 				else
 					{
 						$file_URL=$file['data'];
 						$book_cover_URL=$book_cover['data'];
 						try{
 						$sql="INSERT INTO books(title,author_id,description,category_id,cover,file)  VALUES (?,?,?,?,?,?)";
 						$stmt=$conn->prepare($sql);
 						$res=$stmt->execute([$book_title,$book_author,$book_desc,$book_category,$book_cover_URL,$file_URL]);
 						}
 						catch(Exception $e)
 							{
 							$em=$e->getMessage();
 							header("Location:../add-book.php?error=$em");
 							exit;
 							}
 						if($res)
 							{
 								$sm="book successfully uploaded";
 								header("Location:../add-book.php?success=$sm");
 								exit;
 							}
		  				else
		 					{
			  				$em="Error while accessing db";
			 				header("Location:../add-book.php?error=$em");
			 				exit;
		 					}
 					}		
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
