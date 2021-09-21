<?php
    include_once "connection.php";
    function add_jumbotron(){
        echo '<div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
          <h1 class="display-5 fw-bold">Custom jumbotron</h1>
          <p class="col-md-8 fs-4">Using a series of utilities, you can create this jumbotron, just like the one in previous versions of Bootstrap. Check out the examples below for how you can remix and restyle it to your liking.</p>
          <button class="btn btn-primary btn-lg" type="button">Example button</button>
        </div>
      </div>';
    }
    function getAuthorName($id){
        global $conn;
        $sql = "SELECT * FROM author WHERE author_id='$id'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
          echo $row['author_name'];
        }
    }
    function getCategoryName($id){
        global $conn;
        $sql = "SELECT * FROM category WHERE category_id='$id'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
          echo $row['category_name'];
        }
  }
?>