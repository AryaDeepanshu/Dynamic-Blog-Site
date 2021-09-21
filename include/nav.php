<?php 
include_once("connection.php");
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
    <a class="navbar-brand" href="#">My Dynamic Site</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
        <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <?php
            $pageSql = 'SELECT * FROM `page`';
            $pageResult = mysqli_query($conn, $pageSql);
            while($pageRow = mysqli_fetch_assoc($pageResult)){
                $page_id = $pageRow['page_id'];
                $page_title = $pageRow['page_title'];
                ?>
            <li class="nav-item">
                <a class="nav-link" href="page.php?id=<?php echo $page_id; ?>"><?php echo $page_title; ?></a>
            </li>
            <?php } ?>
        <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categories
        </a>
        <?php
            $sql = 'SELECT * FROM `category`';
            $result = mysqli_query($conn, $sql);
        ?>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php 
            while($row = mysqli_fetch_assoc($result)){
                ?>
            <li><a href="/category.php?id=<?php echo $row['category_id'];?>" class="dropdown-item"><?php echo $row['category_name'];?></a></li>
            <?php }?>
            
        </ul>
        </li>
    </ul>
    <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    </div>
</div>
</nav>
