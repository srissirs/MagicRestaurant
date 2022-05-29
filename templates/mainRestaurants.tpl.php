<?php

declare(strict_types=1);

require_once('database/connection.database.php');

require_once('database/restaurant.class.php');
require_once('database/review.class.php');
require_once('database/reviewResponse.class.php');
?>

<?php function drawMainRestaurantHeader()
{ ?>
    <div class="mainRestaurantsHeader">
        <div class="searched">
            <h3>Restaurant Name</h3>
        </div>
    </div>
<?php } ?>

<?php function drawMainRestaurant(array $restaurants)
{ ?>
    <section class="restaurants">
        <?php foreach ($restaurants as $restaurant) { ?>
            <section class="restaurantCard">
                <img src="../images/restaurant.jpg" alt="Restaurant Photo">
                <div class="mainRestaurantsInfo">
                    <div class="mainRestaurantsName">
                        <p id="name"> <?= $restaurant->restaurantName ?></p>
                        <i class="fa-regular fa-heart"></i>
                    </div>
                    <div class="mainRestaurantsRating">
                        <i class="fa-regular fa-star"></i>
                        <p id="rating"> <?= $restaurant->rating ?> </p>
                    </div>
                </div>
            </section>
        <?php } ?>
    </section>
<?php } ?>