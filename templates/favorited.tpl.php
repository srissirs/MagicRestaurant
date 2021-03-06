<?php

declare(strict_types=1);

require_once(__DIR__.'/../database/connection.database.php');

require_once(__DIR__.'/../database/restaurant.class.php');
require_once(__DIR__.'/../database/dish.class.php');
?>

<?php function drawFavoritedHeader()
{ ?>
  <section class="favoritedHeader">
    <div class="restaurantInfo">
      <h2>Favorites</h2>
    </div>
  </section>
<?php } ?>

<?php function drawFavorited(array $restaurants,array $dishes)
{ ?>
  <section class="favorited">
    <section class="favoritedTopPage">
      <a> Dishes </a>
      <a> Restaurants </a>
      
    </section>
    
    <section id="dishes">
      <?php foreach ($dishes as $dish) { ?>
        <div class="dish">
        <?php
          $db = getDatabaseConnection();
          $dishPhoto = Dish::getDishPhoto($db, $dish);
          if ($dishPhoto === (0)) { ?>
            <img src="https://picsum.photos/200?1" alt="Dish Photo">
          <?php } else { ?>
            <img src="../images/<?= $dishPhoto ?>.jpg" alt="Dish Photo">
          <?php } ?>
          <div class="information">
            <div class="name">
              <p id="name"> <?= $dish->dishName ?> </p>
              <?php 
                $isFavorite = Customer::isDishFavorited($db,intval($_SESSION['userId']),intval($dish->dishId));
                if($isFavorite)
                $star ="fa fa-star checked full"; else $star = "fa-regular fa-star"; ?>
                <button class="<?= $star ?>"  onclick="toggleFavorite(<?= $dish->dishId ?>,1)">
                </button>
              
            </div>
            <category>
                    <p id="category"> <?=$dish->dishCategory?> </p>
                </category>
            <div class="price">
              <p id="price"> <?= $dish->dishPrice ?> €</p>
            </div>
          </div>
        </div>
      <?php } ?>
    </section>

    <section class="restaurants" id="restaurants">
        <?php foreach ($restaurants as $restaurant) { ?>
            <section class="restaurantCard">
                <img src="../images/restaurant.jpg" alt="Restaurant Photo">
                <div class="mainRestaurantsInfo">
                    <div class="mainRestaurantsName">
                        <a  href="restaurant.php?id=<?= $restaurant->restaurantId ?>"> <?=$restaurant->restaurantName ?> </a>
                        <?php $db = getDatabaseConnection();
                        if (!Restaurant::isOwner($db, intval($restaurant->restaurantId), intval($_SESSION['userId']))) {
                            $isFavorite = Customer::isRestaurantFavorited($db, intval($_SESSION['userId']), intval($restaurant->restaurantId));
                            if ($isFavorite)
                                $star = "fa fa-star checked full";
                            else $star = "fa-regular fa-star"; ?>
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
  </section>


<?php } ?>