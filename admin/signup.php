<?php
  include_once "../include/functions.php";
  include_once "../include/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body class="d-flex text-center" style="height:100vh">
    
    <div  style="width: 500px; margin:auto">
    <?php
        if(isset($_GET['message'])){
            $msg = $_GET['message'];
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <strong>'.$msg.'!</strong>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }
        if(isset($_GET['SuccessMessage'])){
            $msg = $_GET['SuccessMessage'];
            if($msg == 'Registered Successfully'){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>'.$msg.'!</strong>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            }else{
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>'.$msg.'!</strong>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            }
            
        }

    ?>
        <main class="signup">
            <form method="POST" class="form-signup">
                <h1 class="h3 mb-3 fw-normal">Sign Up</h1>
                <div class="form-floating">
                <input type="text" class="form-control" name="author_name" id="InputName" placeholder="Name" required>
                <label for="floatingInput">Name</label>
                </div>
                <div class="form-floating">
                <input type="email" class="form-control" name="author_email" id="InputEmail" placeholder="name@example.com" required>
                <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating">
                <input type="password" class="form-control" name="author_password" id="InputPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
                </div><br>
                <button class="w-100 btn btn-lg btn-primary" name="signup" type="submit">Sign Up</button>
                <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
            </form>
        </main>
    </div>
    <?php
        if(isset($_POST['signup'])){
            
            $author_name = mysqli_real_escape_string($conn,$_POST['author_name']);
            $author_email = mysqli_real_escape_string($conn,$_POST['author_email']);
            $author_password = mysqli_real_escape_string($conn,$_POST['author_password']);
            
            if(empty($author_name) OR empty($author_email) OR empty($author_password)){
                header("Location:signup.php?message=Empty+Fields");
                exit();
            }
            if(!filter_var($author_email,FILTER_VALIDATE_EMAIL)){
                header("Location:signup.php?message=Please+Enter+A+Valid+Email");
                exit();
            }else{
                
                $sql = "SELECT * FROM `author` WHERE `author_email`='$author_email'";
                $result = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($result) > 0){
                    header("Location:signup.php?message=Email+Already+Exists");
                    exit();
                }else{
                    
                    $hash = password_hash($author_password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO `author` (`author_name`, `author_email`, `author_password`, `author_bio`, `author_role`) VALUES('$author_name', '$author_email', '$hash', 'Enter bio', 'author')";
                    $result = mysqli_query($conn, $sql);
                    if($result){
                        header("Location:signup.php?SuccessMessage=Registered+Successfully");
                    }else{
                        header("Location:signup.php?SuccessMessage=Registration+Failed");
                    }
                }
            }
        }
    ?>
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/scroll.js"></script>
</body>
</html>