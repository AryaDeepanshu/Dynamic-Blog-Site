<?php
    include_once("../include/connection.php");
    include_once("../include/functions.php");
    session_start();
    if(!isset($_SESSION['author_role'])){
        header("Location:login.php?message=login+first");
        exit();
    }else{
        if($_SESSION['author_role'] != 'admin'){
            header("Location:index.php?message=Not+allowed");
            exit();
        }elseif($_SESSION['author_role'] === 'admin'){
            if(!isset($_GET['id'])){
                header("Location:page.php?message=click+button+to+add+page");
                exit();
            }else{
                $page_id = $_GET['id'];
                $sql = "SELECT * FROM `page` WHERE page_id='$page_id'";
                $result = mysqli_query($conn, $sql);    
                if(mysqli_num_rows($result) <= 0){
                    header("Location:page.php?message=np+page");
                    exit();
                }else{
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
                                        <h6>Hello<?php echo ' '.$_SESSION['author_name'].' | You role is '.$_SESSION['author_role']; ?></h6>
                                    </div>
                                    <div>
                                        <h1>Edit Page:</h1>
                                        <?php
                                            $post_id = $_GET['id'];
                                            $FormSql = "SELECT * FROM `page` WHERE page_id='$page_id'";
                                            $FormResult = mysqli_query($conn, $FormSql);
                                            while($FormRow = mysqli_fetch_assoc($FormResult)){
                                                $page_title = $FormRow['page_title'];
                                                $page_content = $FormRow['page_content'];
                                                ?>
                                        <form method="POST">
                                            <div class="mb-3">
                                                <label for="exampleInputTitile" class="form-label">Page Title</label>
                                                <input name="page_title" type="text" class="form-control" id="exampleInputTitile" aria-describedby="emailHelp" value="<?php echo $page_title; ?>">
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="exampleInputContent" class="form-label">Page Content</label>
                                                <textarea name="page_content" class="form-control" id="exampleInputTextArea1" aria-describedby="emailHelp" rows="4"><?php echo $page_content; ?></textarea>
                                            </div>

                                            <button name="submit" type="submit" class="btn btn-primary">Update</button>
                                        </form>
                                        <?php } ?>
                                        <?php
                                            if(isset($_POST['submit'])){
                                                $page_title = mysqli_escape_string($conn, $_POST['page_title']);
                                                $page_content = mysqli_escape_string($conn, $_POST['page_content']);
                                                if(empty($page_title) OR empty($page_content)){
                                                    echo("<script>location.href = '/admin/newpage.php?message=Empty+fields';</script>");
                                                    exit();
                                                }else{
                                                
                                                    $sql = "UPDATE `page` SET page_title='$page_title', page_content='$page_content'  WHERE page_id='$page_id'";
                                                    if(mysqli_query($conn,$sql)){
                                                        echo("<script>location.href = '/admin/page.php?msg=Post+Updated';</script>");
                                                        exit();
                                                    }else{
                                                        echo("<script>location.href = '/admin/nepage.php?msg=error';</script>");
                                                        exit(); 
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
                }
             }
        }
    }
?>