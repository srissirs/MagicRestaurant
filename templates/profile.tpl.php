<?php

declare(strict_types=1);

require_once('database/connection.database.php');

require_once('database/customer.class.php');
?>




<?php function drawProfile(Customer $customer)
{ ?>
  <div class="profileHeader">
    <h2><?= $customer->firstName ?> <?= $customer->lastName ?></h2>
    <button type="submit" onclick="toggle()">
      <i class="fa-solid fa-pen-to-square"></i>
    </button>
  </div>
  <section class="customerInformation">
    <img src="../images/user-profile.png">
    <form action="../action_edit_profile.php" method="post">
      <div>
        <label for="first_name">First Name:</label>
        <p class="unedited"><?= $customer->firstName ?></p>
        <input type="text" name="first_name" class="editing" style="display: none;" value="<?= $customer->firstName ?>">
      </div>
      <div>
        <label for="last_name">Last Name:</label>
        <p class="unedited"><?= $customer->lastName ?></p>
        <input type="text" name="last_name" class="editing" style="display: none;" value="<?= $customer->lastName ?>">
      </div>
      <div>
        <label for="username">Username:</label>
        <p class="unedited"><?= $customer->userName ?></p>
        <input type="text" name="username" class="editing" style="display: none;" value="<?= $customer->userName ?>">
      </div>
      <div>
        <label for="email_address">Email Address:</label>
        <p class="unedited"><?= $customer->customerEmail ?></p>
        <input type="text" name="email_address" class="editing" style="display: none;" value="<?= $customer->customerEmail ?>">
      </div>
      <div>
        <label for="address">Address:</label>
        <p class="unedited"><?= $customer->customerAddress ?></p>
        <input type="text" name="address" class="editing" style="display: none;" value="<?= $customer->customerAddress ?>">
      </div>
      <div>
        <label for="city">City:</label>
        <p class="unedited"><?= $customer->customerCity ?></p>
        <input type="text" name="city" class="editing" style="display: none;" value="<?= $customer->customerCity ?>">
      </div>
      <div>
        <label for="country">Country:</label>
        <p class="unedited"><?= $customer->customerCountry ?></p>
        <input type="text" name="country" class="editing" style="display: none;" value="<?= $customer->customerCountry ?>">
      </div>
      <div>
        <label for="postal_code">Postal Code:</label>
        <p class="unedited"><?= $customer->customerPostalCode ?></p>
        <input type="text" name="postal_code" class="editing" style="display: none;" value="<?= $customer->customerPostalCode ?>">
      </div>
      <div>
        <label for="phone">Phone:</label>
        <p class="unedited"><?= $customer->customerPhone ?></p>
        <input type="text" name="phone" class="editing" style="display: none;" value="<?= $customer->customerPhone ?>">
      </div>
      <button class="customerInfoBtn" style="display: none;" type="submit">Save</button>
    </form>
  </section>
<?php } ?>

<?php function drawProfileRestaurants(array $restaurants)
{ ?>
  <section class="ownedRestaurants">
    <h3> Restaurants</h3>
    <?php foreach ($restaurants as $restaurant) {?>
      
      <section class="ownedRestaurant">
        <form action="../action_edit_restaurant.php" method="post">
          <input type="number" name="id"  style="display: none;" value=<?= $restaurant->restaurantId ?>>
          <div>
            <a href="restaurant.php?id=<?= $restaurant->restaurantId ?>"> <?= $restaurant->restaurantName ?> </a>
            <input type="text" name="restaurant_name" style="display: none;" value="<?= $restaurant->restaurantName ?>">
          </div>
          <div>
            <p> <?= $restaurant->restaurantAddress ?> </p>
            <input type="text" name="restaurant_address" style="display: none;" value="<?= $restaurant->restaurantAddress ?>">
          </div>
          <button type="submit"  style="display: none;">Save</button>
        </form>
        <button type="submit" onclick="toggleEditRestaurant()">
          <i class="fa-solid fa-pen-to-square"></i>
        </button>
      </section>
    <?php } ?>
    <button> Add a restaurant </button>
  </section>
<?php } ?>