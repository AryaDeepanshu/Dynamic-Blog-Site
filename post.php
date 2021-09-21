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
            $sql = "SELECT * FROM `post` WHERE post_id='$id'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result)<=0){
                header("Location:index.php?np+post");
            }else{
                while($row = mysqli_fetch_assoc($result)){
                    $post_title = $row['post_title'];
                    $post_content = $row['post_content'];
                    $post_date = $row['post_date'];
                    $post_category = $row['post_category'];
                    $post_author = $row['post_author'];
                    $post_image = $row['post_image'];
                    $post_keyword = $row['post_keyword'];
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
                        <img src="<?php echo $post_image ?>" width="100%">
                        <h1><?php echo $post_title ?></h1>
                        <hr>
                        <h6>Posted On: <?php echo $post_date; ?> | By: <?php getAuthorName($post_author); ?></h6>
                        <h4>Category:<a href="category.php?id=<?php echo $post_category; ?>"> <?php echo getCategoryName($post_category); ?></a></a></h4>
                        <p><?php echo $post_content ?></p>
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