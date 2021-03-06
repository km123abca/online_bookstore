<?php

if(!isset($_SESSION)){ session_start(); }
if(!isset($_GET['id'])){
	header("Location:admin.php");
	exit;
}

if( true  && (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) ))
	{
	$id=$_GET['id'];
	include "db_conn.php";
	include "php/func-category.php";
	include "php/func-generalhelper.php";
	$category=get_category($conn,$id);
	if($category==0){
	header("Location:admin.php?error=category_does_not_exist");
	exit;
	}

	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Edit Category</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body class="bg-dark">
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
		        <li class="nav-item"><a class="nav-link" href="add-book.php">Add Book</a></li>	
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
			  action="./php/update-category.php"			   
			  >
			<h1 class="text-center p-5 display-4 fs-3">
				Edit Category
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
		    <label for="author" class="form-label">Category</label>
		    <input type="text" class="form-control" hidden id="category" aria-describedby="emailHelp" name="id" value="<?= $category['id'] ?>">
		    <input type="text" class="form-control" id="category" aria-describedby="emailHelp" name="category" value="<?= $category['name'] ?>">
		    <div id="emailHelp" class="form-text">So much fun my boy...</div>
		  </div>
		  <button type="submit" class="btn btn-primary">Update Category</button>
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
