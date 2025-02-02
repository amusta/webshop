<?php
include ('connection.php');
include('functions.php');


$sql ="SELECT products.id_product,  products.img, products.name, products.price, cart.quantity
FROM cart
INNER JOIN products  ON products.id_product =cart.id_product
INNER JOIN users ON users.ID_users=cart.ID_users  WHERE cart.ID_users='" . $_SESSION ["user"]['ID_users'] . "'";
$result = $conn->query($sql);


$query ="SELECT products.id_product,  products.img, products.name, products.price, cart.quantity
FROM cart
INNER JOIN products  ON products.id_product =cart.id_product
INNER JOIN users ON users.ID_users=cart.ID_users  WHERE cart.ID_users='" . $_SESSION ["user"]['ID_users'] . "'";
$test = $conn->query($query);
$sum= 0;
while ($num = mysqli_fetch_assoc ($test)) {
    $sum += $num['quantity']*$num['price'];
}


if(!empty($_REQUEST['term'])){
    $term=$_REQUEST['term'];

    $sql= "SELECT * FROM products WHERE name LIKE '%" . $term . "%' ";
    $result=$conn->query($sql);





}

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="img/logo1.jpg" alt=""></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>

        </ul>

    </div>
    <div class="humberger__menu__widget">
        <?php if (isLoggedIn()){ ?>
            <div class="header__top__right__auth">
                <a href="profile.php"><i class="fa fa-user-circle"></i>Profile</a>
            </div>
            <a href="logout.php"><i class="fa fa-user"></i> Logout</a>

            <?php    if(isset($_SESSION['user'])) { } ?>
        <?php } else { ?>

            <a href="login.php"><i class="fa fa-user"></i> Login</a>

        <?php } ?>

        <?php if (isAdmin()){ ?>
            <a href="login/admin/home.php" class="button">AdminView</a>
        <?php } ?>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="shop-grid.php">Shop</a></li>
            <li><a href="#">Pages</a>
                <ul class="header__menu__dropdown">

                    <li><a href="shoping-cart.php">Shoping Cart</a></li>
                    <li><a href="checkout.php">Check Out</a></li>
                </ul>
            </li>

            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">

    </div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> autosender101@gmail.com</li>
            <li>Free Shipping for all Order of $99</li>
        </ul>
    </div>
</div>
<!-- Humberger End -->

<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i>autosender101@gmail.com</li>
                            <li>Free Shipping for all Order of $99</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header__top__right">
                        <?php if (isLoggedIn()){ ?>

                            <div class="header__top__right__auth">

                                <a href="profile.php"><i class="fa fa-user-circle"></i>Profile</a>
                            </div>
                            <a href="logout.php"><i class="fa fa-user"></i> Logout</a>

                            <?php    if(isset($_SESSION['user'])) { } ?>
                        <?php } else { ?>

                            <a href="login.php"><i class="fa fa-user"></i> Login</a>

                        <?php } ?>


                        <?php if (isAdmin()){ ?>
                            <a href="login/admin/home.php" class="button">AdminView</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="index.php"><img src="img/logo1.jpg" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li class="active"><a href="shop-grid.php">Shop</a></li>
                        <li><a href="#">Pages</a>
                            <ul class="header__menu__dropdown">

                                <li><a href="shoping-cart.php">Shoping Cart</a></li>
                                <li><a href="checkout.php">Check Out</a></li>
                            </ul>
                        </li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>

                    </ul>

                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->

<!-- Hero Section Begin -->
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All pets</span>
                    </div>
                    <ul>
                        <li><a href="dog.php">Dog</a></li>
                        <li><a href="cat.php">Cat</a></li>
                        <li><a href="bird.php">Bird</a></li>
                        <li><a href="small_animals.php">Small animals</a></li>
                        <li><a href="reptile.php">Raptiles</a></li>
                        <li><a href="fish.php">Fish</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <div class="hero__search__categories">
                                All Categories
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" placeholder="What do yo u need?" name="term">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+65 11.188.888</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- Hero Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/hero/pet.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Checkout</h2>
                        <div class="breadcrumb__option">
                            <a href="index.php">Home</a>
                            <span>Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">


            <div class="checkout__form">
                <table>
                    <thead>
                    <tr>
                        <th class="shoping__product">Products</th>
                        <th class="shoping__cart__price">Price             </th>
                        <th class="shoping__cart__price">Quantity</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    while($row = $result->fetch_assoc()) { ?>


                        <tr>

                            <td class="shoping__cart__item">

                                <?php  echo '<img src="../img/'.$row["img"].'. "  class="featured__item__pic set-bg"  >'; ?>
                                <h5><?php echo $row['name']; ?></h5>
                            </td>

                            <td class="shoping__cart__price">
                                <?php echo $row['price'];  ?> $
                            </td>

                             <td class="shoping__cart__price">

                                <?php echo $row['quantity']; ?>

                            </td>

                        </tr>
                    <?php  } ?>


                    </tbody>

                </table>
            </div>
            </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Your Order</h4>


                                <div class="checkout__order__total">Total <span><?php echo $sum; ?></span></div>


                        <a href ="place_order.php"
                                <button type="submit" class="site-btn">PLACE ORDER</button></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="index.php"><img src="img/logo1.jpg" alt=""></a>
                        </div>
                        <ul>
                            <li>Address: 60-49 Road 11378 New York</li>
                            <li>Phone: +65 11.188.888</li>
                            <li>Email: hello@colorlib.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                    <div class="footer__widget">
                        <h6>Useful Links</h6>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">About Our Shop</a></li>
                            <li><a href="#">Secure Shopping</a></li>
                            <li><a href="#">Delivery infomation</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Our Sitemap</a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Who We Are</a></li>
                            <li><a href="#">Our Services</a></li>
                            <li><a href="#">Projects</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Innovation</a></li>
                            <li><a href="#">Testimonials</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="footer__widget">
                        <h6>Join Our Newsletter Now</h6>
                        <p>Get E-mail updates about our latest shop and special offers.</p>
                        <form action="#">
                            <input type="text" placeholder="Enter your mail">
                            <button type="submit" class="site-btn">Subscribe</button>
                        </form>
                        <div class="footer__widget__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text"><p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p></div>
                        <div class="footer__copyright__payment"><img src="img/payment-item.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

 

</body>

</html>