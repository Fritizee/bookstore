<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# Database Connection File
	include "../db_conn.php";


    /** 
	  check if book 
	  id is submitted
	**/
	if (isset($_GET['id'])) {
		/** 
		Get data from POST request 
		and store them in var
		**/
		$id = $_GET['id'];

		#simple form Validation
		if (empty($id)) {
			$em = "Error Occured";
			header("Location: ../admin.php?error=$em");
            exit;
		}else {
			# SELECT from Database
			$sql2  = "SELECT * FROM categories 
			         WHERE id=?";
			$stmt2 = $conn->prepare($sql2);
			$stmt2->execute([$id]);
            $the_book = $stmt2->fetch();

            if ($stmt2->rowCount() > 0) {
                # DELETE from Database
			    $sql  = "DELETE FROM categories 
                WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$id]);

                /**
                    If there is no error while 
                    deleting the data
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