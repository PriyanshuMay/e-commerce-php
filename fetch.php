<?php
require_once('essentials/config.php');

if (isset($_POST["action"])) {
    $query = "
  SELECT * FROM product WHERE id > 0
 ";
    if (isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"])) {
        $query .= "
   AND cost BETWEEN '" . $_POST["minimum_price"] . "' AND '" . $_POST["maximum_price"] . "'
  ";
    }
    if (isset($_POST["brand"])) {
        $brand_filter = implode("','", $_POST["brand"]);
        $query .= "
   AND brand IN('" . $brand_filter . "')
  ";
    }
    if (isset($_POST["categories"])) {
        $categories_filter = implode("','", $_POST["categories"]);
        $query .= "
   AND categories IN('" . $categories_filter . "')
  ";
    }
    if (isset($_POST["section"])) {
        $section_filter = implode("','", $_POST["section"]);
        $query .= "
   AND section IN('" . $section_filter . "')
  ";
    }
    
    $statement = $con->prepare($query);
    $statement->execute();
    $result    = $statement->fetchAll();
    $total_row = $statement->rowCount();
    $output    = '';
    if ($total_row > 0) {
        foreach ($result as $row) {
            $output .= '
            <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic">
                                    <a href="product.php?id=' .  $row['id'] . '">
                                        <img width="200" height="300" src="uploads/' .  $row['file'] . '" alt="' .  $row['file'] . '"></a>
                                        <div class="sale pp-sale">Sale</div>
                                        <div class="icon">
                                            <i class="icon_heart_alt"></i>
                                        </div>
                                    </div>
                                    <div class="pi-text">
                                        <div class="catagory-name">' .  $row['name'] . '</div>
                                        <a href="#">
                                            <h5>' .  $row['code'] . '</h5>
                                        </a>
                                        <div class="product-price">
                                        &#x20B9;' .  $row['cost'] . '&nbsp;
                                        <span>&#x20B9;' .  $row['MRP'] . '</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
        }
    } else {
        $output = '<h3>No Data Found</h3>';
    }
    echo $output;
}
 
?>