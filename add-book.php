<?php

if(!isset($_SESSION)){ session_start(); }

if( true  && (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) ))
	{
	 // include "php/func-books.php";
	 include "php/func-author.php";
	 include "php/func-category.php";
	 include "php/func-generalhelper.php";
	 include "db_conn.php";

	 // $books=get_all_books($conn);
	 $authors=get_all_authors($conn);
	 $categories=get_all_categories($conn);
	
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
<body>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
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
			  action="./php/process-book.php"			   
			  >
			<h1 class="text-center p-5 display-4 fs-3">
				Add New Book
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
		    <input type="text" class="form-control" id="book_title" aria-describedby="emailHelp" name="book_title">
		    <!-- <div id="emailHelp" class="form-text">So much fun my boy...</div> -->
		    </div>
			<div class="mb-3">
		    <label for="book_author" class="form-label">Author</label>		    
		    <select name="book_author" class="form-control">
		    <option value="0">Select Author</option>
<?php
		   	foreach ($authors as $key => $author) 
		   	{
?>
				<option value="<?=$author['id']?>"><?=$author['name']?></option>
<?php
		   	}
?>
		    	
		    </select>
			<div class="mb-3">
		    <label for="book_category" class="form-label">Book Category</label>
		    <select name="book_category" class="form-control">
		    <option value="0">Select Category</option>
<?php
		   	foreach ($categories as $key => $category) {
?>
				<option value="<?=$category['id']?>"><?=$category['name']?></option>
<?php
		   	}
?>
		    	
		    </select>		    
		    </div>
			<div class="mb-3">
		    <label for="book_desc" class="form-label">Book Description</label>
		    <input type="text" class="form-control" id="book_desc" aria-describedby="emailHelp" name="book_desc">		    
		    </div>
			<div class="mb-3">
		    <label for="book_cover" class="form-label">Book Cover</label>
		    <input type="file" class="form-control" id="book_cover" aria-describedby="emailHelp" name="book_cover">		    
		    </div>
			<div class="mb-3">
		    <label for="book_file" class="form-label">Book File</label>
		    <input type="file" class="form-control" id="book_file" aria-describedby="emailHelp" name="book_file">		    
		    </div>
		  <button type="submit" class="btn btn-primary">Add New Book</button>
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
