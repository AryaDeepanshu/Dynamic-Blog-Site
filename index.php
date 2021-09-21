<?php
  include_once "include/functions.php";
  include_once "include/connection.php";
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
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
          <h1 class="display-5 fw-bold"><?php getSettingValue('home_jumbo_title'); ?></h1>
          <p class="col-md-8 fs-4"><?php getSettingValue('home_jumbo_desc'); ?></p>
          <button class="btn btn-primary btn-lg" type="button">Example button</button>
        </div>
    </div>
    <div class=container>
    <?php
      $sqlpg = "SELECT * FROM `post`";
      $resultpg = mysqli_query($conn, $sqlpg);
      $totalPost = mysqli_num_rows($resultpg);
      $totalPage = ceil($totalPost/3);
    ?>
    <?php
      if(isset($_GET['p'])){
        $pageId = $_GET['p'];
        $start = ($pageId*3)-3;
        $sql = "SELECT * FROM `post` ORDER BY post_id DESC LIMIT $start,3";
      }else{
        $sql = "SELECT * FROM `post` ORDER BY post_id DESC LIMIT 0,3";
      }
    ?>
    <div class="row" data-masonry='{"percentPosition": true }'>
    
      <?php
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $post_title = $row['post_title'];
            $post_content = $row['post_content'];
            $post_image = $row['post_image'];
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];

            $sqlauthor = "SELECT * FROM `author` WHERE author_id='$post_author'";
            $resultauthor = mysqli_query($conn, $sqlauthor);
            while($rowauthor = mysqli_fetch_assoc($resultauthor)){
                $post_author_name = $rowauthor['author_name'];
      ?>
      <div class="col-sm-6 col-lg-4 mb-4">
        <div class="card" style="width: 18rem;">
          <img src="<?php echo $post_image; ?>" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title"><?php echo $post_title; ?></h5>
            <h6 class="card-subtitle mb-2 text-muted"><?php echo $post_author_name; ?></h6>
            <p class="card-text"><?php echo substr(strip_tags($post_content),0,50).'...'; ?></p>
            <a href="post.php?id=<?php echo $post_id; ?>" class="btn btn-primary">Read More</a>
          </div>
      </div>
      </div>
      <?php }} ?>
    
    </div>
    <?php
    echo '<center>';
      for($i=1;$i<=$totalPage;$i++){
        ?>
        <a href="?p=<?php echo $i; ?>"><button class="btn btn-info"><?php echo $i; ?></button></a>&nbsp;
        <?php
      }
      echo '</center>';
    ?>
    </div><br><br>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/scroll.js"></script>
</body>
</html>