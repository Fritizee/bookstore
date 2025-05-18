<?php 
session_start();

include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_all_books($conn);

#Author helper function
include "php/func-author.php";
$authors = get_all_author($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_category($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Online Book Store</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" 
                    id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" 
                        aria-current="page" 
                        href="index.php">Store</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" 
                       href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" 
                       href="#">About</a>
                    </li>
                    <li class="nav-item">
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <a class="nav-link" 
                        href="admin.php">Admin</a>
                    <?php } else { ?>
                        <a class="nav-link" 
                        href="login.php">Login</a>
                    <?php } ?>
                    </li>
                </ul>
                </div>
            </div>
        </nav>

        <form action="search.php"
              method="get"
              style="width: 100%; max-width: 30rem">
            <div class="input-group my-5">
                <input type="text" 
                       class="form-control"
                       name="key" 
                       placeholder="Search Book..." 
                       aria-label="Search Book..." 
                       aria-describedby="basic-addon2">
                <button class="input-group-text
                        btn btn-primary" 
                        id="basic-addon2">
                    <img src="img/search.png"
                         width="20">
                </button>
            </div>
        </form>

        <div class="d-flex pt-3">
            <?php if ($books == 0) { ?>
                <div class="alert alert-warning text-center p-5" role="alert">
                <img src="img/empty.png" width="100">
                <br>
			    No Books in the database
		        </div>
            <?php } else { ?>
            <div class="pdf d-flex flex-wrap">
                <?php foreach ($books as $book) { ?>
                <div class="card m-1">
                    <img src="uploads/cover/<?=$book['cover']?>"
                        class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?=$book['title']?></h5>
                            <p class="card-text">
                                <i><b>By: 
                                    <?php foreach ($authors as $author) { 
                                        if ($author['id'] == $book['author_id']) {
                                            echo $author['name'];
                                            break;
                                        }
                                    } ?>
                                <br></b></i>
                                <?=$book['description']?></p>
                                <i><b>Category: 
                                    <?php foreach ($categories as $category) { 
                                        if ($category['id'] == $book['category_id']) {
                                            echo $category['name'];
                                            break;
                                        }
                                    } ?>
                                <br></b></i>
                            <a href="uploads/files/<?=$book['file']?>"
                            class="btn btn-success">Open</a>

                            <a href="uploads/files/<?=$book['file']?>"
                            class="btn btn-primary"
                            download="<?=$book['title']?>">Download</a>
                        </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        <div class="category">
            <!-- List of categories -->
            <div class="list-group">
                <?php if ($categories == 0) {
                    // do nothing
                } else {?>
                <a href="#"
                   class="list-group-item list-group-item-action active"
                   >Category</a>
                   <?php foreach ($categories as $category) { ?>
                    
                   
                   <a href="category.php?id=<?=$category['id']?>"
                      class="list-group-item list-group-item-action"
                      ><?=$category['name']?></a>
                <?php } } ?>
            </div>

            <!-- List of authors -->
            <div class="list-group mt-5">
                <?php if ($authors == 0) {
                    // do nothing
                } else {?>
                <a href="#"
                   class="list-group-item list-group-item-action active"
                   >Author</a>
                   <?php foreach ($authors as $author) { ?>
                    
                   
                   <a href="author.php?id=<?=$author['id']?>"
                      class="list-group-item list-group-item-action"
                      ><?=$author['name']?></a>
                <?php } } ?>
            </div>
        </div>
        </div>
    </div>

</body>
</html>