<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email']) &&
	isset($_SESSION['user_role']) &&
	$_SESSION['user_role'] === "admin") {

	# Database connection
	include "../db_conn.php";


    /** 
	  check if category 
	  name is submitted
	**/
	if (isset($_POST['category_name']) &&
        isset($_POST['category_id'])) {
		/** 
		Store it
		**/
		$name = $_POST['category_name'];
		$id = $_POST['category_id'];

		# Validation
		if (empty($name)) {
			$em = "The category name is required";
			header("Location: ../edit-category.php?error=$em&id=$id");
            exit;
		}else {
			# UPDATE the Database
			$sql  = "UPDATE categories 
			         SET name=?
			         WHERE id=?";
			$stmt = $conn->prepare($sql);
			$res  = $stmt->execute([$name, $id]);

			/**
		      If there is no error
		    **/
		     if ($res) {
		     	# success message
		     	$sm = "Successfully updated!";
				header("Location: ../edit-category.php?success=$sm&id=$id");
	            exit;
		     }else{
		     	# Error message
		     	$em = "Unknown Error Occurred!";
				header("Location: ../edit-category.php?error=$em&id=$id");
	            exit;
		     }
		}
	}else {
      header("Location: ../admin.php");
      exit;
	}

}else{
  header("Location: ../login.php");
  exit;
}