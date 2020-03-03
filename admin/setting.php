<?php
session_start();

require_once 'config.php';

if(isset($_SESSION['done'])){
  header("location: ../login.php");
}

if(!isset($_SESSION['username'])){
  header("location: login.php");
}

$query = mysqli_query( $link, "select * from tb_setting;");
$setting = mysqli_fetch_assoc($query);

// Define variables and initialize with empty values
$totalQuestion = $setting['total_question'];
$pointRight = $setting['point_right'];
$pointWrong = $setting['point_wrong'];
$pointUnanswered = $setting['point_unanswered'];
$totalQuestion_err = $pointRight_err = $pointWrong_err = $pointUnanswered_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
    // Validate soal
    if(!is_numeric($_POST['totalQuestion']) && !intval($_POST['totalQuestion'])){
        $totalQuestion_err = "Mohon isi jumlah soal.";     
    } else if($_POST['totalQuestion'] <=0){
        $totalQuestion_err = "Jumlah soal minimal 1."; 
    }
      else{
        $totalQuestion = $_POST['totalQuestion'];
    }

    if(!is_numeric($_POST['pointRight']) && !intval($_POST['pointRight'])){
        $pointRight_err = "Mohon isi nilai jawaban benar.";     
    } else{
        $pointRight = $_POST['pointRight'];
    }

    if(!is_numeric($_POST['pointWrong']) && !intval($_POST['pointWrong'])){
        $pointWrong_err = "Mohon isi nilai jawaban salah.";     
    } else{
        $pointWrong = $_POST['pointWrong'];
    }

    if(!is_numeric($_POST['pointUnanswered']) && !intval($_POST['pointUnanswered'])){
        $pointUnanswered_err = "Mohon isi nilai jawaban kosong.";     
    } else{
        $pointUnanswered = $_POST['pointUnanswered'];
    }
    
    
    // Check input errors before inserting in database
    if(empty($totalQuestion_err) && empty($pointRight_err) && empty($pointWrong_err) && empty($pointUnanswered_err)){
        
        // Prepare an insert statement
        $sql = "UPDATE tb_setting SET total_question = ? , point_right = ?, point_wrong = ?, point_unanswered = ?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iiii", $param_totalQuestion, $param_pointRight, $param_pointWrong, $param_pointUnanswered);
            
            // Set parameters
            $param_totalQuestion = $totalQuestion;
            $param_pointRight = $pointRight;
            $param_pointWrong = $pointWrong;
            $param_pointUnanswered = $pointUnanswered;
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect
                header("location: setting.php?msg=success");
            } else{
                header("location: setting.php?msg=failed");
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">

  <title>Quiz Dashboard</title>
  <link rel="icon" href="" type="image/png" />

  <meta name="description" content="Quiz Application">
  <meta name="keywords" content="HTML,PHP,MySQL,JavaScript,Quiz,Web,Application">
  <meta name="author" content="Made Indra Wira Pramana">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="../css/bootstrap-reboot.min.css" type="text/css">
  <link rel="stylesheet" href="../css/bootstrap-grid.min.css" type="text/css">
  <link rel="stylesheet" href="../css/style.css" type="text/css">
  <link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css">
  <style type="text/css">
  /*phone layout and less*/
  @media (max-width: 575.98px) {
    .container{
      width: 100%;
    }
  }

  /*tablet layout and less*/
  @media (max-width: 768px) {
    .navbarlist{
      display: none;
    }
  }

  /*tablet layout and up*/
  @media (min-width: 768px) {
    .container{
      width: 50%;
    }
  }

  	.navbar-fixed-top {
    border-width: 0 0 1px;
    top: 0;
}

  	.wrapping {
  	padding-top: 56px;
    padding-left: 0px;
    /*-webkit-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -o-transition: all .5s ease;
    transition: all .5s ease;*/
}

@media (min-width: 992px) {
    .content-wrapping{
		padding-left: 15px;
		padding-right: 25px;
		padding-top: 5px;
		min-width: 762px; 
	}
    .wrapping {
        padding-left: 225px;
    }
}

@media (min-width: 992px) {
    .wrapping .sidebar-wrapping {
        width: 225px;
    }
}

.sidebar-wrapping {
    border-right: 1px solid #e7e7e7;
}

.sidebar-wrapping {
    z-index: 1000;
    position: fixed;
    left: 225px;
    width: 0;
    height: 100%;
    margin-left: -225px;
    overflow-y: auto;
    background: #f8f8f8;
    /*-webkit-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -o-transition: all .5s ease;
    transition: all .5s ease;*/
}

.sidebar-wrapping .sidebar-nav {
    position: absolute;
    top: 0;
    width: 225px;
    font-size: 14px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.sidebar-wrapping .sidebar-nav li {
    text-indent: 0;
    line-height: 45px;
}

.sidebar-wrapping .sidebar-nav li a {
    display: block;
    text-decoration: none;
    color: #428bca;
}

.sidebar-nav .active a {
    background: #92bce0;
    color: #fff !important;
}

.sidebar-wrapping .sidebar-nav li a .sidebar-icon {
    width: 45px;
    height: 45px;
    font-size: 14px;
    padding: 0 2px;
    display: inline-block;
    text-indent: 7px;
    margin-right: 10px;
    float: left;
}

.sidebar-wrapping .sidebar-nav li a .caret {
  position: absolute;
  right: 23px;
  top: auto;
  margin-top: 20px;
}


@media (max-width: 992px) {
	.content-wrapping{
		padding-left: 50px;
		padding-right: 10px;
		padding-top: 2px;
	}
    .wrapping .sidebar-wrapping {
        width: 45px;
    }
    .wrapping .sidebar-wrapping .sidebar .sidemenu li ul {
        position: fixed;
        left: 45px;
        margin-top: -45px;
        z-index: 1000;
        width: 200px;
        height: 0;
    }
}

  </style>
  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->

</head>
  <body style="font-family: 'Roboto', sans-serif">
	<script src="../js/bootstrap.min.js" type="text/javascript"></script>
  	<script src="../js/jquery.min.js" type="text/javascript"></script>
  
  	<div class="navbar-wrapping">
            <nav class="navbar fixed-top bg-light" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Quiz Dashboard</a>
                    </div>
                    <ul class="nav navbar-nav navbar-right navbarlist">
				      <li><a href="#"><span class="fa fa-user"></span>  <?php echo $_SESSION['nama']; ?>  </a></li>
				    </ul>
                </div>
            </nav>
    </div>
    <div class="wrapping">
        <div class="sidebar-wrapping">
            <aside class="sidebar">
                <ul class="sidemenu sidebar-nav">
                    <li>
                        <a href="index.php">
                            <span class="sidebar-icon"><i class="fa fa-question-circle"></i></span>
                            <span class="sidebar-title">Panduan</span>
                        </a>
                    </li>
                    <li>
                        <a href="addquestion.php">
                            <span class="sidebar-icon"><i class="fa fa-pencil"></i></span>
                            <span class="sidebar-title">Tambah Soal</span>
                        </a>
                    </li>
                    <li>
                        <a href="questions.php">
                            <span class="sidebar-icon"><i class="fa fa-book"></i></span>
                            <span class="sidebar-title">Kelola Soal</span>
                        </a>
                    </li>
                    <li>
                        <a href="adduser.php">
                            <span class="sidebar-icon"><i class="fa fa-user-plus"></i></span>
                            <span class="sidebar-title">Tambah Pengguna</span>
                        </a>
                    </li>
                    <li>
                        <a href="userlist.php">
                            <span class="sidebar-icon"><i class="fa fa-users"></i></span>
                            <span class="sidebar-title">Kelola Pengguna</span>
                        </a>
                    </li>
                    <li>
                        <a href="addteam.php">
                            <span class="sidebar-icon"><i class="fa fa-handshake-o"></i></span>
                            <span class="sidebar-title">Tim Pengguna</span>
                        </a>
                    </li>
                    <li>
                        <a href="view.php">
                            <span class="sidebar-icon"><i class="fa fa-bell"></i></span>
                            <span class="sidebar-title">Lihat Hasil</span>
                        </a>
                    </li>
                    <hr>
                    <li class="active">
                        <a href="setting.php">
                            <span class="sidebar-icon"><i class="fa fa-cogs"></i></span>
                            <span class="sidebar-title">Pengaturan</span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php">
                            <span class="sidebar-icon"><i class="fa fa-sign-out"></i></span>
                            <span class="sidebar-title">Keluar</span>
                        </a>
                    </li>
                </ul>
            </aside>             
        </div>
    
	    <div class="content-wrapping" style="text-align: justify;">
	    <div class="container">
          <center><h2>Pengaturan</h2></center>
          <br>
          <?php if(isset($_GET['msg'])){
            if ($_GET['msg'] === "success"){
              echo "<div class='alert alert-success' role='alert'>Pengaturan berhasil disimpan!</div>";
            }
            else{
              echo "<div class='alert alert-danger' role='alert'>Pengaturan gagal disimpan!</div>";
            }
          } ?>
      <form id="question" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      

    <div class="form-group">
      <label for="totalQuestion">Jumlah Soal</label>
      <input type="number" class="form-control <?php echo (!empty($totalQuestion_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $totalQuestion; ?>" name = "totalQuestion"/>
      <span class="help-block" style="color: red;"><?php echo $totalQuestion_err; ?></span>
    </div>

    <div class="form-group">
      <label for="pointRight">Poin Jawaban Benar</label>
      <input type="number" class="form-control <?php echo (!empty($pointRight_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pointRight; ?>" name = "pointRight"/>
      <span class="help-block" style="color: red;"><?php echo $pointRight_err; ?></span>
    </div>

    <div class="form-group">
      <label for="pointWrong">Poin Jawaban Salah</label>
      <input type="number" class="form-control <?php echo (!empty($pointWrong_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pointWrong; ?>" name = "pointWrong"/>
      <span class="help-block" style="color: red;"><?php echo $pointWrong_err; ?></span>
    </div>

    <div class="form-group">
      <label for="pointUnanswered">Poin Jawaban Kosong</label>
      <input type="number" class="form-control <?php echo (!empty($pointUnanswered_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pointUnanswered; ?>" name = "pointUnanswered"/>
      <span class="help-block" style="color: red;"><?php echo $pointUnanswered_err; ?></span>
    </div>
    
    <div class="form-group text-center">
      <input type="submit" class="btn btn-outline-primary" value="Simpan">
    </div>
    </form>
    </div>
	    </div>

    </div>
  </body>
</html>