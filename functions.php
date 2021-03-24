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

    $quantity= 1;


    $pet_name="";
    $species="";
    $food="";
    $pet_img="";




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



function rating()
{
    global $conn;
    if (isset($_GET['ID'])) {
        $sql = mysqli_query($conn, "SELECT AVG(rating) as AVGRATE FROM review WHERE  id_product='" . $_GET['ID'] . "'");
    }

    $row = mysqli_fetch_array($sql);

    $AVGRATE=$row['AVGRATE'];
    echo $AVG= round($AVGRATE,1);
    return  $AVG;
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



	function add_to_cart( $id_user, $id_product) {
        global $conn;


            $sql = "INSERT INTO cart (ID_users, id_product) VALUES ($id_user, $id_product)";


            if (mysqli_query($conn, $sql)) {

                echo "<br/><br/><span>Updated successfully...!!</span>";
            } else {
                echo "Error: CAN'T DELETE  <br> DETAILS:" . $sql . "<br>" . mysqli_error($conn);
            }


    }

function add_comment( $id_user, $id_product) {
    global $conn, $errors;


    $comments=e($_POST['comments']);
    $rating =  e($_POST['rating']);


    $sql = "INSERT INTO review (ID_users, id_product, comments, rating) VALUES ('$id_user', '$id_product', '$comments', '$rating')" ;



    if (mysqli_query($conn, $sql)) {

        echo "<br/><br/><span>Updated successfully...!!</span>";
    } else {
        echo "Error: CAN'T UPDATE  <br> DETAILS:" . $sql . "<br>" . mysqli_error($conn);
    }


}
function add_pet( $id_user) {
    global $conn;


    $pet_name=e($_POST['pet_name']);
    $species=e($_POST['species']);
    $food=e($_POST['food']);
    $pet_img=e($_POST['pet_img']);





    $sql = "INSERT INTO pet (ID_users, pet_name, species, food, pet_img) VALUES ('$id_user', '$pet_name', '$species', '$food', '$pet_img')" ;



    if (mysqli_query($conn, $sql)) {

        echo "<br/><br/><span>Updated successfully...!!</span>";
    } else {
        echo "Error: CAN'T UPDATE  <br> DETAILS:" . $sql . "<br>" . mysqli_error($conn);
    }


}


function comment()
{
global $conn;

    $sql12 = "SELECT word FROM dirtywords WHERE languages ='en'";
    $result2 = mysqli_query($conn, $sql12);
    $words=array();
    while($row = $result2->fetch_assoc()) {
        array_push($words, $row['word'] );
    }

    if (isset($_GET['ID'])) {
        $sql = "SELECT comments FROM review WHERE  id_product='" . $_GET['ID'] . "'";

    }
    $result = mysqli_query($conn, $sql);
    $dirty_word=array();

    while($row = $result->fetch_assoc()) {
        $rijeci = explode(" ", $row['comments']);
        foreach ($rijeci as $rijec){
            {
                array_push($dirty_word, $rijec);
            }
    }}
 foreach ($dirty_word as $dirty_words){
     foreach ($words as $word){

         if ($dirty_words==$word) {
             $dirty_words = "***";
         }

     }
     echo $dirty_words;
     echo " ";
 }

}




function pet_profile()
{
    global $conn;
    if (isset($_SESSION['user'])) {
        $sql ="SELECT * FROM pet INNER JOIN users ON users.ID_users=pet.ID_users  WHERE pet.ID_users='" . $_SESSION ["user"]['ID_users'] . "'";
    }
    $result = mysqli_query($conn,$sql);
    ?>
    <section class="shoping-cart spad">
    <div class="container">
    <div class="row">
    <div class="col-lg-12">
    <div class="shoping__cart__table">

    <table>
                        <thead>
                        <tr>
                            <th class="shoping__product">Your pets</th>
                            <th>Name</th>
                            <th>Species</th>
                            <th>Food</th>
                            <th>Delete</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        if ($result->num_rows > 0){

                        while($row = $result->fetch_assoc()) {
                        ?>
                        <tr>

                            <td class="shoping__cart__item">
                                <?php  echo '<img src="../img/'.$row["pet_img"].'. "  class="featured__item__pic set-bg"  >'; ?> </a>
                            </td>

                            <td class="shopping__cart__name">
                                <h5><?php echo $row['pet_name'];  ?></h5>
                            </td>
                            <td>
                                <?php echo $row['species']; ?>
                            </td>
                            <td class="shoping__cart__price">
                                <?php echo $row['food'];  ?>
                            </td>
                            <td>
                                <?php echo "<a href='profile.php?ID=". $row["pet_id"] ."' ><button type=\"button\" class=\"btn btn-danger btn-sm\">X</button></a> "; ?>



                            </td>


                        </tr>
                        </tbody>
                            <?php }
                        } else { echo "0 results"; } ?>
                    </table>

    </div>
    </div>
    </div>
    </div>


<?php } ?>

<?php
if (isset($_GET['ID'])) {
    remove_pet($_GET['ID']);

}
 ?>
<?php
	function slider(){
	    global $conn;

        $sql ="SELECT products.img, review.rating
FROM review
INNER JOIN products  ON products.id_product =review.id_product
 ORDER BY rating ASC";

        $result=mysqli_query($conn, $sql);
        while($row=$result->fetch_assoc()) {
            echo '<img src="../img/' . $row['img'] . '. "  class="categories__item set-bg""  >';
        }
    }
    function slider_all_product(){
        global $conn;

        $sql ="SELECT * FROM products WHERE quantity >0";

        $result=mysqli_query($conn, $sql);
        while($row=$result->fetch_assoc()) {
            echo '<img src="../img/' . $row['img'] . '. "  class="categories__item set-bg""  >';
        }
    }

	function remove_from_cart($id_user, $id_product){
	    global $conn;
	    $sql= "DELETE FROM cart WHERE ID_users=$id_user AND id_product=$id_product";
	    if (mysqli_query($conn, $sql)){
	         echo "<br/><br/><span>Deleted successfully...!!</span>";
            } else {
                    echo "Error: CAN'T DELETE  <br> DETAILS:" . $sql . "<br>" . mysqli_error($conn);
                    }


    }
function delete_cart_for_user($id_user){
	    global $conn;


    $query ="SELECT products.id_product, product.quantity, cart.quantity
FROM cart
INNER JOIN products  ON products.id_product =cart.id_product
INNER JOIN users ON users.ID_users=cart.ID_users  WHERE cart.ID_users=$id_user";
    $test = $conn->query($query);
    $sum= 0;
    while($num = $test->fetch_assoc()) {
        $sum =$num['product']['quantity']-$num['quantity'];
    }
    $sql3 ="UPDATE products SET quantity=$sum ";
    mysqli_query($conn,$sql3);

	    $sql="DELETE FROM cart WHERE ID_users=$id_user";
    if (mysqli_query($conn, $sql)){
        echo " <h2>Your order has been received.</h2>
                    <h2>Thank you for buying from us. </h2>";
    } else {
        echo "Error: CAN'T DELETE  <br> DETAILS:" . $sql . "<br>" . mysqli_error($conn);
    }


}
function update_quantity($id_product, $quantity){
    global $conn;




    $sql ="UPDATE products SET quantity=(quantity-'$quantity') WHERE  id_product=$id_product ";

    if (mysqli_query($conn, $sql)){
        echo "<br/><br/><span>Updated successfully...!!</span>";
    } else {
        echo "Error: CAN'T UPDATE  <br> DETAILS:" . $sql . "<br>" . mysqli_error($conn);
    }

}
function remove_pet(  $id_pet){
    global $conn;
    $sql= "DELETE FROM pet WHERE  pet_id=$id_pet ";
    if (mysqli_query($conn, $sql)){
        echo "<br/><br/><span>Deleted successfully...!!</span>";
    } else {
        echo "Error: CAN'T DELETE  <br> DETAILS:" . $sql . "<br>" . mysqli_error($conn);
    }


}

	function update_cart($id_user, $id_product, $quantity){
	    global $conn;


	    $sql ="UPDATE cart SET quantity='$quantity' WHERE ID_users=$id_user AND id_product=$id_product ";

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