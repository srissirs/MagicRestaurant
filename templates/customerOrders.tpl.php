<?php

declare(strict_types=1);

require_once('database/customerOrders.class.php')
?>

<?php function drawCustomerOrders(array $pastOrders)
{
  $db = getDatabaseConnection(); ?>
  <div class="PastOrdersHeader">
    <h2>Past Orders</h2>
  </div>

  <section class="pastOrders">
    <?php foreach ($pastOrders as $pastOrder) {
      $dishes = CustomerOrder::getOrderDishes($db, $pastOrder->orderId);
    ?>
      <section class="month">
        <h3> <?= $pastOrder->orderDate ?></h3>
        <div class="pastOrderBox">
          <div class="pastOrder">
            <img src="https://picsum.photos/200?1" alt="Dish Photo">
            <div class="information">
              <a href="restaurant.php?id=<?= $pastOrder->restaurantId ?>" id="name"> <?= Restaurant::getRestaurant($db, $pastOrder->restaurantId)->restaurantName ?> </a><br>
              <p id="total"> <?= sizeof($dishes) ?> items for <?= CustomerOrder::getTotalPrice($dishes) ?>$ </p>
              <?php foreach ($dishes as $dish) {  ?>

                <div class = "pastDish">
                  <p id="quantity"> 1 </p>
                  <p id="dishName"> <?= $dish->dishName ?></p>
              </div>

              <?php } ?>
            </div>
            <button type="button" class="open-button" onclick="openForm()" id="review"> Leave a review </button>
          </div>
          <div class="review-popup" id="myForm" style="display: none;">
            <form action="../action_add_review.php" class="form-container" method="post">
              <input type="text" name="reviewText" placeholder="  Write your review" required>
              <input type="number" name="reviewRating" required>
              <input type="number" name="restaurantId" style="display: none;" value=<?= $pastOrder->restaurantId?>>
              <button type="submit" class="btn">Submit review</button>
            </form>
          </div>
        </div>
      </section>
    <?php } ?>
  </section>

<?php } ?>

