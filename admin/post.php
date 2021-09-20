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
                    <h1 class="h2">Posts</h1>
                    <h6>Hello <?php echo $_SESSION['author_name']; ?> | You role is <?php echo $_SESSION['author_role'] ?> </h6>
                </div>
                <div>
                    <h1>All Posts:</h1>
                    <a href="newpost.php"><button class="btn btn-primary" >Add new post</button></a>
                    <hr>
                    <?php 
                        if($_SESSION['author_role'] === 'author'){
                            ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Post Image</th>
                                    <th scope="col">Post Title</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $author = $_SESSION['author_id'];
                                        $sql = "SELECT * FROM `post` WHERE post_author='$author' ORDER BY post_id DESC";
                                        $result = mysqli_query($conn, $sql);
                                        $count = 1;
                                        while($row = mysqli_fetch_assoc($result)){
                                            ?>
                                            <tr>
                                            <th scope="row"><?php echo $count;?></th>
                                            <td><img src="<?php echo '/'.$row['post_image'];?>" width="50px" height="50px"></td>
                                            <td><?php echo $row['post_title'];?></td>
                                            <td><a href="deletepost.php?id=<?php echo $row['post_id'];?>"><button class="btn btn-danger">Delete</button></a></td>
                                            </tr> 

                    <?php } }else{
                                ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th scope="col">Post ID</th>
                                        <th scope="col">Post Image</th>
                                        <th scope="col">Post Title</th>
                                        <th scope="col">Post Author</th>
                                        <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT * FROM `post` ORDER BY post_id DESC";
                                            $result = mysqli_query($conn, $sql);
                                            while($row = mysqli_fetch_assoc($result)){
                                                $post_title = $row['post_title'];
                                                $post_content = $row['post_content'];
                                                $post_image = $row['post_image'];
                                                $post_id = $row['post_id'];
                                                $post_author = $row['post_author'];
        
                                                $sqlauthor = "SELECT * FROM `author` WHERE author_id='$post_author'";
                                                $resultauthor = mysqli_query($conn, $sqlauthor);
                                                while($rowauthor = mysqli_fetch_assoc($resultauthor)){
                                                    $post_author_name = $rowauthor['author_name'];
                                                    ?>
                                                    <tr>
                                                    <th scope="row"><?php echo $row['post_id'];?></th>
                                                    <td><img src="<?php echo '/'.$row['post_image'];?>" width="50px" height="50px"></td>
                                                    <td><?php echo $row['post_title'];?></td>
                                                    <td><?php echo $post_author_name;?></td>
                                                    <td><a href="editpost.php?id=<?php echo $row['post_id'];?>"><button class="btn btn-info">Edit</button></a> <a href="deletepost.php?id=<?php echo $row['post_id'];?>"><button class="btn btn-danger">Delete</button></a></td>
                                                    </tr>


                            <?php } } } ?>
                    
                    
                    
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
    header("Location:login.php");
 }
?>