<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);
    print($uname);
    print($pass);

	if (empty($uname)) {
		header("Location: admin.php?error=User Name is required");
	    exit();
	}
	else if(empty($pass)){
        header("Location: admin.php?error=Password is required");
	    exit();
	}
	else{
		$sql = "SELECT * FROM admin WHERE user_name='$uname' AND password='$pass'";
		$result = mysqli_query($conn, $sql);
        
		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['user_name'] === $uname && $row['password'] === $pass) {
            	$_SESSION['user_name'] = $row['user_name'];
            	$_SESSION['password'] = $row['password'];

            	header("Location: Attendance/teacher/index.php");
		        exit();
            }else{
				header("Location: admin.php?error=Incorect User name or password");
		        exit();
			}
		}else{
			header("Location: admin.php?error=Incorect User name or password");
	        exit();
		}
	}
	
}else{
	header("Location: admin.php");
	exit();
}