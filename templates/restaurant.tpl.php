<?php

declare(strict_types=1);

require_once('database/connection.database.php');

require_once('database/restaurant.class.php');
require_once('database/review.class.php');
require_once('database/reviewResponse.class.php');
?>

<?php function drawRestaurants(array $restaurants)
{ ?>
  <h2>Restaurants</h2>
  <section id="restaurants">
    <?php foreach ($restaurants as $restaurant) { ?>
      <article>
        <a href="restaurant.php?id=<?= $restaurant->id ?>"><?= $restaurant->restaurantName ?></a>
      </article>
    <?php } ?>
  </section>
<?php } ?>

<?php function drawRestaurantHeader(Restaurant $restaurant)
{ ?>
  <section class="restaurantHeader">
    <div class="restaurantInfo">
      <h2><?= $restaurant->restaurantName ?></h2>
      <h3>
        <i class="fa-regular fa-star"></i>
        <i class="fa-regular fa-star"></i>
        <i class="fa-regular fa-star"></i>
        <i class="fa-regular fa-star"></i>
        <i class="fa-regular fa-star"></i>
      </h3>
      <h4> <?= $restaurant->restaurantAddress ?> </h4>
    </div>
  </section>
<?php } ?>

<?php function drawRestaurant(Restaurant $restaurant, array $dishes, array $reviews)
{ ?>
  <section class="restaurant">
    <section class="restaurantTopPage">

      <a> Dishes </a>
      <a> Reviews </a>

      <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <p> Cart </p>

        <total class="totalSum" id="totalSum">Total : </total>
      </div>

      <div id="mySidenav" class="sidenav">
        <a href="#" id="cart" class="openbtn" onclick="openNav()">
          <i class="fa-solid fa-cart-shopping"></i>
          <p>Cart</p>
        </a>
      </div>

      <form action="#">
        <select name="languages" id="lang" onchange="this.form.submit();">
          <option value="Chinese">Chinese</option>
          <option value="Italian">Italian</option>
        </select>
      </form>
    </section>
    <section id="dishes">
      <?php foreach ($dishes as $dish) { ?>
        <div class="dish">

          <img src="https://picsum.photos/200?1" alt="Dish Photo">
          <div class="information">
            <div class="name">
              <p id="name"> <?= $dish->dishName ?> </p>
              <i class="fa-regular fa-star"></i>
            </div>
            <div class="price">
              <p id="price"> <?= $dish->dishPrice ?> </p>
              <button class="fa-solid fa-cart-shopping button" onclick="addToCart()"></button>
            </div>
          </div>
        </div>
      <?php } ?>
    </section>
  </section>

  <section id="reviews">
    <?php foreach ($reviews as $review) {
      $db = getDatabaseConnection();
      $response = ReviewResponse::getReviewResponse($db, intval($review->reviewId));
    ?>
      <div class="reviewBox">
        <div class="review">
          <div class="info">
            <p id="name"> <?= ReviewRestaurant::getReviewerName($db, intval($review->customerId)) ?> </p>
            <h3>
              <i class="fa-regular fa-star"></i>
              <i class="fa-regular fa-star"></i>
              <i class="fa-regular fa-star"></i>
              <i class="fa-regular fa-star"></i>
              <i class="fa-regular fa-star"></i>
            </h3>
          </div>
          <p id="reviewBody"> <?= $review->reviewText ?> </p>
        </div>
        <p id="response"> Resposta: <?= $response->reviewText ?> </p>

      </div>
  </section>
<?php } ?>
</section>

<?php } ?>