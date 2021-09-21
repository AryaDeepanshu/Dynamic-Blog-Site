<?php
    include_once("../include/connection.php");
    session_start();
    if(!isset($_POST['submit'])){
        header("Location: ../index.php");
        exit();
    }else{
        if(!isset($_SESSION['author_role'])){
            header("Location:Login.php");
            exit();
        }else{
            if($_SESSION['author_role'] != 'admin'){
                header("Location: post.php");
                exit();
            }elseif($_SESSION['author_role'] === 'admin'){
                $category_name = $_POST['category_name'];
                $sql = "INSERT INTO `category` (`category_name`) VALUES('$category_name')";
                if(mysqli_query($conn, $sql)){
                    header("Location:category.php?message=Added+succesfully");
                    exit();
                }else{
                    header("Location:category.php?message=error");
                    exit();
                }
            }
        }
    }
?>