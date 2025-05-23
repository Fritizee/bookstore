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
	  check if book 
	  id is submitted
	**/
	if (isset($_GET['id'])) {
		/** 
		Store it
		**/
		$id = $_GET['id'];

		# Validation
		if (empty($id)) {
			$em = "Error Occured";
			header("Location: ../admin.php?error=$em");
            exit;
		}else {
			# SELECT from Database
			$sql2  = "SELECT * FROM authors 
			         WHERE id=?";
			$stmt2 = $conn->prepare($sql2);
			$stmt2->execute([$id]);
            $the_book = $stmt2->fetch();

            if ($stmt2->rowCount() > 0) {
                # DELETE from Database
			    $sql  = "DELETE FROM authors 
                WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$id]);

                /**
                    If there is no error
                **/
                if ($res) {
                    # success message
                    $sm = "Successfully deleted!";
                    header("Location: ../admin.php?success=$sm");
                    exit;
                }else{
                    # Error message
                    $em = "Unknown Error Occurred!";
                    header("Location: ../admin.php?error=$em");
                    exit;
                }
            } else {
                $em = "Error Occured";
			    header("Location: ../admin.php?error=$em");
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