<?php
session_start();

require_once 'include/config.php';

if(!isset($_SESSION['done'])){
  header("location: login.php");
}

$query = mysqli_query( $link, "select * from tb_setting;");
$setting = mysqli_fetch_assoc($query);

$username=$_SESSION['username'];
    
    $right_answer=0;
    $wrong_answer=0;
    $unanswered=0; 

    $pointRight = $setting['point_right'];
    $pointWrong = $setting['point_wrong'];
    $pointUnanswered = $setting['point_unanswered'];
  
   $keys=array_keys($_POST);
   $order=join(",",$keys);
   
   $response=mysqli_query( $link, "select id_question,answer from tb_question where id_question IN($order) ORDER BY FIELD (id_question,$order)") or die(mysqli_error($link));
   
   while($result=mysqli_fetch_array($response)){
       if($result['answer']==$_POST[$result['id_question']]){
               $right_answer++;
           }else if($_POST[$result['id_question']]==0){
               $unanswered++;
           }
           else{
               $wrong_answer++;
           }
   } 

  $score=($right_answer * $pointRight) + ($wrong_answer * $pointWrong) + ($unanswered * $pointUnanswered);

   mysqli_query($link, "INSERT INTO tb_result (username, answer_right, answer_wrong, answer_empty, score) VALUES ('$username','$right_answer','$wrong_answer','$unanswered','$score')") or die(mysqli_error($link));
   mysqli_query($link, "UPDATE tb_user set done=1 where username='$username'");
   $_SESSION['done']=1;

   

?>

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Quiz Application</title>
  <link rel="icon" href="" type="image/png" />

  <meta name="description" content="Quiz Application">
  <meta name="keywords" content="HTML,PHP,MySQL,JavaScript,Quiz,Web,Application">
  <meta name="author" content="Made Indra Wira Pramana">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="css/bootstrap-reboot.min.css" type="text/css">
  <link rel="stylesheet" href="css/bootstrap-grid.min.css" type="text/css">
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">


  <script src="js/bootstrap.min.js" type="text/javascript"></script>
  <script src="js/jquery.min.js" type="text/javascript"></script>
  <!-- <script src="js/timer.js" type="text/javascript"></script> -->

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->

<style type="text/css">
  /*phone layout and less*/
  @media (max-width: 575.98px) {
    .container{
      width: 100%;
    }
  }

  /*tablet layout and less*/
  @media (max-width: 768px) {
    #navbarlist{
      display: none;
    }
  }

  /*tablet layout and up*/
  @media (min-width: 768px) {
    .container{
      width: 50%;
    }
  }
  </style>

</head>
  <body style="font-family: 'Roboto', sans-serif; background-color: #f5f5f5; font-size: small; ">

  <!-- <nav class="navbar navbar-default" style="background-color: #ffffff;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Quiz Application</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right" id="navbarlist">
      <li><a href="#"><span class="fa fa-user"></span> <?php echo $_SESSION['nama']; ?></a></li>
    </ul>
  </div>
</nav> -->

<div class="container" style="padding: 5% 0%; margin: 0 auto;">
  
  <div class="card">
    
    <div class="card-header bg-primary text-white" style="background-color: #ffffff">
      <center><h2>Hasil</h2></center>
    </div>

    <div class="card-body">
      <center><h4>Anda mendapatkan nilai <?php echo $score; ?></h4></center>
      <br>
      <p><i class="fa fa-check"></i> <span class="answer"><?php echo $right_answer;?></span> Jawaban Benar</p>
      <p><i class="fa fa-times"></i> <span class="answer"><?php echo $wrong_answer;?></span> Jawaban Salah</p>
      <p><i class="fa fa-ban"></i> <span class="answer"><?php echo $unanswered;?></span> Kosong</p>
      <br>
      <center><a href="logout.php" class='btn btn-outline-secondary'>Logout</a></center>
    </div>

  </div>