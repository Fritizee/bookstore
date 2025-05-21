<?php

session_start();

if(isset($_SESSION['user_id']) &&
   isset($_SESSION['user_email']) &&
   isset($_SESSION['user_role']) &&
   $_SESSION['user_role'] === "admin") {

    include "../db_conn.php";

    if (isset($_POST['author_name'])) {
        $name = $_POST['author_name'];

        if (empty($name)) {
            $em = "Author name is required";
            header("Location: ../add-author.php?error=$em");
            exit;
        } else {
            $sql = "INSERT INTO authors (name)
                    VALUES (?)";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$name]);

            if ($res) {
                $sm = "Successfully added new author";
                header("Location: ../add-author.php?success=$sm");
                exit;
            } else {
                $em = "Unknown error occurred!";
                header("Location: ../add-author.php?error=$em");
                exit;
            }
        }
    } else {
        header("Location: ../admin.php");
        exit; 
    }


} else {
    header("Location: ../login.php");
    exit;
} 