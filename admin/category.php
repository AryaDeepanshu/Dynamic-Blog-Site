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
                    <h1 class="h2">Categories</h1>
                    <h6>Hello <?php echo $_SESSION['author_name']; ?> | You role is <?php echo $_SESSION['author_role'] ?> </h6>
                </div>
                <div>
                    <h1>All Categories:</h1>
                    <a href="newcategory.php"><button class="btn btn-primary" >Add new Category</button></a>
                    <hr>
                    <?php 
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Category ID</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM `category` ORDER BY category_id DESC";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_assoc($result)){
                                        $category_id = $row['category_id'];
                                        $category_name = $row['category_name'];
                                            ?>
                                            <tr>
                                            <th scope="row"><?php echo $category_id;?></th>
                                            <td><?php echo $category_name;?></td>
                                            <td><a href="editcategory.php?id=<?php echo $category_id;?>"><button class="btn btn-info">Edit</button></a></td>
                                            </tr>


                            <?php } ?>
                    
                    
                    
                        </tbody>
                        </table>
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