<?php
   session_start();
   require_once('essentials/config.php');
   include('boilerplate.php');
   include('navbar.php');

?>
<div class="container">
<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <h3>Price</h3>
            <input type="hidden" id="min_price_hide" value="1" />
            <input type="hidden" id="max_price_hide" value="20000" />
            <p id="price_show">$1 - $20000</p>
            <div id="price_range"></div>
        </div>

        <div class="list-group">
            <h3>section</h3>
            <?php


            $query = "
            SELECT DISTINCT(section) FROM product ORDER BY section ASC
            ";
            $statement = $con->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
            $sql = "
            SELECT cat_name FROM section WHERE cat_id = '$row[0]'
            ";
            $exe =$connect->query($sql);
            $name = $exe ->fetch_assoc();
            
            ?>
                <div class="list-group-item checkbox">
                    <label>
                        <input type="checkbox" class="filter_all section" value="<?php echo $row['section']; ?>">
                        <?php echo $name['cat_name']; ?>
                    </label>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="list-group">
            <h3>Brand</h3>
                 <?php

            $query = "
            SELECT DISTINCT(brand) FROM product ORDER BY brand ASC
            ";
            $statement = $con->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
                $sql = "
            SELECT brand_name FROM brand WHERE brand_id = '$row[0]'
            ";
            $exe =$connect->query($sql);
            $name = $exe ->fetch_assoc();
            ?>
                    <div class="list-group-item checkbox">
                        <label>
                            <input type="checkbox" class="filter_all brand" value="<?php echo $row['brand']; ?>">
                            <?php echo $name['brand_name']; ?>
                        </label>
                    </div>
                    <?php
            }

            ?>
         </div>

        <div class="list-group">
            <h3>categories</h3>
            <?php

            $query = "
            SELECT DISTINCT(categories) FROM product ORDER BY categories ASC
            ";
            $statement = $con->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
                $sql = "
            SELECT sub_name FROM categories WHERE sub_id = '$row[0]'
            ";
            $exe =$connect->query($sql);
            $name = $exe ->fetch_assoc();
            ?>
                <div class="list-group-item checkbox">
                    <label>
                        <input type="checkbox" class="filter_all categories" value="<?php echo $row['categories']; ?>">
                        <?php echo $name['sub_name']; ?>
                    </label>
                </div>
                <?php    
            }

            ?>
        </div>

    </div>

    <div class="col-md-9">

        <div class="row filter_data">

        </div>

    </div>
</div>

</div>


<script>
$(document).ready(function() {

    filter_data();

    function filter_data() {
        $('.filter_data');
        var action = 'fetch_data';
        var minimum_price = $('#min_price_hide').val();
        var maximum_price = $('#max_price_hide').val();
        var brand = get_filter('brand');
        var categories = get_filter('categories');
        var section = get_filter('section');
        $.ajax({
            url: "fetch.php",
            method: "POST",
            data: {
                action: action,
                minimum_price: minimum_price,
                maximum_price: maximum_price,
                brand: brand,
                categories: categories,
                section: section
            },
            success: function(data) {
                $('.filter_data').html(data);
            }
        });
    }

    function get_filter(class_name) {
        var filter = [];
        $('.' + class_name + ':checked').each(function() {
            filter.push($(this).val());
        });
        return filter;
    }

    $('.filter_all').click(function() {
        filter_data();
    });

    $('#price_range').slider({
        range: true,
        min: 1,
        max: 20000,
        values: [1, 20000],
        step: 100,
        stop: function(event, ui) {
            $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
            $('#min_price_hide').val(ui.values[0]);
            $('#max_price_hide').val(ui.values[1]);
            filter_data();
        }
    });

});
</script>

                
<?php include('footer.php'); ?></body>

</html>