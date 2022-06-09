<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.database.php');


require_once(__DIR__ . '/../database/restaurant.class.php');
require_once(__DIR__ . '/../database/review.class.php');
require_once(__DIR__ . '/../database/reviewResponse.class.php');
require_once(__DIR__.'/../database/customer.class.php');
?>


<?php function drawfav()
{ ?>
  <button><i class="fa fa-star checked full"></i></button>
<?php } ?>

<?php function drawstr()
{ ?>
  <button><i class="fa fa-star checked"></i></button>
<?php } ?>

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
        <p> <?= $restaurant->rating ?> </p>
        <i class="fa fa-star checked"></i>
        <i class="fa fa-star checked"></i>
        <i class="fa fa-star checked"></i>
        <i class="fa fa-star checked"></i>
        <i class="fa fa-star checked"></i>
      </h3>
      <h4> <?= $restaurant->restaurantAddress ?> </h4>
    </div>
  </section>
<?php } ?>


<?php function drawRestaurant(Restaurant $restaurant, array $dishes, array $reviews, array $categories, int $isOwner)
{ ?>
  <section class="restaurant">
    <section class="restaurantTopPage">
      <div class="buttons">
        <a> Dishes </a>
        <a> Reviews </a>
        <?php if ($isOwner) { ?>
          <a class="addADish" onclick="addADish()"> Add a Dish</a>
        <?php } ?>
      </div>

      <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <p> Cart </p>

        <total class="totalSum" id="totalSum">Total : </total>
        <button onclick="addOrderDish()"> HERE </button>
      </div>
      <?php if (!$isOwner) { ?>
        <div id="mySidenav" class="sidenav">
          <a href="#" id="cart" class="openbtn" onclick="openNav()">
            <i class="fa-solid fa-cart-shopping"></i>
            <p>Cart</p>
          </a>
        </div>
      <?php } ?>
      <form action="#">
        <select>
          <option value="Tudo"> Tudo </option>
          <?php foreach ($categories as $category) { ?>
            <option value="<?= $category ?>"> <?= $category ?> </option>
          <?php } ?>
        </select>
      </form>
    </section>
    <section id="dishes">
      <div class="newDish" id="newDish" style="display: none;">
        <form action="../actions/action_add_dish.php" method="post" enctype="multipart/form-data">
          <div class="information">
            <input name="restaurantId" hidden value="<?= $restaurant->restaurantId ?>">
            <div class="name">
              <label> Dish Name: </label>
              <input name="dishName">
            </div>
            <category>
              <label> Dish Category: </label>
              <input name="dishCategory">
            </category>
            <div class="price">
              <label> Dish Price: </label>
              <input name="dishPrice">
            </div>
            <input type="file" name="image" value=''>
          </div>
          <button type="submit">Save</button>
        </form>
      </div>
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
              <form action="../actions/action_favorite_dish.php" method="post" class="register_form">
                <input type="number" id="dishId" name="dishId" style="display:none " value=<?= $dish->dishId ?>>
                <input type="number" id="customerId" name="customerId" style="display:none " value=<?= $_SESSION['userId'] ?>>
                <input type="number" id="restaurantId" name="restaurantId" style="display:none " value=<?= $restaurant->restaurantId ?>>
                <?php if (!$isOwner) {
                  if (Customer::isFavorited($db, $_SESSION['userId'], $dish->dishId)) {
                    drawfav();
                  } else {
                    drawstr();
                  }
                }
                ?>
              </form>
            </div>
            <category>
              <p id="category"> <?= $dish->dishCategory ?> </p>
            </category>
            <div class="price">
              <p id="price"> <?= $dish->dishPrice ?> </p>
              <?php if (!$isOwner) { ?>
                <button class="fa-solid fa-cart-shopping button" onclick="addToCart(<?= intval($dish->dishId) ?>,<?= floatval($dish->dishPrice) ?> )"></button>
              <?php } ?>
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
              <i class="fa fa-star checked"></i>
              <i class="fa fa-star checked"></i>
              <i class="fa fa-star checked"></i>
              <i class="fa fa-star checked"></i>
              <i class="fa fa-star checked"></i>
              <p><?= $review->reviewRating ?></p>
            </h3>
          </div>
          <p id="reviewBody"> <?= $review->reviewText ?> </p>
        </div>
        <?php if ($isOwner || !($response->reviewText === "")) { ?>
          <section class="responseBox">
            <?php if ($isOwner && ($response->reviewText === "")) { ?>
              <button> Respond </button>
              <form action="../actions/action_add_response.php" method="post">
                <input type="text" name="responseText">
                <input type="text" hidden name="reviewId" value="<?= $review->reviewId ?>">
                <button type="submit">Save</button>
              </form>
            <?php } else { ?>
              <p id="response"> Resposta: <?= $response->reviewText ?> </p>
            <?php } ?>
          </section>
        <?php } ?>
      </div>
    <?php } ?>
  </section>

  </section>

<?php } ?>