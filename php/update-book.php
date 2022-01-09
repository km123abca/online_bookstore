<?php
include "func-generalhelper.php";
include "form-validator.php";
 include "func-file-upload.php";
if(!isset($_SESSION)){ session_start(); }
if( true  && (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) ))
{

 include "../db_conn.php";
 if(isset($_POST['book_id']))
 	{
 		$bookName=$_POST['book_title']; 		
 		$id=$_POST['book_id'];
 		$author=$_POST['book_author'];
 		$category=$_POST['book_category'];
 		$desc=$_POST['book_desc'];
 		$cover=$_POST['book_covername'];
 		$file=$_POST['book_filename'];
 		$book_cover=$_FILES['book_cover'];
 		$book_file=$_FILES['book_file'];
 		$original_cover=$_POST['original_cover'];
 		$original_file=$_POST['original_file'];
 		$cover_to_be_uploaded=false;
 		$file_to_be_uploaded=false;
 		$cover_to_upload='unknown';
 		$file_to_upload='unknown';
 		
 		
 		$user_input="id=".$id;
 		$category=$category==0?'':$category;
 		$author=$author==0?'':$author;
 		// is_empty($book_file,"book file",'../edit-book.php',"error",$user_input);
 		if(!empty($book_cover['name']))
 			{
 			$cover_to_be_uploaded=true;
 			$cover_to_upload= upload_file_higher($book_cover,array("jpg","jpeg","png"),"cover/",'Location:../edit-book.php');
 			}
 		else if(!empty($book_file['name']))
 			{
 			$file_to_be_uploaded=true;
 			$file_to_upload= upload_file_higher($book_file,array("pdf","docx","txt"),"files/books/",'Location:../edit-book.php');
 			}

 		

 		is_empty($bookName,"book title",'../edit-book.php',"error",$user_input);
 		is_empty($author,"book author",'../edit-book.php',"error",$user_input);
 		is_empty($category,"book category",'../edit-book.php',"error",$user_input);
 		is_empty($desc,"book description",'../edit-book.php',"error",$user_input);

 		
 				
	    if($cover_to_be_uploaded && $file_to_be_uploaded){		
			$sql="UPDATE books SET title=?,description=?,category_id=?,cover=?,file=?,author_id=? WHERE id=?";
			$stmt=$conn->prepare($sql);
			$res=$stmt->execute([$bookName,$desc,$category,$cover_to_upload,$file_to_upload,$author,$id]);	
		}
	    else if($cover_to_be_uploaded){		
			$sql="UPDATE books SET title=?,description=?,category_id=?,cover=?,author_id=? WHERE id=?";
			$stmt=$conn->prepare($sql);
			$res=$stmt->execute([$bookName,$desc,$category,$cover_to_upload,$author,$id]);	
		}
	    else if($file_to_be_uploaded){		
			$sql="UPDATE books SET title=?,description=?,category_id=?,file=?,author_id=? WHERE id=?";
			$stmt=$conn->prepare($sql);
			$res=$stmt->execute([$bookName,$desc,$category,$file_to_upload,$author,$id]);	
		}
	    else{		
			$sql="UPDATE books SET title=?,description=?,category_id=?,author_id=? WHERE id=?";
			$stmt=$conn->prepare($sql);
			$res=$stmt->execute([$bookName,$desc,$category,$author,$id]);	
		}
		if($res)
			{
			
			if($cover_to_be_uploaded) {
				store2debug("../uploads/cover/".$original_cover." will be unlinked");
				unlink("../uploads/cover/".$original_cover);
			}
			if($file_to_be_uploaded)  {
				store2debug("../uploads/files/books/".$original_file." will be unlinked");
				unlink("../uploads/files/books/".$original_file);
			}

			$sm="book successfully updated";
			header("Location:../edit-book.php?success=$sm&id=$id");
			exit;
			}
		else
			{
			$em="Error while accessing db";
			header("Location:../edit-book.php?error=$em&id=$id");
			exit;
			}
 			
 	}
 else
 	{
 		store2debug("book id was not present");
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
