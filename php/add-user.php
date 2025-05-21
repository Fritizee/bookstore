<?php  

	# Database Connection File
	include "../db_conn.php";

    # Validation helper function
    include "func-validation.php";

    # File Upload helper function
    include "func-file-upload.php";


    /** 
	  If all Input field
	  are filled
	**/
	if (isset($_POST['full_name']) &&
        isset($_POST['email']) &&
        isset($_POST['password'])) {
		/** 
		Get data from POST request 
		and store them in var
		**/
		$name = $_POST['full_name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$role    = "user";

		# making URL data format
		$user_input = 'name='.$name.'&email='.$email.'&password='.$password;

		#simple form Validation

        $text = "Name";
        $location = "../register.php";
        $ms = "error";
		is_empty($name, $text, $location, $ms, $user_input);

		$text = "Email";
        $location = "../register.php";
        $ms = "error";
		is_empty($email, $text, $location, $ms, $user_input);

		$text = "Password";
        $location = "../register.php";
        $ms = "error";
		is_empty($password, $text, $location, $ms, $user_input);

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(full_name, email, password, role) 
                VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute([$name, $email, $hashed_password, $role]);

        if ($res) {
            # success message
            $sm = "You are registered now";
           header("Location: ../login.php?success=$sm");
           exit;
        }else{
            # Error message
            $em = "Unknown Error Occurred!";
           header("Location: ../register.php?error=$em");
           exit;
        }
    }