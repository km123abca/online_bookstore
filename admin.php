<?php

if(!isset($_SESSION)){ session_start(); }

if( true  && (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) ))
	{
	 include "php/func-books.php";
	 include "php/func-author.php";
	 include "php/func-category.php";
	 include "php/func-generalhelper.php";
	 include "db_conn.php";

	 $books=get_all_books($conn);
	 $authors=get_all_authors($conn);
	 $categories=get_all_categories($conn);
	 // print_r($authors);
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Admin</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body class='bg-dark'>
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
<form  style="width:'100%';max-width: 30rem;" action="search.php" method="get" >
	<div class="input-group mt-5">
	  <input type="text" name="key" class="form-control" placeholder="Search Book..." aria-label="Search Book..." aria-describedby="basic-addon2">
	  <button class="input-group-text btn btn-primary" id="basic-addon2">Search</button>
	</div>
</form>
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


		if($books ==0) { 
		?>
		<div class="alert alert-warning text-center p-5" role="alert">
			  	No books in the database
		</div>	
		<img src="./images/solaire.png" alt="no image"/>
		<?php
		}
		else
		{

		?>	

		<h4 class="mt-5">All Books</h4>
		<table class="table table-dark table-bordered shadow">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Author</th>
					<th class="d-sm-block d-none">Description</th>
					<th>Category</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>	
		<?php	
		$i=0;
		foreach ($books as $book) 
			{
				$i++;
		?>
				<tr>
					<td><?=$i?></td>
					<td> 
						<img src="uploads/cover/<?=$book['cover']?>" width="150" height="150"/>
						<a href="uploads/files/books/<?=$book['file']?>" class="link-light text-decoration-none d-block text-center" target="blank">
						<?=$book['title']?> 
						</a>
					</td>
					<td> <?=get_author_with_id($authors,$book['author_id'])?> </td>
					<td class="d-sm-block d-none"> <?=$book['description']?> </td>
					<td> <?=get_category_with_id($categories,$book['category_id'])?> </td>
					<td>
						<a href="edit-book.php?id=<?= $book['id'] ?>" class="btn btn-warning mr-10">Edit</a>
						<a href="./php/func-deletebook.php?id=<?= $book['id'] ?>" class="btn btn-danger">Delete</a>
					</td>
				</tr>
		<?php
			}
		?>		
				
			</tbody>
		</table>
		<?php
		}
		?>
		<?php
		if($categories==0)
			{
		?>  
			 <div class="alert alert-warning text-center p-5" role="alert">
			  	No Categories found
			</div>
		<?php
			}
		else
			{
		?>
			 <h4 class="mt-5">All categories</h4>
			 <table class="table table-dark table-bordered shadow">
			 	<thead>
			 		<tr>
			 			<th>#</th>
			 			<th>Categories</th>
			 			<th>Action</th>
			 		</tr>
			 	</thead>
			 	<tbody>
		<?php
			$j=0;
					foreach ($categories as $key => $category) 
					{
						$j++;
		?>
						<tr>
			 			<td><?= $j?></td>
			 			<td><?= $category['name']?></td>
			 			<td>
						<a href="edit-category.php?id=<?= $category['id'] ?>" class="btn btn-warning mr-10">Edit</a>
						<a href="php/func-delete-category.php?id=<?= $category['id'] ?>" class="btn btn-danger">Delete</a>
						</td>
			 			</tr>
		<?php
					}
		?>
			 	</tbody>
			 </table> 
		<?php

			}
		if($authors==0)
		{
		?>
			<div class="alert alert-warning text-center p-5" role="alert">
			  	No authors found
			</div>
		<?php
		}
		else
		{
			
		?>
			<h4 class="mt-5">Authors</h4>
			<table class="table table-dark table-bordered shadow">
		 	<thead>
		 		<tr>
		 			<th>#</th>
		 			<th>Authors</th>
		 			<th>Action</th>
		 		</tr>
		 	</thead>
		 	<tbody>
		 <?php
		 	$k=0;
		 	foreach ($authors as $key => $author) 
		 	{
		 		$k+=1;
		 ?>
		 		<tr>
	 			<td><?= $k?></td>
	 			<td><?= $author['name']?></td>
	 			<td>
				<a href="edit-author.php?id=<?= $author['id'] ?>" class="btn btn-warning mr-10">Edit</a>
				<a href="php/func-delete-author.php?id=<?= $author['id'] ?>" class="btn btn-danger">Delete</a>
				</td>
	 			</tr>
	 	<?php
		 	}
		 ?>
		 	</tbody>
		 	</table>
		<?php
			
		}
		?>
		
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
