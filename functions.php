<?php

include ('connection.php');



	session_start();


	// variable declaration

	$username = "";
	$email    = "";
	$Name     = "";
	$Last_name= "";
    $Adress   = "";
	$City     = "";
	$Phone    = null;
	$createdat = date('Y-m-d H:i:s');


	$name="";
	$img="";
	$description="";
    $category="";
    $animal="";
    $price=null;
    $weight=null;

    $comments = "";
    $rating = null;





	$errors   = array(); 

	// call the register() function if register_btn is clicked
	if (isset($_POST['register_btn'])) {
		register();
	}


	// call the login() function if register_btn is clicked
	if (isset($_POST['login_btn'])) {
		login();
	}

	if(isset($_POST['product_btn'])){
	    add_product();
    }





	// REGISTER USER
	function register(){
		global $conn, $errors;

		// receive all input values from the form
		$username    =  e($_POST['username']);
		$email       =  e($_POST['email']);
		$password_1  =  e($_POST['password_1']);
		$password_2  =  e($_POST['password_2']);
		$Name        =  e($_POST['Name']);
		$Last_name   =  e($_POST['Last_name']);
		$Adress      =  e($_POST['Adress']);
		$City        =  e($_POST['City']);
		$Phone       =  e($_POST['Phone']);
        $createdat = e($_POST['Created_at']);

		// form validation: ensure that the form is correctly filled
		if (empty($username)) {
			array_push($errors, "Username is required"); 
		}
		if (empty($email)) { 
			array_push($errors, "Email is required"); 
		}
		if (empty($password_1)) { 
			array_push($errors, "Password is required"); 
		}
		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database

			if (isset($_POST['user_type'])) {
				$user_type = e($_POST['user_type']);
				$query = "INSERT INTO users (User_name, Email, User_type, Password_hash, First_name, Last_name, Adress, City, Phone, Created_at ) 
						  VALUES('$username', '$email', '$user_type', '$password', '$Name', '$Last_name', '$Adress', '$City', '$Phone',CURRENT_TIMESTAMP())";
				mysqli_query($conn, $query);
				$_SESSION['success']  = "New user successfully created!!";
				header('location: index.php');
			}else{
				$query = "INSERT INTO users (User_name, Email, User_type, Password_hash, First_name, Last_name, Adress, City, Phone, Created_at ) 
						  VALUES('$username', '$email', 'user', '$password', '$Name', '$Last_name', '$Adress', '$City', '$Phone', CURRENT_TIMESTAMP())";
				mysqli_query($conn, $query);

				// get id of the created user
				$logged_in_user_id = mysqli_insert_id($conn);

				$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
				$_SESSION['success']  = "You are now logged in";
				header('location: index.php');				
			}

		}

	}





	// return user array from their id
	function getUserById($id){
		global $conn;
		$query = "SELECT * FROM users WHERE ID_User=" . $id;
		$result = mysqli_query($conn, $query);

		$user = mysqli_fetch_assoc($result);
		return $user;
	}











	// LOGIN USER
	function login(){
		global $conn, $username, $errors;

		// grap form values
		$username = e($_POST['username']);
		$password = e($_POST['password']);

		// make sure form is filled properly
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		// attempt login if no errors on form
		if (count($errors) == 0) {
			$password = md5($password);

			$query = "SELECT * FROM users WHERE User_name='$username' AND Password_hash='$password' LIMIT 1";
			$results = mysqli_query($conn, $query);

			if (mysqli_num_rows($results) == 1) { // user found
				// check if user is admin or user
				$logged_in_user = mysqli_fetch_assoc($results);
				if ($logged_in_user['User_type'] == 'admin') {

					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";
					header('location: admin-home.php');
				}else{
					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";

					header('location: index.php');
				}
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}

    }

	function isLoggedIn()

	{
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
	}

	function isAdmin()
	{
		if (isset($_SESSION['user']) && $_SESSION['user']['User_type'] == 'admin' ) {
			return true;
		}else{
			return false;
		}
	}

	// escape string
	function e($val){
		global $conn;
		return mysqli_real_escape_string($conn, trim($val));
	}

	function display_error() {
		global $errors;

		if (count($errors) > 0){
			echo '<div class="error">';
				foreach ($errors as $error){
					echo $error .'<br>';
				}
			echo '</div>';
		}
	}

	function add_product(){

            global $conn, $errors;
            // receive all input values from the form


            $name=e($_POST['name']);
            $description=e($_POST['description']);
            $category=e($_POST['category']);
            $animal=e($_POST['animal']);
            $price=e($_POST['price']);
            $weight=e($_POST['weight']);
            $img=e($_POST['img']);



        // form validation: ensure that the form is correctly filled
            if (empty($name)) {
                array_push($errors, "Add product name");
            }
        if (empty($img)) {
            array_push($errors, "Add product img");
        }

            if (empty($description)) {
                array_push($errors, "Add product description ");
            }
            if (empty($category)) {
                array_push($errors, "Add product category");
            }
            if (empty($animal)) {
                array_push($errors, "Add animal");
            }
            if (empty($price)) {
                array_push($errors, "Add price");
            }
            if (empty($weight)) {
                array_push($errors, "Add weight");
            }







               $query = "INSERT INTO products (name, img, description, category, animal, price, weight)
						  VALUES('$name', '$img', '$description', '$category', '$animal', '$price', '$weight')";
                mysqli_query($conn, $query);
                $_SESSION['success']  = "New product successfully created!!";


    }

	function add_to_cart($id_product, $id_user) {
        global $conn;
        $sql = "INSERT INTO cart (ID_users, id_product) VALUES ($id_user, $id_product)" ;
        mysqli_query($conn, $sql);

        if (mysqli_query($conn, $sql)) {

            echo "<br/><br/><span>Updated successfully...!!</span>";
        } else {
            echo "Error: CAN'T DELETE  <br> DETAILS:" . $sql . "<br>" . mysqli_error($conn);
        }

    }

function add_comment( $id_user, $id_product) {
    global $conn, $errors;


    $comments=e($_POST['comments']);


    if (empty($comments)) {
        array_push($errors, "Add your comment");
    }
    $rating =  e($_POST['rating']);
    if (empty($rating)) {
        array_push($errors, "Add rating");
    }
    $sql = "INSERT INTO review (ID_users, id_product, comments, rating) VALUES ($id_user, $id_product, '$comments', '$rating')" ;
    mysqli_query($conn, $sql);


    if (mysqli_query($conn, $sql)) {

        echo "<br/><br/><span>Updated successfully...!!</span>";
    } else {
        echo "Error: CAN'T UPDATE  <br> DETAILS:" . $sql . "<br>" . mysqli_error($conn);
    }


}

	function remove_from_cart($id_product, $id_user){
	    global $conn;
	    $sql= "DELETE FROM cart WHERE ID_users=$id_user AND id_product=$id_product";
	    if (mysqli_query($conn, $sql)){
	         echo "<br/><br/><span>Deleted successfully...!!</span>";
            } else {
                    echo "Error: CAN'T DELETE  <br> DETAILS:" . $sql . "<br>" . mysqli_error($conn);
                    }


    }

	function update_cart($quantity){
	    global $conn;

	    $sql ="INSERT INTO cart (quantity) VALUES ($quantity) ";
        if (mysqli_query($conn, $sql)){
            echo "<br/><br/><span>Updated successfully...!!</span>";
        } else {
            echo "Error: CAN'T UPDATE  <br> DETAILS:" . $sql . "<br>" . mysqli_error($conn);
        }

    }

function delete($id){
    global $conn;



    $sql = "DELETE FROM users WHERE ID_users='$id'";



    if (mysqli_query($conn, $sql)) {

        echo "<br/><br/><span>Deleted successfully...!!</span>";
    } else {
        echo "Error: CAN'T DELETE  <br> DETAILS:" . $sql . "<br>" . mysqli_error($conn);
    }

}
	function delete_product($id)
    {
        global $conn;
        $sql = "DELETE FROM products WHERE id_product='$id'";


        if (mysqli_query($conn, $sql)) {

            echo "<br/><br/><span>Deleted successfully...!!</span>";
        } else {
            echo "Error: CAN'T DELETE  <br> DETAILS:" . $sql . "<br>" . mysqli_error($conn);
        }
    }






?>