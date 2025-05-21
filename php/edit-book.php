<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email']) &&
    isset($_SESSION['user_role']) &&
    $_SESSION['user_role'] === "admin") {

	# Database Connection File
	include "../db_conn.php";

   # Validation helper function
   include "func-validation.php";

   # File Upload helper function
   include "func-file-upload.php";
    /** 
	  check if author 
	  name is submitted
	**/
	if (isset($_POST['book_id']) &&
        isset($_POST['book_title'])       &&
        isset($_POST['book_description']) &&
        isset($_POST['book_author'])      &&
        isset($_POST['book_category'])    &&
        isset($_FILES['book_cover'])      &&
        isset($_FILES['file']) &&
        isset($_POST['current_cover']) &&
        isset($_POST['current_file'])) {
		/** 
		Get data from POST request 
		and store them in var
		**/
		$id = $_POST['book_id'];
        $title       = $_POST['book_title'];
		$description = $_POST['book_description'];
		$author      = $_POST['book_author'];
		$category    = $_POST['book_category'];

        $current_cover = $_POST['current_cover'];
        $current_file = $_POST['current_file'];

        #simple form Validation
        $text = "Book title";
        $location = "../edit-book.php";
        $ms = "id=$id&error";
		is_empty($title, $text, $location, $ms, "");

		$text = "Book description";
        $location = "../edit-book.php";
        $ms = "id=$id&error";
		is_empty($description, $text, $location, $ms, "");

		$text = "Book author";
        $location = "../edit-book.php";
        $ms = "id=$id&error";
		is_empty($author, $text, $location, $ms, "");

		$text = "Book category";
        $location = "../edit-book.php";
        $ms = "id=$id&error";
		is_empty($category, $text, $location, $ms, "");

		if (!empty($_FILES['book_cover']['name'])) {
           if (!empty($_FILES['file']['name'])) {
            # update both

            # book cover Uploading
            $allowed_image_exs = array("jpg", "jpeg", "png");
            $path = "cover";
            $book_cover = upload_file($_FILES['book_cover'], $allowed_image_exs, $path);

             # book cover Uploading
            $allowed_file_exs = array("pdf", "docx", "pptx");
            $path = "files";
            $file = upload_file($_FILES['file'], $allowed_file_exs, $path);

            if ($book_cover['status'] == "error" || $file['status'] == "error") {
                $em = $book_cover['data'];
    
                /**
                  Redirect to '../edit-book.php' 
                  and passing error message & id
                **/
                header("Location: ../edit-book.php?error=$em&id=$id");
                exit;
            } else {
                $c_p_book_cover = "../uploads/cover/$current_cover";
                $c_p_file = "../uploads/files/$current_file";

                unlink($c_p_book_cover);
                unlink($c_p_file);

                $file_URL = $file['data'];
		        $book_cover_URL = $book_cover['data'];

                # update data
                $sql = "UPDATE books 
                        SET title=?, author_id=?, description=?, category_id=?, cover=?, file=?
                        WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$title, $author, $description, $category, $book_cover_URL, $file_URL, $id]);

                /**
                 If there is no error while 
                updating the data
                **/
                if ($res) {
                    # success message
                    $sm = "Successfully updated!";
                    header("Location: ../edit-book.php?success=$sm&id=$id");
                    exit;
                }else{
                    # Error message
                    $em = "Unknown Error Occurred!";
                    header("Location: ../edit-book.php?error=$em&id=$id");
                    exit;
                }
            }
           } else {
                # update just cover

                # book cover Uploading
                $allowed_image_exs = array("jpg", "jpeg", "png");
                $path = "cover";
                $book_cover = upload_file($_FILES['book_cover'], $allowed_image_exs, $path);

                if ($book_cover['status'] == "error") {
                    $em = $book_cover['data'];
        
                    /**
                     Redirect to '../edit-book.php' 
                    and passing error message & id
                    **/
                    header("Location: ../edit-book.php?error=$em&id=$id");
                    exit;
                } else {
                    $c_p_book_cover = "../uploads/cover/$current_cover";

                    unlink($c_p_book_cover);

                    $book_cover_URL = $book_cover['data'];

                    # update data
                    $sql = "UPDATE books 
                            SET title=?, author_id=?, description=?, category_id=?, cover=?
                            WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $res = $stmt->execute([$title, $author, $description, $category, $book_cover_URL, $id]);

                    /**
                     If there is no error while 
                    updating the data
                    **/
                    if ($res) {
                        # success message
                        $sm = "Successfully updated!";
                        header("Location: ../edit-book.php?success=$sm&id=$id");
                        exit;
                    }else{
                        # Error message
                        $em = "Unknown Error Occurred!";
                        header("Location: ../edit-book.php?error=$em&id=$id");
                        exit;
                    }
                }
            }
        }
        else if (!empty($_FILES['file']['name'])) {
            # update just book file

             # book cover Uploading
            $allowed_file_exs = array("pdf", "docx", "pptx");
            $path = "files";
            $file = upload_file($_FILES['file'], $allowed_file_exs, $path);

            if ($file['status'] == "error") {
                $em = $file['data'];
    
                /**
                  Redirect to '../edit-book.php' 
                  and passing error message & id
                **/
                header("Location: ../edit-book.php?error=$em&id=$id");
                exit;
            } else {
                $c_p_file = "../uploads/files/$current_file";

                unlink($c_p_file);

                $file_URL = $file['data'];

                # update data
                $sql = "UPDATE books 
                        SET title=?, author_id=?, description=?, category_id=?, file=?
                        WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$title, $author, $description, $category, $file_URL, $id]);

                /**
                 If there is no error while 
                updating the data
                **/
                if ($res) {
                    # success message
                    $sm = "Successfully updated!";
                    header("Location: ../edit-book.php?success=$sm&id=$id");
                    exit;
                }else{
                    # Error message
                    $em = "Unknown Error Occurred!";
                    header("Location: ../edit-book.php?error=$em&id=$id");
                    exit;
                }
            }
        } else {
            # update data
            $sql = "UPDATE books 
                    SET title=?, author_id=?, description=?, category_id=?
                    WHERE id=?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$title, $author, $description, $category, $id]);

            /**
		      If there is no error while 
		      updating the data
		    **/
		     if ($res) {
                # success message
                $sm = "Successfully updated!";
               header("Location: ../edit-book.php?success=$sm&id=$id");
               exit;
            }else{
                # Error message
                $em = "Unknown Error Occurred!";
               header("Location: ../edit-book.php?error=$em&id=$id");
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