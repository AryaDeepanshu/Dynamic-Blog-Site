<?php
    session_start();
    include_once("../include/connection.php");
    if(isset($_SESSION['author_role'])){
        if(isset($_GET['id'])){
            if($_SESSION['author_role'] === 'admin'){
                $id = $_GET['id'];
                $sql = "DELETE FROM `post` WHERE post_id='$id'";
                if(mysqli_query($conn,$sql)){
                    echo("<script>location.href = '/admin/post.php?msg=Post+deleted';</script>");
                    exit();
                }else{
                    echo("<script>location.href = '/admin/post.php?msg=Could+not+delete+post';</script>");
                    exit();
                }
            }elseif($_SESSION['author_role'] === 'author'){
                $id = $_GET['id'];
                $sql = "SELECT `post_author` FROM `post` WHERE post_id='$id'";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result)>0){
                    while($row = mysqli_fetch_assoc($result)){
                        if($row['post_author'] == $_SESSION['author_id']){
                            $postsql = "DELETE FROM `post` WHERE post_id='$id'";
                            if(mysqli_query($conn,$postsql)){
                                echo("<script>location.href = '/admin/post.php?msg=Post+deleted';</script>");
                                exit();
                            }else{
                                echo("<script>location.href = '/admin/post.php?msg=Could+not+delete+post';</script>");
                                exit();
                            }
                        }else{
                            echo("<script>location.href = '/admin/post.php?msg=Could+not+delete+post';</script>");
                            exit();
                        }
                    }
                    
                }else{
                    echo("<script>location.href = '/admin/post.php?msg=No+Such+Post+exists';</script>");
                    exit();
                }

            }
        }else{
            echo("<script>location.href = '/admin/post.php';</script>");
            exit();
        }

    }else{
        echo("<script>location.href = 'index.php?msg=You+are+not+allowed+to+perform+this+action';</script>");
        exit();
    }
?>