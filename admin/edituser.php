<?php
session_start();

require_once 'config.php';

if(isset($_SESSION['done'])){
  header("location: ../login.php");
}

if(!isset($_SESSION['username'])){
  header("location: login.php");
} 

if(!isset($_GET['id'])){
  if(!($_SESSION['id'])){
 header("location: userlist.php");
 }
 else{
  $username = $_SESSION['id'];
 } 
} else{
  $username = $_GET['id'];
  $_SESSION['id'] = $_GET['id'];
}

$query = mysqli_query( $link, "select username, nama, team, password from tb_user where username='$username';");
$value = mysqli_fetch_assoc($query);

$teamquery = mysqli_query($link, "select * from tb_team");


// Define variables and initialize with empty values
$username = $nama = $team = $password = $confirm_password = "";
$username_err = $nama_err = $team_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    $username = $_POST['username'];
    $oldpass = $_POST['oldpass'];
    
    // Validate nama
    if(empty(trim($_POST['nama']))){
        $nama_err = "Mohon masukkan nama.";     
    } else{
        $nama = trim($_POST['nama']);
    }

    // Validate team
    if($_POST['team'] == 0){
        $team_err = "Mohon pilih tim.";     
    } else{
        $team = trim($_POST['team']);
    }

    // Validate confirm password
    if(!empty(trim($_POST['password'])) && empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Mohon konfirmasi password.';     
    } elseif (!empty(trim($_POST['password'])) && !empty(trim($_POST["confirm_password"]))){
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        if($password !== $confirm_password){
            $confirm_password_err = 'Password tidak sesuai.';
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($nama_err) && empty($team_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "UPDATE tb_user set nama=?, team=?, password=? where username=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "siss", $param_nama, $param_team, $param_password, $param_username);
            
            // Set parameters
            $param_username = $username;
            $param_nama = $nama;
            $param_team = $team;
            
            if(!empty(trim($_POST['password']))){
              $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            } else{
              $param_password = $oldpass;
            }

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                $_SESSION['id'] = "";
                header("location: userlist.php?msg=success");
            } else{
                $_SESSION['id'] = "";
                header("location: userlist.php?msg=failed");
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
                    <li class="active">
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
                    <li>
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
          <center><h2>Ubah Pengguna</h2></center>
          <br>
	    <form id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      
      <input type="text" class="form-control" value="<?php echo $value['username']; ?>" name = "username" placeholder="Username" readonly hidden/>

    <div class="form-group">
      <div class="input-group mb-3"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-user"></i></span>
        </div>
        <input type="text" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $value['username']; ?>" disabled/>
      </div>
      <span class="help-block" style="color: red;"><?php echo $username_err; ?></span>
    </div>

    <div class="form-group">
      <div class="input-group mb-3"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-list-alt"></i></span>
        </div>
        <input type="text" class="form-control <?php echo (!empty($nama_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $value['nama']; ?>" name = "nama" placeholder="Nama Lengkap" style="" />
      </div>
      <span class="help-block" style="color: red;"><?php echo $nama_err; ?></span>
    </div>
    
    <input type="password" class="form-control" value="<?php echo $value['password']; ?>" name = "oldpass" readonly hidden/>

    <div class="form-group">
      <div class="input-group mb-3"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-users"></i></span>
        </div>
        <select class="custom-select <?php echo (!empty($team_err)) ? 'is-invalid' : ''; ?>" name="team">
                  <?php while ( $result = mysqli_fetch_assoc($teamquery) ) {?>
                    
                    <option value="<?php echo $result['id_team']; ?>" <?php if(!empty($value['team']) && $value['team'] == $result['id_team']){ echo "selected";} ?>><?php echo $result['name_team']; ?></option>

                  <?php } ?>
                </select>
      </div>
      <span class="help-block" style="color: red;"><?php echo $team_err; ?></span>
    </div>

    <div class="form-group">
      <div class="input-group mb-3"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-lock"></i></span>
        </div>
        <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" name = "password" placeholder="Password" />
      </div>
      <span class="help-block" style="color: red;"><?php echo $password_err; ?></span>
    </div>

    <div class="form-group">
      <div class="input-group mb-3"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-lock"></i></span>
      </div>
        <input type="password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" name = "confirm_password" placeholder="Konfirmasi Password" />
      </div>
      <span class="help-block" style="color: red;"><?php echo $confirm_password_err; ?></span>
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