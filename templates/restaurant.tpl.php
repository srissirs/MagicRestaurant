<?php

declare(strict_types=1);

require_once('database/connection.database.php');

require_once('database/restaurant.class.php');
require_once('database/review.class.php');
require_once('database/reviewResponse.class.php');

require_once('database/customer.class.php');
?>


<?php function drawfav(){ ?>
  <button><i class="fa fa-star checked full"></i></button>
 <?php } ?>

 <?php function drawstr(){ ?>
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
        <p> <?=$restaurant->rating?> </p>
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

<?php function drawRestaurant(Restaurant $restaurant, array $dishes, array $reviews, array $categories,array $favorites,PDO $db)
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
        <select>
          <option value="Tudo"> Tudo </option>
          <?php  foreach($categories as $category){?>
              <option value="<?=$category?>" > <?=$category?> </option>
            <?php } ?>
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
              <form action="action_favorite_dish.php" method="post" class="register_form">
              <input type="number" id="dishId" name="dishId" style="display:none " value=<?=$dish->dishId?>>
              <input type="number" id="customerId" name="customerId" style="display:none " value=<?=$_SESSION['userId']?>>
              <input type="number" id="restaurantId" name="restaurantId" style="display:none " value=<?=$restaurant->restaurantId?>>
              <?php if(Customer::isFavorited($db,$_SESSION['userId'],$dish->dishId)){
                drawfav();
              }else{
                drawstr();
              }
             ?>
             
             </form>
            </div>
            <category>
                    <p id="category"> <?=$dish->dishCategory?> </p>
                </category>
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
            <i class="fa fa-star checked"></i>
            <i class="fa fa-star checked"></i>
            <i class="fa fa-star checked"></i>
            <i class="fa fa-star checked"></i>
            <i class="fa fa-star checked"></i>
              <p><?=$review->reviewRating?></p>
            </h3>
          </div>
          <p id="reviewBody"> <?= $review->reviewText ?> </p>
        </div>
        <p id="response"> Resposta: <?= $response->reviewText ?> </p>

      </div>
      <?php } ?>
  </section>

</section>

<?php } ?>