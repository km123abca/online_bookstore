<?php

if(!isset($_SESSION)){ session_start(); }
if(!isset($_GET['id'])){
	header("Location:admin.php");
	exit;
}

if( true  && (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) ))
	{
	 $id=$_GET['id'];
	 include "php/func-books.php";
	 include "php/func-author.php";
	 include "php/func-category.php";
	 include "php/func-generalhelper.php";
	 include "db_conn.php";

	 // $books=get_all_books($conn);
	 $authors=get_all_authors($conn);
	 $categories=get_all_categories($conn);

	 /*
	 if(isset($_GET['title']))	$title_rec=$_GET['title'];
	 else $title_rec='';
	 if(isset($_GET['category'])) $category_rec=$_GET['category'];
	 else $category='';
	 if(isset($_GET['description'])) $description_rec=$_GET['description'];
	 else $description_rec='';
	 if(isset($_GET['author'])) $author_rec=$_GET['author'];
	 else $author_rec='';
	 */

	 $book=get_book($conn,$id);
	if($book==0){
	header("Location:admin.php?error=book_does_not_exist");
	exit;
	}
	else{
		$id_rec=$book['id'];
		$title_rec=$book['title'];
		$description_rec=$book['description'];
		$category_rec=$book['category_id'];
		$author_rec=$book['author_id'];
	}

	 	
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Add Book</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body class='bg-dark text-light'>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="admin.php">Admin</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">Store</a></li>
		        <li class="nav-item"><a class="nav-link active" href="add-book.php">Add Book</a></li>	
		        <li class="nav-item"><a class="nav-link" href="add-category.php">Add Category</a></li>	
		        <li class="nav-item"><a class="nav-link" href="add-author.php">Add Author</a></li>
		        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>		        
		      </ul>		      
		    </div>
		  </div>
		</nav>

		<form  
			  class="shadow rounded p-4 mt-5" 
			  style="width:90%;max-width: 50rem;"
			  method="post"
			  enctype="multipart/form-data"
			  action="./php/update-book.php"			   
			  >
			<h1 class="text-center p-5 display-4 fs-3">
				Edit Book
			</h1>
<?php 
		  	if(isset($_GET['error']))
				{
?>
		  		<div class="alert alert-danger" role="alert">
			  	<?=htmlspecialchars($_GET['error']);?>
			    </div>
<?php 
				} 
				else if(isset($_GET['success']))
				{
?>
		  		<div class="alert alert-success" role="alert">
			  	<?=htmlspecialchars($_GET['success']);?>
			    </div>					
<?php 
				}
?>
			
			<div class="mb-3">
		    <label for="book_title" class="form-label">Book Title</label>
		    <input type="text" class="form-control" id="book_id" aria-describedby="emailHelp" hidden name="book_id" value="<?=$id_rec?>">
		    <input type="text" class="form-control" id="book_title" aria-describedby="emailHelp" name="book_title" value="<?=$title_rec?>">
		    <!-- <div id="emailHelp" class="form-text">So much fun my boy...</div> -->
		    </div>
			<div class="mb-3">
		    <label for="book_author" class="form-label">Author</label>		    
		    <select name="book_author" class="form-control">
		    <option value="0">Select Author</option>
<?php
		   	foreach ($authors as $key => $author) 
		   	{
		   		if($author['id']==$author_rec)
		   		{?>	<option selected value="<?=$author['id']?>"><?=$author['name']?></option> <?php }
		   		else
		   		{ ?> 	<option value="<?=$author['id']?>"><?=$author['name']?></option> <?php }
		   	}
?>
		    	
		    </select>
			<div class="mb-3">
		    <label for="book_category" class="form-label">Book Category</label>
		    <select name="book_category" class="form-control">
		    <option value="0">Select Category</option>
<?php
		   	foreach ($categories as $key => $category) {
		   		if($category['id']==$category_rec)
				{ ?><option selected value="<?=$category['id']?>"><?=$category['name']?></option><?php }
				else
				{ ?><option value="<?=$category['id']?>"><?=$category['name']?></option><?php }
		   	}
?>
		    	
		    </select>		    
		    </div>
			<div class="mb-3">
		    <label for="book_desc" class="form-label">Book Description</label>
		    <input type="text" class="form-control" id="book_desc" aria-describedby="emailHelp" name="book_desc" value="<?= $description_rec?>">		    
		    </div>
			<div class="mb-3">
		    <label for="book_cover" class="form-label">Book Cover</label>
		    <input type="file" class="form-control" id="book_cover" aria-describedby="emailHelp" name="book_cover">		    
		    </div>
		    <input type="file" class="form-control" id="book_covername" hidden value="<?= $book['cover']?>" aria-describedby="emailHelp" name="book_covername">
		    <input type="text" hidden value="<?= $book['cover']?>" name="original_cover"/>
		    <!-- <a href="uploads/cover/<?= $book['cover']?>" class="link-light">Cover File</a> -->
			<div class="mb-3">
		    <label for="book_file" class="form-label">Book File</label>
		    <input type="file" class="form-control" id="book_file" aria-describedby="emailHelp" name="book_file">		    
		    </div>
		    <input type="file" class="form-control" id="book_filename" hidden value="<?= $book['file']?>" aria-describedby="emailHelp" name="book_filename">
		    <input type="text" hidden value="<?= $book['file']?>" name="original_file"/>
		    <!-- <a href="uploads/files/books/<?= $book['file']?>" class="link-light">book File</a> -->
		  <button type="submit" class="btn btn-primary">Update</button>
		</form>		
	</div>
</body>
</html>

<?php 
	}
	else
	{
		$err="You are not authorized to go there";
		header("location:login.php?error=$err");
		exit;
		// echo $_SESSION['user_id'];
	}
?>
