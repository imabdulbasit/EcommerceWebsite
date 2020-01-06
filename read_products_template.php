<?php
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      extract($row);

      // creating box
      echo "<div class='col-md-4 m-b-20px'>";
            
            // product id for javascript access
            echo "<div class='product-id display-none'>{$item_id}</div>";
            echo "<a href='product.php?id={$item_id}' class='product-link'>";
                // select and show first product image
                $product_image->item_id=$item_id;
                $stmt_product_image=$product_image->readFirst();

                while ($row_product_image = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
                    echo "<div class='m-b-10px'>";
                        echo "<img src='uploads/images/{$item_id}.jpg' class='w-100-pct' />";
                    echo "</div>";
                }


                // product name
                echo "<div class='product-name m-b-10px'>{$item_name}</div>";
            echo "</a>";

            // product price and category name
            echo "<div class='m-b-10px'>";
                echo "&#36;" . number_format($item_price, 2, '.', ',');
            echo "</div>";

            // add to cart button
            echo "<div class='m-b-10px'>";
                // cart item settings
                $cart_item->user_id=1; // we default to a user with ID "1" for now
                $cart_item->item_id=$item_id;

                // if product was already added in the cart
                if($cart_item->exists()){
                    echo "<a href='cart.php' class='btn btn-success w-1-pct'>";
                        echo "Update Cart";
                    echo "</a>";
                }else{
                    echo "<a href='add_to_cart.php?id={$item_id}&page={$page}' class='btn btn-primary w-1-pct'>Add to Cart</a>";
                }
            echo "</div>";



      echo "</div>";
    }

include_once "pagination.php";
?>
