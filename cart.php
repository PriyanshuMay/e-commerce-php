<?php
  session_start();
  include('essentials/config.php');
  include('boilerplate.php');
  include('navbar.php');
?>
<script src="js/vendor/modernizr.js"></script>
<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script>
  $(document).foundation();
</script>
<style type="text/css">

  .price_dis{
  text-decoration: line-through; 
  font-size: 12px;
}

        .securepayment{
          font-family: "adihausregular",Helvetica,Verdana,sans-serif;
          font-size: 14px;
          line-height: 20px;
          color: #000;
          font-weight: normal;
          padding-top: 0px;
          margin-top: 4px;
        }
        .order-sum{
          background-color: #f2f3f4;
          width: auto;
          height: auto;


        }
        .inner-order{
          background-color: #fff;
           margin-bottom: 20px;

        }
        .shipping_inner{
          font-size: 14px;
          text-align: left;
          padding-top: 0;
          background-color: #fff;
          margin-bottom: 20px;
        }
        .shipping_inner_style{
           padding-left: 8px;
          margin-left: 10px;
        }
        .shipping_inner b{
  display: block;
  font-size: 14px;
  margin-bottom: 5px;
  color: #34495e;
}

b{
  color: #5d6d7e;
  
}

h3{
  text-align: center;
  color: #2e405e;
}
.ship{
            width: 245px;
            height: 273px;
           border-radius: 4px;
           border : 1px solid #aed6f1; 
         }

 
</style>
<br>
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <h2 style="text-align: center; color: #5d6d7e; font-weight: bold;">Shopping Cart</h2>

        <?php
           
           $variant = $_SESSION['variant'];

           
         

          if (isset($_SESSION['cart'])) {
              $total = 0;
              $itemqty = 0;
            
              echo '<table class="table">';
              echo '<tr>';
              echo '</tr>';
              foreach ($_SESSION['cart'] as $product_id => $quantity) {
                  $result = "SELECT  name, qty, price,file FROM product WHERE id = $product_id";
                  $run = mysqli_query($mysqli, $result);

                  $email=$_SESSION['email'];


            

                  if ($run) {
                      while ($obj = mysqli_fetch_object($run)) {
                          $cost = $obj->price * $quantity; //work out the line cost

                          $total = $total + $cost; //add to the total cost
                          $itemqty = $itemqty+$quantity;

                          $color = $_SESSION['color'];
                          $size = $_SESSION['size'];

                          $result_c = mysqli_query($mysqli, "SELECT * FROM attribute where attr_id='$color'");
                          $row_c = mysqli_fetch_assoc($result_c);
                          $attr = $row_c['attr_id'];
                          $attr_img = $row_c['attr_img'];
                          $value_c = $row_c['value'];

                          $result_s = mysqli_query($mysqli, "SELECT * FROM attribute where attr_id='$size'");
                          $row_s = mysqli_fetch_assoc($result_s);
                          $attr = $row_s['attr_id'];
                          $value_s = $row_s['value'];

             
                          $result_cart = mysqli_query($mysqli, "SELECT * FROM cart where product_id='$product_id'");
                          $row_cart = mysqli_fetch_assoc($result_cart);
                          $cart_id = $row_cart['cart_id'];
                          $col = $row_cart['color'];
                          $siz = $row_cart['size'];
                          $pp_id = $row_cart['product_id'];

                          $sql_dis = mysqli_query($mysqli, "SELECT * FROM discount 
                            LEFT JOIN product ON discount.product_id = product.id
                            WHERE product.id = '$product_id'");
                          $result_dis = mysqli_fetch_assoc($sql_dis);
                          $percentage = $result_dis['percentage'];
                          $discount_id = $result_dis['discount_id'];



                
                          echo '<tr>';
                          echo '<td><img src="admin/file/'.$obj->file.'" width="100" height="140" align="right" align="right" alt=""></td>';
                
                          echo '<td><b style="color: #4d5656;font-size:12px;" >'.$obj->name.'</b>';
                          if ($pp_id == 0) {
                              echo '<p style="font-size:12px;" >Color: '.$value_c.'</p>';
                              echo '<p style="font-size:12px;">Size: '.$value_s.' </p>';
                          } else {
                              echo '<p style="font-size:12px;" >Color: '.$col.'</p>';
                              echo '<p style="font-size:12px;">Size: '.$siz.' </p>';
                          }
                          echo '<a href="" style="font-size:12px;">Edit</a>';
                          echo '<a href="delete-cart-detail.php?id='.$product_id.'" style="font-size:12px; margin-left: 12px;">Delete</a>';
                          echo '<a href="" style="font-size:12px; margin-left: 12px;">Move To Wishlist</a>';
                          echo '</td>';
              
       
               
                          echo '<td>Product ID&emsp;'.$product_id.'</td>';
                          echo '<td>'.$quantity.'&nbsp;<a class="button [secondary success alert]" style="padding:5px;" href="update-cart.php?action=add&id='.$product_id.'">+</a>&nbsp;<a class="button alert" style="padding:5px;" href="update-cart.php?action=remove&id='.$product_id.'">-</a></td>';
                          if ($discount_id == 0) {
                              echo '<td>&#x20B9;&nbsp;'.$cost.'</td>';
                          } else {
                              $selling_price = $obj->price-($obj->price*($percentage/100));
                              $selling_dis = $selling_price * $quantity;
                              echo '<td>&#x20B9;&nbsp; '.$selling_dis.'<strong class="price_dis"> &#x20B9;&nbsp;'.$cost.'</strong></td>';
                          }
                
                          echo '</tr>';
                      }

                      if ($email == 0) {
                          $sql2 = "INSERT INTO cart(customer,product_id,color,size,created_date)
                   VALUES('guest','$product_id','$value_c','$value_s',NOW())";

                          $run2=mysqli_query($mysqli, $sql2);
                      } else {
                          $sql2 = "INSERT INTO cart(customer,product_id,color,size,created_date)
                   VALUES('$email','$product_id','$value_c','$value_s',NOW())";

                          $run2=mysqli_query($mysqli, $sql2);
                      }
                  }
              }
              echo '<tr>';
              echo '<td colspan="7" align="right">
          <a href="delete-cart.php" class="button alert">Empty Cart</a>&nbsp;<a href="product.php" class="button [secondary success alert]">Continue Shopping </a>';
              echo '<a style="clear:both; background: linear-gradient(to right, #025F8E, #0286CD) repeat scroll 0% 0% transparent; border: none; color: #fff; font-size: 1em; padding: 10px;" href="checkout.php" >Checkout
          <span class="fa fa-chevron-circle-right"></span></a>';
        

              echo '</td>';

              echo '</tr>';
              echo '</table>';
          } else {
            echo "<div class='alert alert-danger'><span class='fa fa-exclamation'> You have no items in your shopping cart.</span></div>";
        }        
          ?>
      </div>
      <div class="col-sm-4">
         <div class="order-sum">
        <div class="container">
          <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-8">
              <div class="inner-order">
  <?php
      if (isset($_SESSION['cart'])) {
          $total = 0;
          $itemqty = 0;
           
          
          foreach ($_SESSION['cart'] as $product_id => $quantity) {
              $result = "SELECT  name, qty, price,file FROM product WHERE id = $product_id";
              $run = mysqli_query($mysqli, $result);
               
              if ($run) {
                  while ($obj = mysqli_fetch_object($run)) {
                      $cost = $obj->price * $quantity; //work out the line cost
                $total = $total + $cost; //add to the total cost
                $itemqty = $itemqty+$quantity;
                  }
              }
          }

          echo '<table class="table">';
          echo '<tr>';
          echo '<td>Product total</td>';
          echo '<td></td>';
          echo '<td></td>';
          echo '<td></td>';
          echo '<td>$'.$total.'</td>';
          echo '</tr>';
          echo '<tr>';
          echo '<td>Quantiy</td>';
          echo '<td></td>';
          echo '<td></td>';
          echo '<td></td>';
          echo '<td>'.$itemqty.'</td>';
          echo '</tr>';
          echo '<tr>';
          echo '<td>TOTAL</td>';
          echo '<td></td>';
          echo '<td></td>';
          echo '<td></td>';
          echo '<td><strong>&#x20B9;&nbsp;'.$total.'</strong></td>';
          echo '</tr>';
          echo '</table>';
      }
        ?>
        </div>
        
          </div>

        </div>

      </div>

        </div>
  </div>
</div>
</div>
<?php include('footer.php'); ?> 
  </body>
</html>
