<?php
    include_once("/include/connection.php");
    include_once("/include/functions.php");
    if(!isset($_GET['id'])){
        header("Location: index.php");
    }else{
        $id = mysqli_escape_string($conn, $_GET['id']);
        if(!is_numeric($id)){
            header("Location: index.php");
        }else{
            $sql = "SELECT * FROM `page` WHERE page_id='$id'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result)<=0){
                header("Location:index.php?np+post");
            }else{
                while($row = mysqli_fetch_assoc($result)){
                    $page_title = $row['page_title'];
                    $page_content = $row['page_content'];
                ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>My Dynamic Site</title>
                    <link rel="stylesheet" href="style/bootstrap.min.css">
                    <link rel="stylesheet" href="style/style.css">
                    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
                </head>
                <body>
                
                    <?php include_once "include/nav.php";?>
                    
                    <div class=container>
                        <h1 style="width:100%; background-color:grey; padding-top:25px;padding-bottom:25px;text-align:center"><?php echo $page_title ?></h1>
                        <hr>
                        <p><?php echo $page_content ?></p>
                    </div>

                <script src="js/jquery.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script src="js/scroll.js"></script>
                </body>
                </html>
                <?php }
            }

        }

    }
?>