<?php
require('header.php');
?>
<div class="container">
    <div class="row">
        <div class="col-lg-9 mx-auto my-4 text-center">
            <h2><span class="badge badge-light">Manage Customer</span></h2>
        </div>
        <div class="col-lg-9 mx-auto text-center">
            <a href="unverifiedCustomer.php" class="m-2 btn btn-sm btn-warning">
                <i class="fa fa-exclamation-triangle mr-2"></i> <b>Unverified Customer</b></a>

            <a href="unactiveCustomer.php" class="m-2 btn btn-sm btn-secondary">
                <i class="fa fa-bell-slash mr-2"></i> <b>Unactive Customer</b></a>

            <a href="disabledCustomer.php" class="m-2 btn btn-sm btn-danger">
                <i class="fas fa-user-slash mr-2"></i> <b>Disabled Customer</b></a>
        </div>
        <div class="col-lg-12  mt-5">
            <div class="table-responsive">
                <table class='table table-borderless text-center'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>PHONE</th>
                            <th>STATUS</th>
                            <th>REGISTERED</th>
                            <th>LAST LOGIN</th>
                            <th>ORDERS</th>
                            <th>HISTORY</th>
                            <th>UPDATE</th>
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
                        $query = "SELECT * FROM customer WHERE status>=0 ORDER BY id DESC LIMIT $start_from, $per_page";
                        $result = mysqli_query($connect, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>

                            <tr>
                                <td>
                                    <span class="badge  badge-light"><?php echo $row['id'] ?></span>
                                </td>

                                <td>
                                    <span class="badge  badge-light"><?php echo $row['name'] ?></span>
                                </td>
                                <td>
                                    <span class="badge  badge-light"><?php echo $row['email'] ?></span>
                                </td>
                                <td>
                                    <span class="badge  badge-light"><?php echo $row['phone'] ?></span>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 0) { ?>
                                        <span class="badge badge-warning">Unverified</span>

                                    <?php } else if ($row['status'] == 1) { ?>
                                        <span class="badge badge-success">Active</span>

                                    <?php } else if ($row['status'] == 2) { ?>
                                        <span class="badge badge-success">Unactive</span>

                                    <?php } else if ($row['status'] == 3) { ?>
                                        <span class="badge badge-info">Disabled</span>

                                    <?php } else {  ?>
                                        <span class="badge badge-danger">Error</span>
                                    <?php  } ?>
                                </td>
                                <td>
                                    <span class="badge  badge-light"><?php echo $row['datetym'] ?></span>
                                </td>
                                <td>
                                    <span class="badge  badge-light"><?php echo $row['last_login'] ?></span>
                                </td>
                                <td>
                                    <a style="color:#333;" href="customerOrder.php?id=<?php echo $row['id'] ?>">
                                        <i class="fas fa-box"></i></a>
                                </td>
                                <td>
                                    <a style="color:#888;" href="customerHistory.php?id=<?php echo $row['id'] ?>">
                                        <i class="fa fa-history"></i></a>
                                </td>
                                <td>
                                    <?php if ($row['status'] != 3) {  ?>
                                        <a style="color: red; " class='disable' id='disable_<?= $row['id'] ?>'>
                                            <i class="fas fa-user-slash"></i></a>
                                    <?php } else { ?>
                                        <a style="color: green; " class='enable' id='enable_<?= $row['id'] ?>'>
                                            <i class="fas fa-user-plus"></i></a>
                                    <?php } ?>
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
<?php
$query = "SELECT * FROM customer WHERE status>=0";
$result = mysqli_query($connect, $query);
$total_posts = mysqli_num_rows($result);
$total_pages = ceil($total_posts / $per_page);
$page_url = $_SERVER['PHP_SELF'];


echo "<div class='center'><div class='pagination justify-content-center'><a href ='$page_url?page=1'>First</a>";

for ($i = 1; $i <= $total_pages; $i++) : ?>

	<a class="<?php if ($page == $i) {
					echo 'active';
				} ?>" href="<?php echo $page_url ?>?page=<?= $i; ?>"> <?= $i; ?> </a>

<?php endfor;
echo "<a href='$page_url?page=$total_pages' >Last</a></div></div>";
?>
</body>
<script src="https://kit.fontawesome.com/77f6dfd46f.js" crossorigin="anonymous"></script>
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script src="js/bootbox.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('.disable').click(function() {
            var el = this;
            var id = this.id;
            var splitid = id.split("_");
            var deleteid = splitid[1];
            bootbox.confirm({
                message: "Do you really want to disable this account ?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function(result) {

                    if (result) {

                        $.ajax({
                            url: 'disableCustomer.php',
                            type: 'POST',
                            data: {
                                id: deleteid
                            },
                            success: function(response) {


                                if (response == 1) {
                                    $(el).closest('tr').css('background', 'tomato');
                                    $(el).closest('tr').fadeOut(800, function() {
                                        $(this).remove();
                                    });
                                } else {
                                    bootbox.alert('Error! Query Not Executed');
                                }

                            }
                        });
                    }

                }
            });

        });


    });
</script>
<script type="text/javascript">
    $(document).ready(function() {

        $('.enable').click(function() {
            var el = this;
            var id = this.id;
            var splitid = id.split("_");
            var deleteid = splitid[1];
            bootbox.confirm({
                message: "Do you really want to activate this account ?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function(result) {

                    if (result) {

                        $.ajax({
                            url: 'enableCustomer.php',
                            type: 'POST',
                            data: {
                                id: deleteid
                            },
                            success: function(response) {


                                if (response == 1) {
                                    $(el).closest('tr').css('background', 'green');
                                    $(el).closest('tr').fadeOut(800, function() {
                                        $(this).remove();
                                    });
                                } else {
                                    bootbox.alert('Error! Query Not Executed');
                                }

                            }
                        });
                    }

                }
            });

        });


    });
</script>

</html>