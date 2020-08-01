<?php
   session_start();
   require_once('essentials/config.php');
   include('essentials/function.php');
?>

<?php

   $id = $_GET['id'];
   $result = mysqli_query($connect, "SELECT * FROM product LEFT JOIN section 
                                   ON section.cat_id = product.section WHERE product.id=$id");
   $row2 = mysqli_fetch_assoc($result);
   $cat_id = $row2['cat_id'];
   $cat_name = $row2['cat_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php

$id = $_GET['id'];
$result = mysqli_query($connect, "SELECT * FROM product WHERE id=$id");
$product = mysqli_fetch_assoc($result);
?>   
    <meta name="description" content="<?php echo $product['description']; ?>">
    <meta name="keywords" content="ecommerce, php, wholesale, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $product['name']; ?></title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/themify-icons.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
<?php  include('navbar.php'); ?>
<?php
   $id = $_GET['id'];

   if (!$id) {
       echo "<script>
    document.location='home.php';
    </script>";
   }

   $result = mysqli_query($connect, "SELECT * FROM product WHERE id=$id");
   $row = mysqli_fetch_assoc($result);
   $product_id = $row['id'];
   $section = $row['section'];
   $qty = $row['qty'];

?>

    <!-- Product Shop Section Begin -->
    <section class="product-shop spad page-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="product-pic-zoom">
                                <img class="product-big-img" src="uploads/<?php echo $row2['file'] ?>" alt="main">
                            </div>
                            <div class="product-thumbs">
                                <div class="product-thumbs-track ps-slider owl-carousel">
                                <div class="pt active" data-imgbigurl="uploads/<?php echo $row2['file'] ?>"><img
                                            src="uploads/<?php echo $row2['file'] ?>" alt=""></div>
                                <?php
                      $sql2 = "SELECT * FROM gallery
                              WHERE product_id = $id";
                      $run = mysqli_query($connect, $sql2);
                    while ($row2 = mysqli_fetch_assoc($run)):
                    ?>
                    <div class="pt active" data-imgbigurl="uploads/gallery/<?php echo $row2['image'] ?>">
                    <img src="uploads/gallery/<?php echo $row2['image'] ?>" alt="gallery"></div>
                              
                                            <?php endwhile; ?> 
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="product-details">
                                <div class="pd-title">
                                    <span><?php echo $product['code'] ?></span>
                                    <h3><?php echo $product['name'] ?></h3>
                                </div>
                                <div class="pd-desc">
                                    <p><?php echo $product['name'] ?></p>
                                    <h4>&#x20B9;&nbsp; <?php echo $product['cost'] ?><span>
                                    &#x20B9;&nbsp; <?php echo $product['MRP'] ?></span></h4>
                                </div>

                                <div class="pd-color">
                                   
                                    <div class="pd-color-choose">
                               
                                <div class="custom-radio-button">
 
  
<form method="post" action="adding-to-cart.php" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $id?>">

  <?php

     $sql ="SELECT DISTINCT a.*,p.color,p.product_id FROM variant p
            LEFT JOIN attribute a
            ON p.color = a.attr_id
            WHERE p.product_id = '$id'";
            $ret = mysqli_query($connect, $sql);
           $num_results=mysqli_num_rows($ret);
           for ($i=0;$i<$num_results;$i++) {
               $row=mysqli_fetch_array($ret);
               ?>

                <input type="radio" id="color-<?php echo $row["value"]; ?>" name="radio_color" value="<?php echo $row["value"]; ?>" >
               <label for="color-<?php echo $row["value"]; ?>">
                 <span>
                 </span>
               </label>
            &nbsp;
               <style>

.custom-radio-button div {
  display: inline-block;
}
.custom-radio-button input[type="radio"] {
  display: none;
}
.custom-radio-button input[type="radio"] + label {
  color: #333;
  font-family: Arial, sans-serif;
  font-size: 14px;
}
.custom-radio-button input[type="radio"] + label span {
  display: inline-block;
  width: 35px;
  height: 35px;
  margin: -1px 4px 0 0;
  vertical-align: middle;
  cursor: pointer;
  border-radius: 50%;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.33);
  background-repeat: no-repeat;
  background-position: center;
  text-align: center;
  line-height: 44px;
}
.custom-radio-button input[type="radio"] + label span img {
  opacity: 0;
  transition: all .4s ease;
}
.custom-radio-button input[type="radio"]#color-<?php echo $row["value"]; ?> + label span {
  background-color: <?php echo $row["value"]; ?>;
}
.custom-radio-button input[type="radio"]:checked + label span {
  opacity: 1;
  background: url("https://www.positronx.io/wp-content/uploads/2019/06/tick-icon-4657-01.png")
    center center no-repeat;
  width: 35px;
  height: 35px;
  display: inline-block;
}
</style>
               <?php
           }
?>
</div></div></div>
                                <div class="pd-size-choose">
                                <?php
            $result = "SELECT * FROM variant where product_id = $id";
            $sql = mysqli_query($connect, $result);
            $row = mysqli_fetch_assoc($sql);
       

                                    $sql ="SELECT DISTINCT a.*,p.size,p.product_id FROM variant p
                                     LEFT JOIN attribute a
                                     ON p.size = a.attr_id
                                     WHERE p.product_id = '$id'";

                               $result = mysqli_query($connect, $sql);

                               while ($row = mysqli_fetch_assoc($result)) {
                                   echo'<div class="sc-item">
 <input type="radio" name="size" value=\''.$row["value"].'\' id="'.$row["value"].'">
 <label for="'.$row["value"].'">'.$row['value'].'</label>
</div>';
                               }  ?>
         <?php
      $s = "SELECT * FROM product WHERE id = '$id'";
      $r = mysqli_query($connect, $s);
      $row_r = mysqli_fetch_assoc($r);
        $product_id = $row_r['id'];
        $customer = $_SESSION['email'];

    
      $sql5 = "SELECT * FROM customer WHERE email = '$customer'";
      $run5 = mysqli_query($connect, $sql5);
      $row5 =mysqli_fetch_assoc($run5);
      $customer_id = $row5['id'];
      $customer_name = $row5['name'];
      
      $sql_fav = "SELECT * FROM wishlist WHERE customer_id ='$customer_id' AND product_id = '$product_id'";
      $run_fav = mysqli_query($connect, $sql_fav);
      $row_fav = mysqli_fetch_assoc($run_fav);
      $fav = $row_fav['fav_id'];
       
        ?>

                              <p>  <?php if ($product['qty'] == 0) {
            echo "<span class='badge badge-danger'>Sold Out</span>";
        } else {
            if ($product['qty'] < 10) {
                echo "<span class='badge badge-info'>Few Left</span>";
            } else {
                echo "<span class='badge badge-success'>In Stock</span>";
            }
        }

                          ?> &emsp;
                           <?php  if ($fav == null) { ?>
         
                            <a href="add-wishlist.php?id=<?php echo $row_r['id']; ?>" class="heart-icon"><i class="icon_heart_alt"></i></a>
     <?php } else { ?>
        <a href="remove-wishlist.php?id=<?php echo $row_r['id']; ?>" class="heart-icon"><i class="icon_heart"></i></a>    
     <?php } ?></p>


<?php
              $sql ="SELECT DISTINCT a.*,p.color,p.product_id FROM variant p
                     LEFT JOIN attribute a
                     ON p.size = a.attr_id
                     WHERE p.product_id = '$id'";

             $result = mysqli_query($connect, $sql);

             while ($row = mysqli_fetch_assoc($result)) ?>

      
<?php if ($qty > 0) { ?>

    <input type="submit" name="submit" value="Add To Cart"  style="clear:both;  border: none;" class="primary-btn pd-cart">
              </form>
           
      <?php } else { ?>
      </form>
     
        <?php

$id = $_GET['id'];
$result = mysqli_query($connect,"SELECT * FROM product WHERE id=$id");
$row = mysqli_fetch_assoc($result);

?>
  <button data-toggle="modal" data-target="#view-modal" 
  data-id="<?php echo $row['id']; ?>" id="getUser" style="clear:both; background: #48c9b0; 
  border: none; color: #fff; font-size: 14px; padding: 10px;cursor: pointer;">Notify me</button>
  <?php } ?>

    <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
          <div class="modal-dialog"> 
               <div class="modal-content"> 
               
                    <div class="modal-header"> 
                     <h4 class="modal-title">
                          
                         </h4> 
                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                         
                    </div> 
                    <div class="modal-body"> 
                    
                        <div id="modal-loader" style="display: none; text-align: center;">
                         <img src="ajax-loader.gif">
                        </div>
                                                 
                        <div id="dynamic-content">
                        
                        </div>
                          
                     </div> 
                     
                     
              </div> 
           </div>
    </div>

<script>
$(document).ready(function(){

$(document).on('click', '#getUser', function(e){
 
 e.preventDefault();
 
 var uid = $(this).data('id');   
 
 $('#dynamic-content').html('');
 $('#modal-loader').show(); 
 $.ajax({
   url: 'getemail.php',
   type: 'POST',
   data: 'id='+uid,
   dataType: 'html'
 })
 .done(function(data){
   console.log(data);  
   $('#dynamic-content').html('');    
   $('#dynamic-content').html(data); 
   $('#modal-loader').hide();
 })
 .fail(function(){
   $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
   $('#modal-loader').hide();
 });
 
});

});

</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Shop Section End -->

    <!-- Related Products Section End -->
    <div class="related-products spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Similar Products</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="img/products/women-1.jpg" alt="">
                            <div class="sale">Sale</div>
                            <div class="icon">
                                <i class="icon_heart_alt"></i>
                            </div>
                            <ul>
                                <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                <li class="quick-view"><a href="#">+ Quick View</a></li>
                                <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="catagory-name">Coat</div>
                            <a href="#">
                                <h5>Pure Pineapple</h5>
                            </a>
                            <div class="product-price">
                                $14.00
                                <span>$35.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="img/products/women-2.jpg" alt="">
                            <div class="icon">
                                <i class="icon_heart_alt"></i>
                            </div>
                            <ul>
                                <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                <li class="quick-view"><a href="#">+ Quick View</a></li>
                                <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="catagory-name">Shoes</div>
                            <a href="#">
                                <h5>Guangzhou sweater</h5>
                            </a>
                            <div class="product-price">
                                $13.00
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="img/products/women-3.jpg" alt="">
                            <div class="icon">
                                <i class="icon_heart_alt"></i>
                            </div>
                            <ul>
                                <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                <li class="quick-view"><a href="#">+ Quick View</a></li>
                                <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="catagory-name">Towel</div>
                            <a href="#">
                                <h5>Pure Pineapple</h5>
                            </a>
                            <div class="product-price">
                                $34.00
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="img/products/women-4.jpg" alt="">
                            <div class="icon">
                                <i class="icon_heart_alt"></i>
                            </div>
                            <ul>
                                <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                <li class="quick-view"><a href="#">+ Quick View</a></li>
                                <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="catagory-name">Towel</div>
                            <a href="#">
                                <h5>Converse Shoes</h5>
                            </a>
                            <div class="product-price">
                                $34.00
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Related Products Section End -->

    <!-- Partner Logo Section Begin -->
    <div class="partner-logo">
        <div class="container">
            <div class="logo-carousel owl-carousel">
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="img/logo-carousel/logo-1.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="img/logo-carousel/logo-2.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="img/logo-carousel/logo-3.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="img/logo-carousel/logo-4.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="img/logo-carousel/logo-5.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Partner Logo Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer-left">
                        <div class="footer-logo">
                            <a href="#"><img src="img/footer-logo.png" alt=""></a>
                        </div>
                        <ul>
                            <li>Address: 60-49 Road 11378 New York</li>
                            <li>Phone: +65 11.188.888</li>
                            <li>Email: hello.colorlib@gmail.com</li>
                        </ul>
                        <div class="footer-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1">
                    <div class="footer-widget">
                        <h5>Information</h5>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Checkout</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Serivius</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="footer-widget">
                        <h5>My Account</h5>
                        <ul>
                            <li><a href="#">My Account</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Shopping Cart</a></li>
                            <li><a href="#">Shop</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="newslatter-item">
                        <h5>Join Our Newsletter Now</h5>
                        <p>Get E-mail updates about our latest shop and special offers.</p>
                        <form action="#" class="subscribe-form">
                            <input type="text" placeholder="Enter Your Mail">
                            <button type="button">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-reserved">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copyright-text">
                            Made by pryanshumay
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/jquery.dd.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>