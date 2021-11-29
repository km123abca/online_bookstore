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