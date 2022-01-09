<?php

function get_author_with_id($authors,$id)
	{
		if($authors==0) return "Unknown";
		foreach ($authors as $key => $author) {
			if($author['id']==$id)
				return $author['name'];
		}
		return "Unknown";
	}

function get_category_with_id($categories,$id)
	{
		if($categories==0) return "Unknown";
		foreach ($categories as $key => $category) {
			if($category['id']==$id)
				return $category['name'];
		}
		return "Unknown";
	}

function store2debug($contentt,$fil="debug.txt")
  {
  // $fil='boxes/'.$fil;
  $file_save=fopen($fil,"a+");
  flock($file_save,LOCK_EX);
  fputs($file_save,$contentt."\n");
  // store2debug('uploading resulted in error');
  flock($file_save,LOCK_UN);
  fclose($file_save);
  }

