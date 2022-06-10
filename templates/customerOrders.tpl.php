<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database/customerOrders.class.php')
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
              <a href="../pages/restaurant.php?id=<?= $pastOrder->restaurantId ?>" id="name"> <?= Restaurant::getRestaurant($db, $pastOrder->restaurantId)->restaurantName ?> </a><br>
              <p id="total"> Total price: </p>
              <?php foreach ($dishes as $dish) {  ?>

                <div class="pastDish">
                  <p id="quantity"><?= CustomerOrder::getQuantity($db, $pastOrder->orderId, $dish->dishId) ?></p>
                  <p id="dishName"> <?= $dish->dishName ?></p>
                  <p id="price"> <?= $dish->dishPrice ?></p>
                </div>

              <?php } ?>
            </div>
            <div class="pastOrderLabels">
              <button type="button" class="open-button" onclick="openForm()" id="review"> Leave a review </button>
              <div class="OrderState"> Order State: <?= $pastOrder->orderState ?></div>
            </div>

          </div>
          <div class="review-popup" id="myForm" style="display: none;">
            <form action="../actions/action_add_review.php" class="form-container" method="post">
              <input type="text" name="reviewText" placeholder="  Write your review" required>
              <div> Rating: <input type="number" name="reviewRating" required max="5" min="0"> </div>
              <input type="number" name="restaurantId" hidden value=<?= $pastOrder->restaurantId ?> >
              <button type="submit" class="btn">Submit review</button>
            </form>
          </div>
        </div>
      </section>
    <?php } ?>
  </section>

<?php } ?>