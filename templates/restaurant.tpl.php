<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.database.php');


require_once(__DIR__ . '/../database/restaurant.class.php');
require_once(__DIR__ . '/../database/review.class.php');
require_once(__DIR__ . '/../database/reviewResponse.class.php');
require_once(__DIR__ . '/../database/customer.class.php');
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
        <p> <?= $restaurant->rating ?> </p>
        <i class="fa-regular fa-star full"></i>
        <i class="fa-regular fa-star full"></i>
        <i class="fa-regular fa-star full"></i>
        <i class="fa-regular fa-star full"></i>
        <i class="fa-regular fa-star full"></i>
      </h3>
      <h4> <?= $restaurant->restaurantAddress ?> </h4>
    </div>
  </section>
<?php } ?>

<?php function drawRestaurant(Restaurant $restaurant, array $dishes, array $reviews, array $categories, int $isOwner, array $restaurantOrders)
{ ?>
  <section class="restaurant">
    <section class="restaurantTopPage">

      <div class="buttons">
        <a class="dishesButton"> Dishes </a>
        <a class="reviewsButton"> Reviews </a>
        <?php if ($isOwner) { ?>
          <a class="addADish"> Add a Dish</a>
          <a class="orderStates"> Order States </a>
        <?php } ?>

        <form>
          <select>
            <option value="Tudo"> Tudo </option>
            <?php foreach ($categories as $category) { ?>
              <option value="<?= $category ?>"> <?= $category ?> </option>
            <?php } ?>
          </select>
        </form>
      </div>

      <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <p> Cart </p>
        <div class="totalSum" id="totalSum">Total : </div>
        <button onclick="addOrderDish();clearDishes();"> Finish you order </button>
      </div>
      <?php if (!$isOwner) { ?>
        <div id="mySidenav" class="sidenav">
          <a id="cart" class="openbtn" onclick="openNav()">
            <i class="fa-solid fa-cart-shopping"></i>
            <p>Cart</p>
          </a>
        </div>
      <?php } ?>

    </section>
    <section id="dishes">
      <div class="newDish" id="newDish" style="display: none;">
        <form action="../actions/action_add_dish.php" method="post" enctype="multipart/form-data">
          <p id="error_messages" style="color: #946B6B">
            <?php if (isset($_SESSION['ERROR_ADD_DISH'])) echo htmlentities($_SESSION['ERROR_ADD_DISH']);
            unset($_SESSION['ERROR_ADD_DISH']) ?>
          </p>
          <div class="information">
            <input name="restaurantId" hidden value="<?= $restaurant->restaurantId ?>">
            <div class="name">
              <label> Dish Name: </label>
              <input name="dishName">
            </div>
            <div>
              <label> Dish Category: </label>
              <input name="dishCategory">
            </div>
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
          $dishPhoto = Dish::getDishPhoto($db, $dish); ?>
          <img src="../images/<?= $dishPhoto ?>.jpg" alt="Dish Photo">
          <div class="information">
            <div class="name">
              <p id="name"> <?= $dish->dishName ?> </p>
              <?php if (!$isOwner) {
                $isFavorite = Customer::isDishFavorited($db, intval($_SESSION['userId']), intval($dish->dishId));
                if ($isFavorite)
                  $star = "fa fa-star checked full";
                else $star = "fa-regular fa-star full"; ?>
                <button class="<?= $star ?>" onclick="toggleFavorite(<?= $dish->dishId ?>,1)">
                </button>
              <?php } ?>
            </div>
            <div class="dishCategory">
              <p> <?= $dish->dishCategory ?> </p>
            </div>
            <div class="price">
              <p id="price"> <?= $dish->dishPrice ?> </p>
              <?php if (!$isOwner) { ?>
                <button class="fa-solid fa-cart-shopping button" onclick="addToCart(<?= intval($dish->dishId) ?>,<?= floatval($dish->dishPrice) ?> );openNav();"></button>
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
              <i class="fa-regular fa-star full"></i>
              <i class="fa-regular fa-star full"></i>
              <i class="fa-regular fa-star full"></i>
              <i class="fa-regular fa-star full"></i>
              <i class="fa-regular fa-star full"></i>
              <p><?= $review->reviewRating ?></p>
            </h3>
          </div>
          <p id="reviewBody"> <?= $review->reviewText ?> </p>
        </div>
        <?php if ($isOwner || !($response->reviewText === "")) { ?>
          <section class="responseBox">
            <?php if ($isOwner && ($response->reviewText === "")) { ?>
              <p id="error_messages" style="color: #946B6B">
                <?php if (isset($_SESSION['ERROR_ADD_RES'])) echo htmlentities($_SESSION['ERROR_ADD_RES']);
                unset($_SESSION['ERROR_ADD_RES']) ?>
              </p>
              <button> Respond </button>
              <form action="../actions/action_add_response.php" method="post">
                <input type="text" id="resposeBody" name="responseText" placeholder="Type your response">
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
  <section id="orders">
    <?php foreach ($restaurantOrders as $order) { ?>
      <div class="order">
        <div class=OrderInfo>
          <p> <?= Customer::getCustomer($db, $order->customerId)->userName ?></p>
          <p> <?= $order->orderDate ?></p>
        </div>
        <form id="alterState">
          <input hidden id="orderId" name="orderId" value="<?= $order->orderId ?>">
          <select onchange="alterState()" name="state" id="orderState">
            <option> <?= $order->orderState ?></option>
            <?php foreach (CustomerOrder::getOtherStates($order->orderState) as $state) { ?>
              <option> <?= $state ?> </option>
            <?php } ?>
          </select>
        </form>
      </div>
    <?php } ?>
  </section>
  </section>

<?php } ?>