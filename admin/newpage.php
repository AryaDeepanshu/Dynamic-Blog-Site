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
                header("Location: page.php");
                exit();
            }elseif($_SESSION['author_role'] === 'admin'){
                $page_title = $_POST['page_title'];
                $page_content = $_POST['page_content'];
                $sql = "INSERT INTO `page`( `page_title`, `page_content`) VALUES('$page_title', '$page_content')";
                if(mysqli_query($conn, $sql)){
                    header("Location:page.php?message=Added+succesfully");
                    exit();
                }else{
                    header("Location:page.php?message=error");
                    exit();
                }
            }
        }
    }
?>