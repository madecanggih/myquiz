<?php
require_once 'config.php';
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $error_msg = "";

session_start();
//session_unset();
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = 'Mohon masukkan username.';
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Mohon masukkan password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, nama, password FROM tb_admin WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $nama, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                          
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            //session_start();
                            $_SESSION['username'] = $username;
                            $_SESSION['nama'] = $nama;
                            header("location: index.php");
                        
                        } else{
                            // Display an error message if password is not valid
                            $password_err = 'Password tidak sesuai.';
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = 'Username tidak terdaftar.';
                }
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

  <title>Login Quiz Application</title>
  <link rel="icon" href="" type="image/png" />

  <meta name="description" content="Quiz Application">
  <meta name="keywords" content="HTML,PHP,MySQL,JavaScript,Quiz,Web,Application">
  <meta name="author" content="Made Indra Wira Pramana">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="../css/bootstrap-reboot.min.css" type="text/css">
  <link rel="stylesheet" href="../css/bootstrap-grid.min.css" type="text/css">
  <link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css">


  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/jquery.min.js"></script>

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
<div class="container" style="padding: 10% 0%;min-width: 30%; max-width: 80%; margin: 0 auto; ">
 
 <div class="card">
 <div class="card-header bg-primary text-white" align="center"><strong><h4>Administrator</h4></strong></div>
 
  <div class="card-body">
    <form id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <?php if(!empty($error_msg)){
    echo "<center><div class='alert alert-danger' role='alert'><STRONG>Peringatan! </STRONG>$error_msg</div></center>";;
    }?>
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
				<span class="input-group-text"><i class="fa fa-lock"></i></span>
      </div>
				<input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" name = "password" placeholder="Password" />
			</div>
			<span class="help-block" style="color: red;"><?php echo $password_err; ?></span>
		</div>
		<div class="form-group text-center">
      <input type="submit" class="btn btn-outline-primary" value="Login">
			<!-- <a href="#" class="btn btn-link">Lupa Password</a> -->
		</div>
  	</form>
  </div>

  <div class="card-footer bg-primary text-white" align="center">© Made Indra Wira Pramana </div>
</div>

</div>

</body>
</html>