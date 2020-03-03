<?php
require_once 'config.php';

if(isset($_GET['id'])){

	$id = $_GET['id'];

	$find = "SELECT * FROM tb_question WHERE id_question='$id'";
	$result = mysqli_query($link, $find);
		if (mysqli_num_rows($result) == 0) {
				header("location:questions.php?msg=failed");
			}
			else{

	$query = "DELETE FROM tb_question WHERE id_question='$id'";
		if(mysqli_query($link, $query)){
			header("location:questions.php?msg=success");
		} else {
		    header("location:questions.php?msg=failed");
		}

		}
	

	}
	else{
		header("location:questions.php?msg=notfound");
	}

?>