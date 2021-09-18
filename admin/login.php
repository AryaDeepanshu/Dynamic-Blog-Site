<?php
    session_start();
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
            <form method="POST" class="form-login">
                <h1 class="h3 mb-3 fw-normal">Log In</h1>
                <div class="form-floating">
                <input type="email" class="form-control" name="author_email" id="InputEmail" placeholder="name@example.com" required>
                <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating">
                <input type="password" class="form-control" name="author_password" id="InputPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
                </div><br>
                <button class="w-100 btn btn-lg btn-primary" name="login" type="submit">Log In</button>
                <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
            </form>
        </main>
    </div>
    <?php
        if(isset($_POST['login'])){
            
            $author_email = mysqli_real_escape_string($conn,$_POST['author_email']);
            $author_password = mysqli_real_escape_string($conn,$_POST['author_password']);
            
            if(empty($author_email) OR empty($author_password)){
                header("Location:login.php?message=Empty+Fields");
                exit();
            }
            if(!filter_var($author_email,FILTER_VALIDATE_EMAIL)){
                header("Location:login.php?message=Please+Enter+A+Valid+Email");
                exit();
            }else{
                
                $sql = "SELECT * FROM `author` WHERE `author_email`='$author_email'";
                $result = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($result) <= 0){
                    header("Location:login.php?message=Login+Error");
                    exit();
                }else{
                    while($row = mysqli_fetch_assoc($result)){
                        if(!password_verify($author_password,$row['author_password'])){
                            header("Location:login.php?message=Login+Error");
                            exit(); 
                        }elseif(password_verify($author_password,$row['author_password'])){
                            
                            $_SESSION['author_id'] = $row['author_id'];
                            $_SESSION['author_name'] = $row['author_name'];
                            $_SESSION['author_email'] = $row['author_email'];
                            $_SESSION['author_bio'] = $row['author_bio'];
                            $_SESSION['author_role'] = $row['author_role'];
                            header("Location:index.php");
                            exit();
                        }
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