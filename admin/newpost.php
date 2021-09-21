<?php
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
                    <h1 class="h2">Posts</h1>
                    <h6>Hello<?php echo ' '.$_SESSION['author_name'].' | You role is '.$_SESSION['author_role']; ?></h6>
                </div>
                <div>
                    <h1>Add New Post:</h1>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="exampleInputTitile" class="form-label">Title</label>
                            <input name="post_title" type="text" class="form-control" id="exampleInputTitile" aria-describedby="emailHelp" placeholder="Post Title">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputTitile" class="form-label">Category</label>
                            <select name="post_category" class="form-select" aria-label="Default select example" placeholder="Select Category">
                                <?php
                                    $sql = "SELECT * FROM `category` ORDER BY category_id";
                                    $result = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_assoc($result)){
                                    echo '<option value="'.$row['category_id'].'">'.$row['category_name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleInputContent" class="form-label">Content</label>
                            <textarea name="post_content" class="form-control" id="exampleInputTextArea1" aria-describedby="emailHelp" placeholder="Post Content"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputImage" class="form-label">Image</label>
                            <input name="file" type="file" class="form-control" id="exampleInputImage" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputKeyword" class="form-label">Keywords</label>
                            <input name="post_keyword" type="text" class="form-control" id="exampleInputKeyword" aria-describedby="emailHelp" placeholder="Post Keyword">
                        </div>
                        <button name="post" type="submit" class="btn btn-primary">Post</button>
                    </form>
                    <?php
                        if(isset($_POST['post'])){
                            $post_title = mysqli_escape_string($conn, $_POST['post_title']);
                            $post_content = mysqli_escape_string($conn, $_POST['post_content']);
                            $post_category = mysqli_escape_string($conn, $_POST['post_category']);
                            $post_keyword = mysqli_escape_string($conn, $_POST['post_keyword']);
                            $post_author = $_SESSION['author_id'];
                            $post_date = date("d/m/y");
                            if(empty($post_title) OR empty($post_content) OR empty($post_category)){
                                header("Location:newpost.php?message=Empty+fields");
                                exit();
                            }
                

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
                                        $sql = "INSERT INTO `post` (`post_title`, `post_content`, `post_image`, 
                                        `post_date`, `post_category`, `post_author`, `post_keyword`) VALUES('$post_title', 
                                        '$post_content', '$dbdestination', '$post_date', '$post_category', '$post_author', '$post_keyword')";
                                        if(mysqli_query($conn,$sql)){
                                            echo("<script>location.href = '/admin/post.php?msg=Post+Published';</script>");
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
    </body>
    </html>
    <?php
 }else{
    header("Location:login.php");
 }
?>
