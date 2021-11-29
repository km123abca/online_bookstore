<?php

$sName="localhost";
$uName="root";
$pass="sonja";
$db_name="online_book_store_db";
$conn=null;
try{
	$conn=new PDO("mysql:host=$sName;dbname=$db_name",$uName,$pass);
	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	$msg=$e->getMessage();
	header("Location:../login.php?error=$msg");
 echo "Connection failed: ".$e->getMessage();
}
?>