<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">
                            <span data-feather="home"></span>
                            Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="post.php">
                            <span data-feather="file"></span>
                            Posts
                            </a>
                        </li>
                        <?php
                            if(isset($_SESSION['author_role'])){
                                if($_SESSION['author_role']=== 'admin'){
                                    ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="category.php">
                                            <span data-feather="file"></span>
                                            Categories
                                            </a>
                                        </li>
                                    <?php
                                }
                            }
                        ?>
                        </ul>
                        
                    </div>
                </nav>