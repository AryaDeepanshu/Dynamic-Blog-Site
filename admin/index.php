<?php
 include_once "../include/functions.php";
 include_once "../include/connection.php";
 session_start();
if(isset($_SESSION['author_role'])){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Panel</title>
        <link rel="stylesheet" href="../style/bootstrap.min.css">
        <link rel="stylesheet" href="../style/style.css">
    </head>
    <body>
        <header class="navbar navbar-dark sticky-top bg-dark shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="logout.php">Sign out</a>
            </div>
        </div>
        </header>
    
        <div class="container-fluid">
        <div class="row">
            <?php include_once("nav.inc.php"); ?>
    
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <h6>Hello <?php echo $_SESSION['author_name']; ?> | You role is <?php echo $_SESSION['author_role'] ?> </h6>
            </div>
            <div>
                <form method="POST">
                    <div class="mb-3">
                        <label for="exampleInputName" class="form-label">Name</label>
                        <input name="author_name" type="text" class="form-control" id="exampleInputName" aria-describedby="emailHelp" placeholder="<?php echo $_SESSION['author_name']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input name="author_email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $_SESSION['author_email'];?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input name="author_password" type="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputBio" class="form-label">Bio</label>
                        <textarea name="author_bio" class="form-control" id="exampleInputTextArea1" aria-describedby="emailHelp" placeholder="<?php echo $_SESSION['author_bio']; ?>"></textarea>
                    </div>
                    <button name="update" type="submit" class="btn btn-primary">Update</button>
                </form>
                <?php
                    if(isset($_POST['update'])){
                        $author_name = mysqli_escape_string($conn, $_POST['author_name']);
                        $author_email = mysqli_escape_string($conn, $_POST['author_email']);
                        $author_password = mysqli_escape_string($conn, $_POST['author_password']);
                        $author_bio = mysqli_escape_string($conn, $_POST['author_bio']);
                        if(empty($author_name) OR empty($author_email) OR empty($author_bio)){
                            echo 'Empty Fields';
                        }else{
                            if(!filter_var($author_email, FILTER_VALIDATE_EMAIL)){
                                echo 'Please enter a valid email';
                            }else{
                                $sql = "SELECT * FROM `author` WHERE `author_email`='$author_email'";
                                $result = mysqli_query($conn, $sql);
                                if(mysqli_num_rows($result) > 0){
                                    echo 'Enter Valid Email';
                                }else{
                                    $user_id = $_SESSION['author_id'];
                                    if(empty($author_password)){
                                        $sql = "UPDATE `author` SET author_name='$author_name', author_email='$author_email', author_bio='$author_bio' WHERE author_id='$user_id';";
                                        if(mysqli_query($conn,$sql)){
                                            echo 'Record Updated';
                                            $_SESSION['author_name'] = $author_name;
                                            $_SESSION['author_email'] = $author_email;
                                            $_SESSION['author_bio'] = $author_bio;
                                        }else{
                                            echo 'error';
                                        }
                                    }else{
                                        $hash = password_hash($author_password, PASSWORD_DEFAULT);
                                        $sql = "UPDATE `author` SET author_name='$author_name', author_email='$author_email', author_password='$hash', author_bio='$author_bio' WHERE author_id='$user_id';";
                                        if(mysqli_query($conn,$sql)){
                                            session_unset();
                                            session_destroy();
                                            echo 'Refresh Page To login again';
                                        }else{
                                            echo 'error1';
                                        }
                                    }
                                }
                                
                            }
                            
                        }
                    }
                ?>
            </div>
            <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
            </main>
        </div>
        </div>
    
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/scroll.js"></script>
    </body>
    </html>
    <?php
 }else{
    header("Location:login.php");
 }
?>
