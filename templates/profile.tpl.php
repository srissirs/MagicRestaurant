<?php

declare(strict_types=1);

require_once('database/connection.database.php');

require_once('database/customer.class.php');
?>




<?php function drawProfile(Customer $customer)
{ ?>
  <div class="profileHeader">
    <h2><?= $customer->firstName ?> <?= $customer->lastName ?></h2>
    <i class="fa-solid fa-pen-to-square"></i>
  </div>
  <section class="customerInformation">
    <img src="../images/user-profile.png">
    <div>
      <div class="infoTypes">
        <p> Full Name </p>
        <p> Username </p>
        <p> Email Address </p>
        <p> Address </p>
        <p> City </p>
        <p> Country </p>
        <p> Postal Code </p>
        <p> Phone </p>
      </div>

      <div class="personalInfo">
        <p> <?= $customer->firstName ?> <?= $customer->lastName ?> </p>
        <p> <?= $customer->userName ?> </p>
        <p> <?= $customer->customerEmail ?> </p>
        <p> <?= $customer->customerAddress ?> </p>
        <p> <?= $customer->customerCity ?> </p>
        <p> <?= $customer->customerCountry ?> </p>
        <p> <?= $customer->customerPostalCode ?> </p>
        <p> <?= $customer->customerPhone ?> </p>
      </div>
    </div>
  </section>
<?php } ?>

<?php function drawProfileRestaurants(array $restaurants)
{ ?>


  <section class="ownedRestaurants">
    <h3> Restaurants</h3>
    <?php foreach ($restaurants as $restaurant) { ?>
      <section class="ownedRestaurant">
        <div>
          <a href="restaurant.php?id=<?= $restaurant->restaurantId ?>"> <?= $restaurant->restaurantName ?> </a>
          <i class="fa-solid fa-pen-to-square"></i>
        </div>
        <p> <?= $restaurant->restaurantAddress ?> </p>
      </section>
    <?php } ?>
    <button> Add a restaurant </button>
  </section>
<?php } ?>