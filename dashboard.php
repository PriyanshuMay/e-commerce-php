<?php
include('boilerplate.php');

if (!isset($_SESSION['email']) ) {
    echo '<script>
    location.href="error.php"
    </script>';
}

$sql = "SELECT * FROM orders WHERE email = '$customer' ORDER BY created_date DESC";
$run = mysqli_query($connect, $sql);
$count = mysqli_num_rows($run);

$sql2 = "SELECT * FROM wishlist WHERE customer_id='$customer_id'";
$run2 = mysqli_query($connect, $sql2);
$count_fav = mysqli_num_rows($run2);
?>
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="contact-widget">
                    <div class="cw-item">
                        <div class="ci-icon">
                            <i class="far fa-address-card"></i>
                        </div>
                        <div class="ci-text">
                            <span>Hello, </span>
                            <p><?php echo $_SESSION['name']; ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="cw-item">
                        <div class="ci-icon">
                            <i class="fas fa-barcode"></i>
                        </div>
                        <div class="ci-text">
                            <span>Manage Orders</span>
                            <p>Dashboard</p>
                        </div><br>
                        <a href="myOrder.php">
                            <p>My Orders(<?php echo $count ?>)</p>
                        </a>
                        <a href='cart.php'>
                            <p>My Cart(<?php echo $total ?>)</p>
                        </a>
                        <a href='wishlist.php'>
                            <p>My Wishlist(<?php echo $count_fav ?>)</p>
                        </a>

                    </div>
                    <hr>

                    <div class="cw-item">
                        <div class="ci-icon">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        <div class="ci-text">
                            <span>Change</span>
                            <p>User Setting</p>
                        </div><br>
                        <p>Email:&nbsp;<span  class="badge badge-light"><?php echo $customer ?></span></p>
                        <p>Phone:&nbsp;<span  class="badge badge-light"><?php echo $_SESSION['phone']; ?></span></p>
                        <p>Since:&nbsp;<span  class="badge badge-light"><?php echo $customer_created  ?></span></p>
                        <p>Last Visited:&nbsp;<span  class="badge badge-light"><?php echo $customer_login ?></span></p>
                        <p><a style="text-decoration: none; color:#444;" href="changePassword.php">Change Password</a></p>
                        <p><a style="text-decoration: none; color:#444;" href="changePhone.php">Change Phone Number</a></p>
                        <p><a style="text-decoration: none; color:#444;" href="deactivateAccount.php">Account deactivation</a></p>
                    </div>
                    <hr>
                    <div class="cw-item">
                        <div class="ci-icon">
                            <i class="fas fa-toggle-off"></i>
                        </div>
                        <div class="ci-text">
                            <span>Done Shopping,</span>
                            <a href="logout.php">
                                <p>Logout</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $customer = $_SESSION['email'];
                        $c = "SELECT * FROM customer WHERE email = '$customer'";
                        $r = mysqli_query($connect, $c);
                        $row_c = mysqli_fetch_assoc($r);
                        $customer_id = $row_c['id'];

                        $result = mysqli_query($connect, "SELECT distinct product.*,wishlist.product_id,wishlist.customer_id FROM product LEFT JOIN wishlist
          ON product.id = wishlist.product_id
          WHERE wishlist.customer_id = '$customer_id'");

                        if ($result) {
                            while ($obj = mysqli_fetch_object($result)) {
                                $id = $obj->id; ?>
                                <tr>
                                    <td><img src="uploads/<?php echo $obj->file ?>" width="150" height="150" /></td>
                                    <td>
                                        <h5><a href="product.php?id=<?php echo  $obj->id ?>"><?php echo $obj->name ?></a></h5>
                                        <p> <?php echo $obj->cost ?></p>
                                    </td>
                                    <td><a href="updateCart.php?action=remove&id=<?php echo $product_id ?>">
                                            <i class="fas fa-2x fa-cart-plus"></i></a></td>
                                    <td><a href="updateWishlist.php?user=<?php echo $customer_id ?>&action=remove&id=<?php echo $product_id ?>">
                                            <i class="fas fa-2x fa-trash"></i></a></td>
                                </tr>

                        <?php
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>