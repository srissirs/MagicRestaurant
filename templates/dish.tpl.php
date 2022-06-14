<?php 
  declare(strict_types = 1); 

  require_once('database/dish.class.php');
  require_once('database/restaurant.class.php');
?>

<?php function drawDish(Dish $dish, Restaurant $restaurant) { ?>
  <h2><?=$dish->dishName?></h2>
  <h3><a href="restaurant.php?id=<?=$restaurant->restaurantId?>"><?=$restaurant->restaurantName?></a></h3>      
<?php } ?>