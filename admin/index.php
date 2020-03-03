<?php
session_start();

require_once 'config.php';

if(isset($_SESSION['done'])){
  header("location: ../login.php");
}

if(!isset($_SESSION['username'])){
  header("location: login.php");
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
                    <li class="active">
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
	    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis non turpis risus. In sed purus massa. Nunc condimentum velit maximus hendrerit varius. Etiam finibus, dolor sed accumsan blandit, ante elit placerat tellus, id molestie eros orci at mauris. Maecenas finibus eros et libero suscipit dictum. Cras ut tellus id orci vestibulum tempor. Fusce nibh eros, dictum et commodo id, faucibus id est. Maecenas varius nunc ut ipsum accumsan efficitur. Maecenas lectus risus, cursus vel massa vel, tincidunt hendrerit elit. Proin mollis feugiat nisi.</p>
	    <br>
		<p>Aenean vel aliquet tortor, pharetra porttitor tortor. Proin vestibulum enim ac tortor euismod pulvinar. Pellentesque eget lacinia turpis, at convallis mauris. Ut in rutrum odio, vel iaculis arcu. Integer et bibendum metus. Nam eget nibh nec ligula fringilla fringilla non et dolor. Nam non est egestas, fringilla ipsum et, interdum nunc.</p>
		<br>
		<p>Sed feugiat ex sed odio ullamcorper, non vestibulum lacus hendrerit. Proin bibendum velit nec tellus tincidunt luctus. Donec lacus augue, posuere ut tortor vel, feugiat pharetra nulla. Sed at interdum lorem. Donec turpis nunc, venenatis in est at, interdum commodo dui. Proin tristique leo velit, ut faucibus nisi facilisis eget. Etiam elementum dictum hendrerit. Fusce placerat malesuada est. Aenean ut massa sed justo ultrices venenatis. Proin vel urna arcu. Mauris faucibus fringilla ligula sed pulvinar. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla quis lobortis diam. Pellentesque ut lorem gravida, lobortis nisl id, eleifend felis. Morbi cursus pellentesque ligula non viverra.</p>
		<br>
		<p>Duis rutrum libero sed lorem pretium fermentum. Phasellus dolor mi, fermentum eget tincidunt ut, ullamcorper non odio. Proin rutrum lobortis tortor. Aenean sed nisi scelerisque, faucibus eros ut, accumsan justo. Nulla efficitur arcu neque, ac vehicula dui convallis vel. Ut nec tincidunt elit. Donec rhoncus erat eu ornare vulputate. Aliquam ut nisl sed tortor semper ultrices. Praesent porttitor consequat facilisis. Sed rutrum sollicitudin diam in rhoncus.</p>
		<br>
		<p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam volutpat, ipsum et dapibus suscipit, libero nulla sollicitudin neque, laoreet ultricies ex metus volutpat nisi. Suspendisse aliquet volutpat ligula. Vivamus pulvinar erat orci, id accumsan odio egestas ac. Duis varius venenatis commodo. Donec nec venenatis tortor, vitae luctus ante. Etiam sagittis malesuada nisl, sed posuere justo vulputate at. Etiam venenatis auctor eros, sit amet porta mi blandit ut.</p>
	    </div>

    </div>
  </body>
</html>