<?php error_reporting(E_ALL ^ E_NOTICE) ?>

<?php
include_once "../../../controller/serviceController/CaterersController.php";

$result = getAllCaterers();

?>


<?php

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rating = $row["rating"] * 20;
        ?>
        <div class="venues-slide first" style="margin-bottom: 10px;">
            <div class="img" style=max-height:260px>
                <img src="<?php echo $row["image"]; ?>" style=max-height:260px>
            </div>
            <div class="text">
                <h3 class="product_name"><?php echo $row["package_name"]; ?></h3>
                <div class=reviews> <?php echo number_format((float)$row["rating"], 1, '.', ''); ?>
                    <div class=star>
                        <div class=fill style="width: <?php echo   $rating; ?>%"></div>
                    </div>reviews</div>
                <div class="outher-info">
                    <div class="info-slide first">
                        <label>Price</label>
                        <span class="product_price"> <?php echo $row["price"]; ?> </span>
                    </div>
                    <div class="info-slide">
                        <label>Transport cost</label>
                        <span class="product_transportCost"> <?php echo $row["transport_cost"]; ?> </span><small> (Your)</small>
                    </div>
                    <div class="info-slide">
                        <label>Available</label>
                        <span> <?php echo $row["available_status"]; ?> <small> </small></span>
                    </div>
                </div>
                <div class="outher-link">
                    <label>Description : </label>
                    <span><?php echo  $row["description"] ?><small> (quantity)</small></span> <br>
                    <span class="product_vendor"> <?php echo $row["vendor_username"]; ?> </span><small> (vendor)</small>
                </div>
                <?php
                        if ($row["available_status"] == "yes" || $row["available_status"] == "Yes") {
                            ?>
                    <div class="button">
                        <button type="button" class="btn btn_book product_id" id="<?php echo $row["id"]; ?>" name="bookproduct" value="<?php echo $row["id"]; ?>">
                            Book Now
                        </button>
                    </div>
                <?php
                        }

                        ?>
            </div>
        </div>

<?php
    }
} else {
    include_once "../../errors/spinner.php";
}
?>

<script>
    var addToCartButtons = document.getElementsByClassName('btn_book');

    for (var i = 0; i < addToCartButtons.length; i++) {
        var buttonAdd = addToCartButtons[i];
        buttonAdd.addEventListener('click', addToCartClicked);
    }

    function addToCartClicked(event) {
        var button = event.target;
        var product = button.parentElement.parentElement;
        var productName = product.getElementsByClassName('product_name')[0].innerText;
        var productPrice = product.getElementsByClassName('product_price')[0].innerText;
        var productId = product.getElementsByClassName('product_id')[0].value;
        var transportCost = product.getElementsByClassName('product_transportCost')[0].innerText;
        var vendor = product.getElementsByClassName('product_vendor')[0].innerText;

        $('#' + button.id).load('../productCartSession.php', {
            productName: productName,
            productPrice: productPrice,
            productId: productId,
            transportCost: transportCost,
            vendor: vendor
        });
        


    }
</script>