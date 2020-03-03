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
 header("location: questions.php"); 
} else{
  $id_question = $_GET['id'];
}

$query = mysqli_query( $link, "select question_name, question_image, option1, option2, option3, option4, option5, answer from tb_question where id_question='$id_question';");
$value = mysqli_fetch_assoc($query);

// Define variables and initialize with empty values
$question_name = $option1 = $option2 = $option3 = $option4 = $option5 = $answer = $question_image = "";
$question_err = $option1_err = $option2_err = $option3_err = $option4_err = $option5_err = $answer_err = $image_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validasi foto
    if(!empty($_FILES['question_image']['name'])){
        $uploadDirectory = "../img/";
        $sourceDirectory ="img/";

        // Jika direktori tidak ada, buat baru
        if (!file_exists($uploadDirectory)) {
          mkdir($uploadDirectory, 0777, true); 
      }

        $file_name = $_FILES['question_image']['name'];
        $file_size = $_FILES['question_image']['size'];
        $file_tmp = $_FILES['question_image']['tmp_name'];
        $file_type = $_FILES['question_image']['type'];

        $file_ext=explode('.',$_FILES['question_image']['name']);
        $file_ext=strtolower(end($file_ext));

        $targetUpload = $uploadDirectory.$file_name;
        $targetSource = $sourceDirectory.$file_name;
        
        $expensions= array("jpeg","jpg","png");
        
        if(in_array($file_ext,$expensions) === false){
            $image_err = "Mohon pilih foto dengan jenis JPG atau PNG."; 
        } else{
          $question_image = $targetSource;
        }     
     }

    $id_question = $_POST['id_question'];
    $old_image = $_POST['old_image'];

    // Validate soal
    if(empty(trim($_POST['question_name']))){
        $question_err = "Mohon lengkapi soal.";     
    } else{
        $question_name = trim($_POST['question_name']);
    }

    // Validate opsi
    if(empty(trim($_POST['option1']))){
        $option1_err = "Mohon isi pilihan jawaban.";     
    } else{
        $option1 = trim($_POST['option1']);
    }

    if(empty(trim($_POST['option2']))){
        $option2_err = "Mohon isi pilihan jawaban.";     
    } else{
        $option2 = trim($_POST['option2']);
    }

    if(empty(trim($_POST['option3']))){
        $option3_err = "Mohon isi pilihan jawaban.";     
    } else{
        $option3 = trim($_POST['option3']);
    }

    if(empty(trim($_POST['option4']))){
        $option4_err = "Mohon isi pilihan jawaban.";     
    } else{
        $option4 = trim($_POST['option4']);
    }

    if(empty(trim($_POST['option5']))){
        $option5_err = "Mohon isi pilihan jawaban.";     
    } else{
        $option5 = trim($_POST['option5']);
    }

    if($_POST['answer'] == 0){
        $answer_err = "Mohon isi jawaban soal.";     
    } else{
        $answer = $_POST['answer'];
    }
    
    
    // Check input errors before inserting in database
    if(empty($question_err) && empty($option1_err) && empty($option2_err) && empty($option3_err) && empty($option4_err) && empty($option5_err) && empty($answer_err) && empty($image_err) ){
        
        // Prepare an insert statement
        $sql = "UPDATE tb_question set question_name=?, question_image=?, option1=?, option2=?, option3=?, option4=?, option5=?, answer=? where id_question=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssii", $param_question, $param_image, $param_option1, $param_option2, $param_option3, $param_option4, $param_option5, $param_answer, $param_id);
            
            // Set parameters
            $param_question = $question_name;
            
            if(!empty($_FILES['question_image']['name'])){
              $param_image = $question_image;
            } else{
              $param_image = $old_image;
            }

            $param_option1 = $option1;
            $param_option2 = $option2;
            $param_option3 = $option3;
            $param_option4 = $option4;
            $param_option5 = $option5;
            $param_answer = $answer;
            $param_id = $id_question;
            
            // Attempt to execute the prepared statement
            if(!empty($_FILES['question_image']['name'])){
              if(move_uploaded_file($file_tmp, $targetUpload)){
                if(mysqli_stmt_execute($stmt)){
                    // Redirect
                    header("location: questions.php?msg=success");
                } else{
                    header("location: questions.php?msg=failed");
                }
            }
          } elseif(mysqli_stmt_execute($stmt)){
                // Redirect
                header("location: questions.php?msg=success");
            } else{
                header("location: questions.php?msg=failed");
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
                    <li class="active">
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
	    
      <div class="container">
          <center><h2>Ubah Soal</h2></center>
          <br>
      <form id="question" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"  enctype="multipart/form-data">
      
       <input type="text" class="form-control" name = "id_question" value="<?php echo $id_question; ?>" readonly hidden/>
       <input type="text" class="form-control" name = "old_image" value="<?php echo $value['question_image']; ?>" readonly hidden/>
       
       <?php if($value['question_image'] !== "" && !is_null($value['question_image'])){?>
       <div class="form-group">
        <img src="<?php echo "../" . $value['question_image']; ?>" style="max-width: 100%">
        </div>
      <?php } ?>
      <div class="form-group">
        <label for="question_name">Soal</label>
        <textarea class="form-control <?php echo (!empty($question_err)) ? 'is-invalid' : ''; ?>" name="question_name" rows="5"><?php echo $value['question_name']; ?></textarea>
        <span class="help-block" style="color: red;"><?php echo $question_err; ?></span>
      </div>

      <div class="form-group">
        <label for="question_image">Gambar (opsional)</label>
        <input type="file" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" name = "question_image"/>
        <span class="help-block" style="color: red;"><?php echo $image_err; ?></span>
      </div>

    <div class="form-group">
      <label for="option1">Opsi 1</label>
      <input type="text" class="form-control <?php echo (!empty($option1_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $value['option1']; ?>" name = "option1"/>
      <span class="help-block" style="color: red;"><?php echo $option1_err; ?></span>
    </div>

    <div class="form-group">
      <label for="option2">Opsi 2</label>
      <input type="text" class="form-control <?php echo (!empty($option2_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $value['option2']; ?>" name = "option2"/>
      <span class="help-block" style="color: red;"><?php echo $option2_err; ?></span>
    </div>

    <div class="form-group">
      <label for="option3">Opsi 3</label>
      <input type="text" class="form-control <?php echo (!empty($option3_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $value['option3']; ?>" name = "option3"/>
      <span class="help-block" style="color: red;"><?php echo $option3_err; ?></span>
    </div>

    <div class="form-group">
      <label for="option4">Opsi 4</label>
      <input type="text" class="form-control <?php echo (!empty($option4_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $value['option4']; ?>" name = "option4"/>
      <span class="help-block" style="color: red;"><?php echo $option4_err; ?></span>
    </div>

    <div class="form-group">
      <label for="option5">Opsi 5</label>
      <input type="text" class="form-control <?php echo (!empty($option5_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $value['option5']; ?>" name = "option5"/>
      <span class="help-block" style="color: red;"><?php echo $option5_err; ?></span>
    </div>
    
    <div class="form-group">
                <label for="answer">Jawaban</label>
                <select class="custom-select <?php echo (!empty($answer_err)) ? 'is-invalid' : ''; ?>" name="answer">
                  <option value="0" style="display:none"></option>
                  <option value="1" <?php if($value['answer'] == 1){ echo "selected";} ?>>Opsi 1</option>
                  <option value="2" <?php if($value['answer'] == 2){ echo "selected";} ?>>Opsi 2</option>
                  <option value="3" <?php if($value['answer'] == 3){ echo "selected";} ?>>Opsi 3</option>
                  <option value="4" <?php if($value['answer'] == 4){ echo "selected";} ?>>Opsi 4</option>
                  <option value="5" <?php if($value['answer'] == 5){ echo "selected";} ?>>Opsi 5</option>
                </select>
                <span class="help-block" style="color: red;"><?php echo $answer_err; ?></span>
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