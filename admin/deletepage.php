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
                header("Location:page.php?message=click+button+to+delete+page");
                exit();
            }else{
                $page_id = $_GET['id'];
                $sql = "SELECT * FROM `page` WHERE page_id='$page_id'";
                $result = mysqli_query($conn, $sql);    
                if(mysqli_num_rows($result) <= 0){
                    header("Location:page.php?message=no+page");
                    exit();
                }else{
                        $sql = "DELETE FROM `page` WHERE page_id='$page_id'";
                        if(!mysqli_query($conn, $sql)){
                            header("Location:page.php?message=np+page");
                    exit();
                        }else{
                            header("Location:page.php?message=page+deleted");
                            exit();
                    }
                }
            }
        }
    }
?>