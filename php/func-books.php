<?php

function get_all_books($con)
	{
		$sql ="SELECT * FROM books ORDER BY id DESC";
		$stmt= $con->prepare($sql);
		$stmt->execute();
		if($stmt->rowCount() > 0)
			{
			$books=$stmt->fetchAll();
			}
		else
			{
				$books=0;
			}
		return $books;

	}

function search_books($con,$key)
	{
		$key="%$key%";
		$sql ="SELECT books.*,author.name AS authorname,categories.name AS categname FROM books,author,categories 
		WHERE books.author_id=author.id  AND books.category_id=categories.id
		AND (title LIKE ? OR description LIKE ? OR author.name LIKE ? OR categories.name LIKE ?)  ORDER BY id DESC";
		$stmt= $con->prepare($sql);
		$stmt->execute([$key,$key,$key,$key]);
		if($stmt->rowCount() > 0)
			{
			$books=$stmt->fetchAll();
			}
		else
			{
				$books=0;
			}
		return $books;

	}

function get_all_booksv2($con)
	{
		
		$sql ="SELECT books.*,author.name AS authorname,categories.name AS categname FROM books,author,categories 
		WHERE books.author_id=author.id  AND books.category_id=categories.id ORDER BY id DESC";
		$stmt= $con->prepare($sql);
		$stmt->execute();
		if($stmt->rowCount() > 0)
			{
			$books=$stmt->fetchAll();
			}
		else
			{
				$books=0;
			}
		return $books;

	}

function get_book($con,$id)
	{
		$sql ="SELECT * FROM books WHERE id=?";
		$stmt= $con->prepare($sql);
		$stmt->execute([$id]);
		if($stmt->rowCount() > 0)
			{
			$book=$stmt->fetch();
			}
		else
			{
				$book=0;
			}
		return $book;

	}