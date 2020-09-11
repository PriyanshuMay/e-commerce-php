<?php
require('header.php');
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 mx-auto mt-5 text-center">

            <a href="soldOut.php" class="m-2 btn btn-sm btn-warning">
                <i class="fa fa-plus-square mr-2"></i> <b>Unapproved Orders</b></a>

            <a href="addProduct.php" class="m-2 btn btn-sm btn-danger">
                <i class="fa fa-plus-square mr-2"></i> <b>Cancelled Orders</b></a>

            <a href="soldOut.php" class="m-2 btn btn-sm btn-success">
                <i class="fa fa-plus-square mr-2"></i> <b>Completed Orders</b></a>


            <a href="deactivatedProduct.php" class="m-2 btn btn-sm btn-info">
                <i class="fa fa-plus-square mr-2"></i> <b>Refund Request</b></a>

            <a href="deactivatedProduct.php" class="m-2 btn btn-sm btn-info">
                <i class="fa fa-plus-square mr-2"></i> <b>Refunded Orders</b></a>

        </div>
        <div class="col-lg-12 mx-auto mt-5">
            <div class="table-responsive">
                <table class='table table-borderless text-center'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>STATUS</th>
                            <th>DETAILS</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>TYPE</th>
                            <th>PAYMENT</th>
                            <th>UNITS</th>
                            <th>PRICE</th>
                            <th>CREATED</th>
                            <th>MODIFIED</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $per_page = 12;

                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }

                        $start_from = ($page - 1) * $per_page;

                        $query = "SELECT * FROM orders ORDER BY order_id DESC LIMIT $start_from, $per_page";
                        $result = mysqli_query($connect, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>

                            <tr>
                                <td>
                                    <span class="badge badge-light"><?php echo $row['order_id'] ?></span>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 0) { ?>
                                        <span class="badge  badge-danger">Cancelled</span>

                                    <?php } else if ($row['status'] == 1) { ?>
                                        <span class="badge  badge-warning">Placed</span>

                                    <?php } else if ($row['status'] == 2) { ?>
                                        <span class="badge  badge-success">Approved</span>

                                    <?php } else if ($row['status'] == 3) { ?>
                                        <span class="badge  badge-info">Shipped</span>

                                    <?php } else if ($row['status'] == 4) { ?>
                                        <span class="badge  badge-success">Deliverd</span>

                                    <?php } else if ($row['status'] == 5) { ?>
                                        <span class="badge  badge-info">Refund Requested</span>

                                    <?php } else if ($row['status'] == 6) { ?>
                                        <span class="badge  badge-success">Refunded</span>

                                    <?php } else {  ?>
                                        <span class="badge  badge-danger">Error</span>
                                    <?php  } ?>

                                </td>

                            <td>

<a style="color:#F67E29;" href="orderDetail.php?id=<?php echo $id ?>" >
    <i class="fas fa-info-circle"></i></a>

</td>
                                <td>
                                    <span class="badge badge-light"><?php echo $row['full_name'] ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-light"><?php echo $row['email'] ?></span>
                                </td>
                                <td>
                                    <?php if ($row['store_id'] == 0) { ?>
                                        <span class="badge badge-light">Store Pickup</span>

                                    <?php } else {
                                        echo '<span class="badge badge-light">Home Delivery</span>';
                                    } ?>
                                </td>
                                <td>
                                    <span class="badge badge-light"><?php echo $row['payment_type'] ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-light"><?php echo $row['total_qty'] ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-light">&#x20B9;&nbsp;<?php echo $row['total_amt'] ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-light"><?php echo $row['created_date'] ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-light"><?php echo $row['modified_date'] ?></span>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<?php include('pagination.php'); ?>
</body>
<script src="https://kit.fontawesome.com/77f6dfd46f.js" crossorigin="anonymous"></script>
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script src="js/bootbox.min.js"></script>

</html>