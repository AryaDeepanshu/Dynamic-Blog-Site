<?php
 include_once "../include/functions.php";
 include_once "../include/connection.php";
 session_start();
if(isset($_SESSION['author_role'])){
    if($_SESSION['author_role'] === 'admin'){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Settings</title>
        <link rel="stylesheet" href="../style/bootstrap.min.css">
        <link rel="stylesheet" href="../style/style.css">
        <script src="https://cdn.tiny.cloud/1/aouh3ey3zwhnv54c4n9cm7h4upepxsmfznw2naqdaru1w2kl/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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
                    <h1 class="h2">Settings</h1>
                    <h6>Hello <?php echo $_SESSION['author_name']; ?> | You role is <?php echo $_SESSION['author_role'] ?> </h6>
                </div>
                <div>
                    <h1>All Settings:</h1>
                    <hr>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="exampleInputTitile" class="form-label">HomePage jumbotron Title</label>
                                <input name="home_jumbo_title" type="text" class="form-control" id="exampleInputCategoryName" aria-describedby="emailHelp" placeholder="HomePage Jumbotron Title" value="<?php getSettingValue('home_jumbo_title'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputTitile" class="form-label">HomePage jumbotron Description</label>
                                <input name="home_jumbo_desc" type="text" class="form-control" id="exampleInputCategoryName" aria-describedby="emailHelp" placeholder="HomePage Jumbotron Description" value="<?php getSettingValue('home_jumbo_desc'); ?>">
                            </div>
                            <button name="submit" type="submit" class="btn btn-success">Update</button>
                        </form>
                        <?php
                            if(isset($_POST['submit'])){
                                $jumboTitle = mysqli_real_escape_string($conn, $_POST['home_jumbo_title']);
                                $jumboDesc = mysqli_real_escape_string($conn, $_POST['home_jumbo_desc']);
                                setSettingValue('home_jumbo_title', $jumboTitle);
                                setSettingValue('home_jumbo_desc', $jumboDesc);
                                echo("<script>location.href = '/admin/setting.php?message=settings+updated';</script>");
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
        header("Location:../index.php");
    }    
 }else{
    header("Location:login.php");
 }
?>