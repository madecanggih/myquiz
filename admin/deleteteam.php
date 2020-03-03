<?php
require_once 'config.php';

if(isset($_GET['id'])){

	$id = $_GET['id'];

	$find = "SELECT * FROM tb_team WHERE id_team='$id'";
	$result = mysqli_query($link, $find);
		if (mysqli_num_rows($result) == 0) {
				header("location:addteam.php?msg=failed");
			}
			else{

	$query = "DELETE FROM tb_team WHERE id_team='$id'";
		if(mysqli_query($link, $query)){
			header("location:addteam.php?msg=success");
		} else {
		    header("location:addteam.php?msg=failed");
		}

		}
	

	}
	else{
		header("location:addteam.php?msg=notfound");
	}

?>