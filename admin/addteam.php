<?php
session_start();

require_once 'config.php';

if(isset($_SESSION['done'])){
  header("location: ../login.php");
}

if(!isset($_SESSION['username'])){
  header("location: login.php");
}

$query = mysqli_query( $link, "SELECT id_team, name_team from tb_team;");

// Define variables and initialize with empty values
$nameteam = "";
$nameteam_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate nama
    if(empty(trim($_POST['nameteam']))){
        $nameteam_err = "Mohon masukkan nama tim.";     
    } else{
        $nameteam = trim($_POST['nameteam']);
    }
    
    // Check input errors before inserting in database
    if(empty($nameteam_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO tb_team (name_team) VALUES (?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_nameteam);
            
            // Set parameters
            $param_nameteam = $nameteam;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: addteam.php?msg=success");
            } else{
                header("location: addteam.php?msg=failed");
                //echo "Terjadi kesalahan. Mohon coba kembali.";
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
                    <li class="active">
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
	     <center><h2>Tim Pengguna</h2></center><br>
       <?php if(isset($_GET['msg'])){
            if ($_GET['msg'] === "success"){
              echo "<div class='alert alert-success' role='alert'>Berhasil menyimpan perubahan!</div>";
            }
            else{
              echo "<div class='alert alert-danger' role='alert'>Gagal menyimpan perubahan!</div>";
            }
          } ?>
            <form id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    
    <div class="form-group">
      <label for="nameteam">Tambah Tim Baru</label>
      <div class="input-group mb-3"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-handshake-o"></i></span>
        </div>
        <input type="text" class="form-control <?php echo (!empty($nameteam_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nameteam; ?>" name = "nameteam" placeholder="Nama Tim" style="" />
      </div>
      <span class="help-block" style="color: red;"><?php echo $nameteam_err; ?></span>
    </div>

    <div class="form-group text-center">
      <input type="submit" class="btn btn-outline-primary" value="Tambah">
    </div>
    </form>
            <br>
            <table id="viewResult" class="table display" style="width:100%">
          <thead>
              <tr>
                  <th>No</th>
                  <th>Nama Tim</th>
                  <th>Ubah</th>
                  <th>Hapus</th>
              </tr>
          </thead>
          <tbody>
                  <?php
                  $i=0;
                  while ( $view = mysqli_fetch_assoc($query) ) {
                    $i++;

                    echo "<tr>";
                    echo "<td>" . $i . "</td>";
                    echo "<td>" . $view['name_team'] . "</td>";
                    echo "<td> <a href=\"editteam.php?id=$view[id_team]\">Ubah</a> </td>";
                    echo "<td> <a href=\"deleteteam.php?id=$view[id_team]\" onClick=\"return confirm('Anda yakin ingin menghapus?')\">Hapus</a> </td>";
                    echo "</tr>";
                  }
                  ?>
          </tbody>
      </table>
      </div>
	    </div>

    </div>
  </body>
</html>