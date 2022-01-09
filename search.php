<?php
if(!isset($_SESSION)){ session_start(); }
if(!isset($_GET['key']) || empty($_GET['key'])) {
	header("Location:index.php");
	exit;
}
$key=$_GET['key'];
include "php/func-books.php";
include "php/func-author.php";
include "php/func-category.php";
include "php/func-generalhelper.php";
include "db_conn.php";
$books=search_books($conn,$key);
$authors=get_all_authors($conn);
$categories=get_all_categories($conn);
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/styles.css"/>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Store</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body class='bg-dark'>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="index.php">Online Book Store</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Store</a></li>
		        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>	
		        <li class="nav-item"><a class="nav-link" href="#">About</a></li>	
		        <li class="nav-item">
		        	<?php 
		        		if(isset($_SESSION['user_id']))
		        			{
		        	?>
		        			<a class="nav-link" href="admin.php">Admin</a>
		        	<?php
		        			} 
		        		else
		        			{
		        	?>
		        			<a class="nav-link" href="login.php">Login</a>
		        	<?php
		        			}
		        	?>
		        	
		        </li>		        
		      </ul>		      
		    </div>
		  </div>
		</nav>
		<span class="text-light"> Search Results for:<b> <?= $key ?> </b></span>
		<div class='d-flex'>
			<?php if($books==0)
				{
			?>
			<div class="text-center p-5 text-light fw" role="alert">
				There are no books that match your search string
			</div>
			<?php
				 }
				else
				 {
			?>
			<div class='pdf-list d-flex flex-wrap'>
			<?php 
				foreach ($books as $key => $book) {
			?>
				<div class="card m-1">
					<img src="./uploads/cover/<?=$book['cover']?>" class="card-img-top imgrest">
					<div class="card-body bg-dark text-light">
						<h5 class="card-title"> <?=$book['title']?>  </h5>

						<p class="card-text">
							by <i><?=$book['authorname']?></i>
						</p>
						<p class="card-text">
							<?=$book['description']?>
						</p>
						<p class="card-text">
							Category:<i><?=$book['categname']?></i>
						</p>
						<a href="./uploads/files/books/<?=$book['file']?>" class="btn btn-success">Go to Book</a>
						<a href="./uploads/files/books/<?=$book['file']?>" class="btn btn-success" download="<?=$book['title']?>">Download</a>
					</div>
				</div>
			<?php
				}
			?>
			</div>
			<?php
				}
			?>
		</div>
		
	</div>
</body>
</html>