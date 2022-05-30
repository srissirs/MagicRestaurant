<?php 
  declare(strict_types = 1); 

  require_once('database/customerOrders.class.php')
?>

<?php function drawCustomerOrders(array $pastOrders) { 
  $db = getDatabaseConnection();?>
    <PastOrdersHeader>
        <h2>Past Orders</h2>
    </PastOrdersHeader>
 
    <pastOrders>  
      <?php foreach($pastOrders as $pastOrder) { 
        $dishes = CustomerOrder::getOrderDishes($db, $pastOrder->orderId);
        ?>         
        <month>
          <h3> <?= $pastOrder->orderDate?></h3>
            <pastOrderBox>
              <pastOrder>
                <img src="https://picsum.photos/200?1" alt="Dish Photo">
                <information>
                  <h3 id="name"> <?= Restaurant::getRestaurant($db,$pastOrder->restaurantId)->restaurantName ?> </h3><br>
                  <p id="total"> <?=  sizeof($dishes)?> items for <?= CustomerOrder::getTotalPrice($dishes) ?>$ </p>
                  <?php foreach($dishes as $dish) {  ?>
                  
                  <pastDish>
                    <p id="quantity"> 1 </p>
                    <p id="dishName"> <?= $dish->dishName ?></p>
                    <i class="fa-solid fa-cart-shopping"></i>
                  </pastDish>

                  <?php } ?>
                </information>
                <button type="button" class="open-button" onclick="openForm()" id="review"> Leave a review </button>
              </pastOrder>
              <div class="review-popup" id="myForm">
                <form action="/action_page.php" class="form-container">
                  <input type="text" placeholder="  Write your review" name="email" required>
                  <button type="submit" class="btn">Submit review</button>
                  <button type="button" class="btn cancel" onclick="closeForm()">Cancel</button>
                </form>
              </div>
              <script>
                function openForm() {
                  document.getElementById("myForm").style.display = "block";
                }

                function closeForm() {
                  document.getElementById("myForm").style.display = "none";
                }
              </script>
            </pastOrderBox>
        </month>
      <?php } ?>
    </pastOrders>

<?php } ?>

  <pastOrders>
    
  </pastOrders>
 
  