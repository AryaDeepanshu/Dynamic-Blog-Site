<?php
 include_once "../include/connection.php";
 session_start();
if(isset($_SESSION['author_role'])){
    if($_SESSION['author_role'] === 'admin'){
        if(isset($_GET['id'])){
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
                    <h1>Edit Post:</h1>
                    <?php
                        $post_id = $_GET['id'];
                        $FormSql = "SELECT * FROM `post` WHERE post_id='$post_id'";
                        $FormResult = mysqli_query($conn, $FormSql);
                        while($FormRow = mysqli_fetch_assoc($FormResult)){
                            ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="exampleInputTitile" class="form-label">Title</label>
                            <input name="post_title" type="text" class="form-control" id="exampleInputTitile" aria-describedby="emailHelp" value="<?php echo $FormRow['post_title']; ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleInputContent" class="form-label">Content</label>
                            <textarea name="post_content" class="form-control" id="exampleInputTextArea1" aria-describedby="emailHelp" rows="9"><?php echo $FormRow['post_content']; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputImage" class="form-label">Image</label><br>
                            <img src="../<?php echo $FormRow['post_image'];?>"><br>
                            <br><input name="file" type="file" class="form-control" id="exampleInputImage" aria-describedby="emailHelp">
                        </div>

                        <button name="editpost" type="submit" class="btn btn-primary">Update</button>
                    </form>
                    <?php } ?>
                    <?php
                        if(isset($_POST['editpost'])){
                            $post_title = mysqli_escape_string($conn, $_POST['post_title']);
                            $post_content = mysqli_escape_string($conn, $_POST['post_content']);
                            $post_keyword = mysqli_escape_string($conn, $_POST['post_keyword']);
                            if(empty($post_title) OR empty($post_content)){
                                echo("<script>location.href = '/admin/newpost.php?message=Empty+fields';</script>");
                                exit();
                            }

                            if(is_uploaded_file($_FILES['file']['tmp_name'])){
                                $file = $_FILES['file'];
                                $fileName = $file['name'];
                                $fileType = $file['type'];
                                $fileTmp = $file['tmp_name'];
                                $fileErr = $file['error'];
                                $fileSize = $file['size'];
                                $fileEXT = explode('.', $fileName);
                                $fileExtention = strtolower(end($fileEXT));
                                $allowedEXT = array('jpg', 'jpeg', 'png');
                                if(in_array($fileExtention,$allowedEXT)){
                                    if($fileErr === 0){
                                        if($fileSize <300000){
                                            $newFileName = uniqid('',true).'.'.$fileExtention;
                                            $destination = "../uploads/$newFileName";
                                            $dbdestination = "uploads/$newFileName";
                                            move_uploaded_file($fileTmp, $destination);
                                            echo 'Image Uploaded';
                                            $sql = "UPDATE `post` SET post_title='$post_title', post_content='$post_content', post_keyword='$post_keyword', post_image='$dbdestination' WHERE post_id='$post_id'";
                                            if(mysqli_query($conn,$sql)){
                                                echo("<script>location.href = '/admin/post.php?msg=Post+Updated';</script>");
                                                exit();
                                            }else{
                                                echo("<script>location.href = '/admin/newpost.php?msg=error';</script>");
                                                exit(); 
                                            }  
                                        }else{
                                            echo("<script>location.href = '/admin/newpost.php?msg=Image+size+too+big';</script>");
                                            exit();
                                        }
                                    }else{
                                        echo("<script>location.href = '/admin/newpost.php?msg=Something+went+wrong';</script>");
                                        exit();
                                    }
                                }else{
                                    echo("<script>location.href = '/admin/newpost.php?msg=Wrong+file+type';</script>");
                                    exit();
                                }

                            }else{
                                #user dont want to update image
                                $sql = "UPDATE `post` SET post_title='$post_title', post_content='$post_content', post_keyword='$post_keyword' WHERE post_id='$post_id'";
                                if(mysqli_query($conn,$sql)){
                                    echo("<script>location.href = '/admin/post.php?msg=Post+Updated';</script>");
                                    exit();
                                }else{
                                    echo("<script>location.href = '/admin/newpost.php?msg=error';</script>");
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
        }else{
            header("Location:post.php");
        }
    }else{
        header("Location:post.php");
    }
 }else{
    header("Location:login.php");
 }
?>
