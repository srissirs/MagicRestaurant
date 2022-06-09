<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.database.php');

require_once(__DIR__ . '/../database/restaurant.class.php');
require_once(__DIR__ . '/../database/review.class.php');
require_once(__DIR__ . '/../database/reviewResponse.class.php');
?>

<?php function drawMainRestaurantHeader()
{ ?>
    <div class="mainRestaurantsHeader">
        <div class="searched">
            <h3>Restaurantes</h3>
        </div>
    </div>
<?php } ?>

<?php function drawMainRestaurant(array $restaurants)
{ ?>
    <section class="restaurants" id="restaurants">
        <?php foreach ($restaurants as $restaurant) { ?>
            <section class="restaurantCard">
                <img src="../images/restaurant.jpg" alt="Restaurant Photo">
                <div class="mainRestaurantsInfo">
                    <div class="mainRestaurantsName">
                        <a href="restaurant.php?id=<?= $restaurant->restaurantId ?>"><?= $restaurant->restaurantName ?></a>
                        <?php $db = getDatabaseConnection();
                        if (!Restaurant::isOwner($db, intval($restaurant->restaurantId), intval($_SESSION['userId']))) {
                            $isFavorite = Customer::isRestaurantFavorited($db, intval($_SESSION['userId']), intval($restaurant->restaurantId));
                            if ($isFavorite)
                                $star = "fa fa-star checked full";
                            else $star = "fa fa-star checked"; ?>
                            <button class="<?=$star?>" onclick="toggleFavorite(<?= $restaurant->restaurantId ?>,0)"></button>
                        <?php } ?>
                    </div>
                    <div class="mainRestaurantsRating">
                        <i class="fa-regular fa-star"></i>
                        <p> <?= $restaurant->rating ?> </p>
                    </div>
                </div>
            </section>
        <?php } ?>
    </section>
<?php } ?>