<?php
// Include config file
require_once 'include/config.php';
 
$query = mysqli_query($link, "select * from tb_team");

// Define variables and initialize with empty values
$username = $nama = $team = $password = $confirm_password = "";
$username_err = $nama_err = $team_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Mohon masukkan username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT username, nama, team, password FROM tb_user WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Username telah terdaftar.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Terjadi kesalahan. Mohon coba kembali.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
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
    
    // if(empty(trim($_POST['team']))){
    //     $team_err = "Mohon masukkan tim.";     
    // } else{
    //     $team = trim($_POST['team']);
    // }

    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Mohon masukkan password.";     
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Mohon konfirmasi password.';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Password tidak sesuai.';
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($nama_err) && empty($team_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO tb_user (username, nama, team, password) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssis", $param_username, $param_nama, $param_team, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_nama = $nama;
            $param_team = $team;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Terjadi kesalahan. Mohon coba kembali.";
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

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Register Quiz Application</title>
  <link rel="icon" href="" type="image/png" />

  <meta name="description" content="Quiz Application">
  <meta name="keywords" content="HTML,PHP,MySQL,JavaScript,Quiz,Web,Application">
  <meta name="author" content="Made Indra Wira Pramana">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="css/bootstrap-reboot.min.css" type="text/css">
  <link rel="stylesheet" href="css/bootstrap-grid.min.css" type="text/css">
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">


  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.min.js"></script>

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->

<style type="text/css">
  /*phone layout and less*/
  @media (max-width: 575.98px) {
    .container{
      width: 80%;
    }
  }


  /*tablet layout and up*/
  @media (min-width: 768px) {
    .container{
      width: 30%;
    }
  }
  </style>

</head>

<body style="font-family: 'Roboto', sans-serif;">
<div class="container" style="padding: 7% 0%;min-width: 30%; max-width: 80%;margin: 0 auto;">
 
 <div class="card">
 <div class="card-header bg-primary text-white" align="center"><strong><h4>Daftar</h4></strong></div>
 
  <div class="card-body">
    <form id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<div class="form-group">
      <div class="input-group mb-3"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-user"></i></span>
        </div>
        <input type="text" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" name = "username" placeholder="Username" style="" />
      </div>
      <span class="help-block" style="color: red;"><?php echo $username_err; ?></span>
    </div>
    <div class="form-group">
      <div class="input-group mb-3"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-list-alt"></i></span>
        </div>
        <input type="text" class="form-control <?php echo (!empty($nama_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nama; ?>" name = "nama" placeholder="Nama Lengkap" style="" />
      </div>
      <span class="help-block" style="color: red;"><?php echo $nama_err; ?></span>
    </div>
    
    <div class="form-group">
      <div class="input-group mb-3"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-users"></i></span>
        </div>
        <select class="custom-select <?php echo (!empty($team_err)) ? 'is-invalid' : ''; ?>" name="team">
                  <option value="0" style="display:none">Tim</option>
                  <?php while ( $result = mysqli_fetch_assoc($query) ) {?>
                    
                    <option value="<?php echo $result['id_team']; ?>" <?php if(!empty($team) && $team == $result['id_team']){ echo "selected";} ?>><?php echo $result['name_team']; ?></option>

                  <?php } ?>
                </select>
      </div>
      <span class="help-block" style="color: red;"><?php echo $team_err; ?></span>
    </div>

    <!-- <div class="form-group">
      <div class="input-group mb-3"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-users"></i></span>
        </div>
        <input type="number" class="form-control <?php echo (!empty($team_err)) ? 'is-invalid' : ''; ?>" name = "team" placeholder="Team" />
      </div>
      <span class="help-block" style="color: red;"><?php echo $team_err; ?></span>
    </div> -->

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
			<input type="submit" class="btn btn-outline-primary" value="Register">
			<!-- <a href="#" class="btn btn-link">Lupa Password</a> -->
		</div>
    <center>Silahkan <a href="login.php">klik disini</a> untuk masuk.</center>
  	</form>
  </div>

  <div class="card-footer bg-primary text-white" align="center">© Made Indra Wira Pramana </div>
</div>

</div>

</body>
</html>