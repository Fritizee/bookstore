<?php
session_start();

if(!isset($_SESSION['user_id']) &&
   !isset($_SESSION['user_email'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center"
         style="min-height: 100vh">
        <form class="p-5 rounded shadow"
              style="max-width: 30rem; width: 100%"
              method="POST"
              action="php/add-user.php">
              
            <h1 class="text-center display-4 pb-5">Login</h1>
            <?php if(isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php } ?>
            
            <div class="mb-3">
                <label class="form-label">
                        Full Name
                </label>
                <input type="text"
                       class="form-control"
                       name="full_name">
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" 
                       class="form-label">Email address</label>
                <input type="email"
                       class="form-control"
                       name="email"
                       id="exampleInputEmail1" 
                       aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" 
                       class="form-label">Password</label>
                <input type="password"
                       class="form-control"
                       name="password"
                       id="exampleInputPassword1">
            </div>

            <button type="submit" 
                    class="btn btn-primary">
                    Register</button>
            <a href="index.php">Store</a> 
        </form>
    </div>
</body>
</html>

<?php
} else {
    header("Location: admin.php");
    exit;
} ?>