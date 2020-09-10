<?php
include('boilerplate.php');

if (!$customer_id) {
   echo '<script>
location.href="login.php"
</script>';
}
if (!$_GET['id']) {
   echo '<script>
    location.href="error.php"
    </script>';
}

$order_id = $_GET['id'];

?>
<section class="borderless-table carousel-info">
   <div class="container">
      <div class="row">

         <?php
         $orders = mysqli_query($connect, "SELECT * FROM orders WHERE customer_id = '$customer_id' and order_id = '$order_id'");
         $order_prop = mysqli_fetch_assoc($orders);
         ?>
         <div class="col-lg-12 mx-auto my-3">
            <div class="container">
               <div class="row">
                  <div class="col-lg-6">
                     <table class="table table-borderless">
                        <tr>
                           <th>Name</th>
                           <td><span class="badge badge-light"><?php echo $order_prop['full_name'] ?></span></td>
                        </tr>
                        <tr>
                           <th>Email</th>
                           <td><span class="badge badge-light"><?php echo $order_prop['email'] ?></span></td>
                        </tr>
                        <tr>
                           <th>Phone</th>
                           <td><span class="badge badge-light"><?php echo $order_prop['phone'] ?></span></td>
                        </tr>
                        <tr>
                           <th>Order placed at</th>
                           <td><span class="badge badge-light"><?php echo $order_prop['created_date'] ?></span></td>
                        </tr>
                        <tr>
                           <th>Order updated at</th>
                           <td><span class="badge badge-light"><?php echo $order_prop['modified_date'] ?></span></td>
                        </tr>
                        <tr>
                           <th>Quantity</th>
                           <td><span class="badge badge-info"><?php echo $order_prop['total_qty'] ?> pcs</span></td>
                        </tr>
                        <tr>
                           <th>Total</th>
                           <td><span class="badge badge-success">&#x20B9;&nbsp;<?php echo $order_prop['total_amt'] ?></span>
                           <a href="invoice.php?id=<?php echo $order_id ?>" class="login-wrapper-footer-text text-reset">Invoice</a>
                        </td>
                        </tr>
                     </table>
                  </div>
                  <div class="col-lg-6">
                     <table class="table table-borderless">
                        <?php if ($order_prop['store_id'] == 0) { ?>
                           <tr>
                              <th>Order Status</th>
                              <td>
                                <?php if ($order_prop['status'] == 0) { ?>
                                    <span class="badge  badge-danger">Cancelled</span>

                                <?php } else if ($order_prop['status'] == 1) { ?>
                                    <span class="badge  badge-warning">Placed</span>

                                <?php } else if ($order_prop['status'] == 2) { ?>
                                    <span class="badge  badge-success">Approved</span>

                                <?php } else if ($order_prop['status'] == 3) { ?>
                                    <span class="badge  badge-info">Deliverd</span>

                                <?php } else if ($order_prop['status'] == 4) { ?>
                                    <span class="badge  badge-success">Requested Refund</span>

                                <?php } else if ($order_prop['status'] == 5) { ?>
                                    <span class="badge  badge-danger">Refunded</span>

                                <?php } else {  ?>
                                    <span class="badge  badge-danger">Error</span>
                                <?php  } ?>
                            </td>
                           </tr>
                           <tr>
                              <th>Payment Type</th>
                              <td><span class="badge badge-light"><?php echo $order_prop['payment_type'] ?></td>
                           </tr>
                           <tr>
                              <th>Delivery Type</th>
                              <td><span class="badge badge-light">Home Delivery </td>
                           </tr>
                           <tr>
                              <th>Address</th>
                              <td><span class="badge badge-light"><?php echo $order_prop['street_address'] ?><?php echo $order_prop['street_address'] ?></td>
                           </tr>
                           <tr>
                              <th>City</th>
                              <td><span class="badge badge-light"><?php echo $order_prop['city'] ?></td>
                           </tr>
                           <tr>
                              <th>State</th>
                              <td><span class="badge badge-light"><?php echo $order_prop['state'] ?></td>
                           </tr>
                           <tr>
                              <th>Pincode</th>
                              <td><span class="badge badge-light"><?php echo $order_prop['pincode'] ?></td>
                           </tr>
                           <tr>


                           <?php } else { ?>
                           <tr>
                              <th>Order Status</th>
                              <td>
                                <?php if ($order_prop['status'] == 0) { ?>
                                    <span class="badge  badge-danger">Cancelled</span>

                                <?php } else if ($order_prop['status'] == 1) { ?>
                                    <span class="badge  badge-warning">Placed</span>

                                <?php } else if ($order_prop['status'] == 2) { ?>
                                    <span class="badge  badge-success">Approved</span>

                                <?php } else if ($order_prop['status'] == 3) { ?>
                                    <span class="badge  badge-info">Deliverd</span>

                                <?php } else if ($order_prop['status'] == 4) { ?>
                                    <span class="badge  badge-success">Requested Refund</span>

                                <?php } else if ($order_prop['status'] == 5) { ?>
                                    <span class="badge  badge-danger">Refunded</span>

                                <?php } else {  ?>
                                    <span class="badge  badge-danger">Error</span>
                                <?php  } ?>

                            </td>
                           </tr>
                           <tr>
                              <th>Payment Type</th>
                              <td><span class="badge badge-light"><?php echo $order_prop['payment_type'] ?></td>
                           </tr>
                           <tr>
                              <th>Delivery Type</th>
                              <td><span class="badge badge-light">Store Pickup</td>
                           </tr>
                           <?php $store_sql = "SELECT * FROM store WHERE store_id =" . $order_prop['store_id'];
                           $store_query = mysqli_query($connect, $store_sql);
                           while ($store_row = mysqli_fetch_array($store_query)) {
                           ?>

                              <tr>
                                 <th>Store Name</th>
                                 <td><span class="badge badge-light"><?php echo $store_row['store_name'] ?></td>
                              </tr>
                              <tr>
                                 <th>Store Email</th>
                                 <td><span class="badge badge-light"><?php echo $store_row['email'] ?></td>
                              </tr>
                              <tr>
                                 <th>Store Phone</th>
                                 <td><span class="badge badge-light"><?php echo $store_row['phone'] ?></td>
                              </tr>
                              <tr>
                                 <th>Store Address</th>
                                 <td><span class="badge badge-light"><?php echo $store_row['address'] ?></td>
                              </tr>
                        <?php }
                        } ?>
                     </table>
                  </div>
               </div>

               <div class="col-lg-9 mt-5 mx-auto">
                  <div class="cart-table">
                     <table>
                        <thead>
                           <tr>
                              <th>Product</th>
                              <th>Name</th>
                              <th>Specs</th>
                              <th>Cost</th>
                              <th>Qty</th>
                              <th>Total</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $sql = "SELECT * FROM order_detail WHERE customer_id = '$customer_id' and order_id = '$order_id' 
           ORDER BY order_item_id DESC";
                           $run = mysqli_query($connect, $sql);
                           $count = mysqli_num_rows($run);
                           if (!$count) {
                              echo '<script>
               location.href="error.php"
               </script>';
                           }
                           while ($row = mysqli_fetch_assoc($run)) : {
                                 $id = $row['order_item_id'];
                                 $pid = $row['product_id'];
                                 $vid = $row['variant_id'];


                                 $img_sql = mysqli_query($connect, "SELECT file FROM product where id='$pid'");
                                 $pro_prop = mysqli_fetch_assoc($img_sql);

                                 $result_2 = mysqli_query($connect, "SELECT color,size FROM variant where variant_id='$vid'");
                                 $attr_prop = mysqli_fetch_assoc($result_2);
                                 $color_id = $attr_prop['color'];
                                 $size_id = $attr_prop['size'];

                                 $result_3 = mysqli_query($connect, "SELECT value FROM attribute where attr_id='$color_id'");
                                 $variant_prop = mysqli_fetch_assoc($result_3);
                                 $color = $variant_prop['value'];

                                 $result_4 = mysqli_query($connect, "SELECT value FROM attribute where attr_id='$size_id'");
                                 $variant_prop = mysqli_fetch_assoc($result_4);
                                 $size = $variant_prop['value'];

                           ?>
                                 <tr>
                                    <td class="cart-pic first-row"><a href="product.php?id=<?php echo $pid ?>">
                                          <img width="150" height="150" src="uploads/<?php echo $pro_prop['file'] ?>" alt="product image"></a></td>

                                    <td class="cart-title first-row">
                                       <span style="font-size: 1.1em;" class="badge  badge-light"><?php echo $row['product_name'] ?></span>
                                    </td>
                                    <td class="cart-title first-row">
                                       <a style="color:white; background-color:<?php echo $color ?>;" class="badge "><b><?php echo $size ?></b></a>
                                    </td>

                                    <td class="cart-title first-row">
                                       <span class="badge  badge-info">&#x20B9;&nbsp;<?php echo $row['price'] ?></span>
                                    </td>

                                    <td class="cart-title first-row">
                                       <span class="badge  badge-light">
                                          <?php echo $row['units'] ?></span>
                                    </td>

                                    <td class="cart-title first-row">
                                       <span class="badge  badge-success">&#x20B9;&nbsp;<?php echo $row['total'] ?></span>
                                    </td>


                                 </tr>
                           <?php }
                           endwhile; ?>

                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<?php include('footer.php'); ?>