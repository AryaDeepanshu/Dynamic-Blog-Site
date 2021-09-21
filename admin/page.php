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
                    <h1 class="h2">Categories</h1>
                    <h6>Hello <?php echo $_SESSION['author_name']; ?> | You role is <?php echo $_SESSION['author_role'] ?> </h6>
                </div>
                <div>
                    <h1>All Pages:</h1>
                    <button id="addPageBtn" class="btn btn-primary" >Add new Page</button>
                    <hr>
                    <div style ="display:none" id="addPageForm">
                        <form  action="newpage.php" method="POST">
                            <div class="mb-3">
                                <label for="exampleInputTitile" class="form-label">Page Title</label>
                                <input name="page_title" type="text" class="form-control" id="exampleInputCategoryName" aria-describedby="emailHelp" placeholder="Page title">
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputContent" class="form-label">Page Content</label>
                                <textarea name="page_content" class="form-control" id="exampleInputTextArea1" aria-describedby="emailHelp" rows="4" placeholder="Page Content"></textarea>
                            </div>
                            <button name="submit" type="submit" class="btn btn-success">Add</button>
                        </form>
                    </div>
                    <?php 
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">page ID</th>
                                <th scope="col">page Title</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM `page` ORDER BY page_id DESC";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_assoc($result)){
                                        $page_id = $row['page_id'];
                                        $page_title = $row['page_title'];
                                            ?>
                                            <tr>
                                            <th scope="row"><?php echo $page_id;?></th>
                                            <td><?php echo $page_title;?></td>
                                            <td><a href="editpage.php?id=<?php echo $page_id;?>"><button class="btn btn-info">Edit</button></a> <a href="deletepage.php?id=<?php echo $page_id;?>"><button class="btn btn-danger">Delete</button></a></td>
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
    <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter pageembed permanentpen table',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
   });
  </script>
    <script>
        $(document).ready(function(){
            $('#addPageBtn').click(function(){
                $('#addPageForm').slideToggle();
            });
        });
    </script>
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