<?php
require_once 'config.php';

if(isset($_GET['id'])){

	$id = $_GET['id'];

	$find = "SELECT * FROM tb_user WHERE username='$id'";
	$result = mysqli_query($link, $find);
		if (mysqli_num_rows($result) == 0) {
				header("location:userlist.php?msg=failed");
			}
			else{

	$query = "DELETE FROM tb_user WHERE username='$id'";
		if(mysqli_query($link, $query)){
			header("location:userlist.php?msg=success");
		} else {
		    header("location:userlist.php?msg=failed");
		}

		}
	

	}
	else{
		header("location:userlist.php?msg=notfound");
	}

?>