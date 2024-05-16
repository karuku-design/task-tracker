<?php
session_start(); 

include "db_conn.php";

if (isset($_POST['officer_Code'])&& isset($_POST['password'])){

    //Fuctin to remove unwanted characters and spaces
    function validate($data){

        $data = trim($data);
 
        $data = stripslashes($data);
 
        $data = htmlspecialchars($data);
 
        return $data;
 
     }

     //apply the function to the input
	$officer_Code=validate($_POST['officer_Code']);
	$pass=validate($_POST['password']);

    //check if the required fields are empty if not login
	if (empty($officer_Code)) {

        header("Location: index.php?error=Officer code is required!");
        exit();

    }else if(empty($pass)){
        header("Location: index.php?error=please enter password!");
        exit();

    }else{

        //sql query to select and compare details entered and those in the DB
        $sql= "SELECT * FROM `officers` WHERE Officer_Code= '$officer_Code' AND Password='$pass'";
        $result = mysqli_query($conn, $sql);//pass the query to the mysql connection


        //check if there's a result of the query
        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['Officer_Code'] === $officer_Code && $row['Password'] === $pass) {

                $_SESSION['officer_code'] = $row['Officer_Code'];

                $_SESSION['officer_name'] = $row['Officer_Name'];

                header("Location: home_page.php?success=Login Successful!");
                exit();

            }else{ //if not then display error

                header("Location: index.php?error=Incorect Code or password");

                exit();

            }

        }else{
            header("Location: index.php?error=Officer Does not Exist!"); 
        }
	}

}




?>