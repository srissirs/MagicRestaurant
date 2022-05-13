<?php 
  declare(strict_types = 1); 

  require_once('database/restaurant.class.php')
?>

<?php function drawRestaurants(array $restaurants) { ?>
  <h2>Restaurants</h2>
  <section id="restaurants">
    <?php foreach($restaurants as $restaurant) { ?> 
      <article>
        <a href="restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->restaurantName?></a>
      </article>
    <?php } ?>
  </section>
<?php } ?>

<?php function drawRestaurant(Restaurant $restaurant, array $dishes) { ?>
  <restaurantHeader>
      <restaurantInfo>
  <h2><?=$restaurant->restaurantName?></h2>
  <h3> 
          <i class="fa-regular fa-star"></i>
          <i class="fa-regular fa-star"></i>
          <i class="fa-regular fa-star"></i>
          <i class="fa-regular fa-star"></i>
          <i class="fa-regular fa-star"></i>
        </h3> 
        <h4> <?=$restaurant->restaurantAddress?> </h4> 
  </restaurantInfo>
</restaurantHeader>

<restaurant>
  <restaurantTopPage>
      
        <a href="restaurantDishes.html"> Dishes </a>
        <a href="restaurantReviews.html"> Reviews </a>
      
      <form action="#">
        <select name="languages" id="lang" onchange="this.form.submit();">
          <option value="Chinese">Chinese</option>
          <option value="Italian">Italian</option>
        </select>
      </form>
    </restaurantTopPage>
  <section id="dishes">
    <?php foreach ($dishes as $dish) { ?>
              <dish>
                
                <img src="https://picsum.photos/200?1" alt="Dish Photo">
                
                <information>
                  <name>
                    <p id="name"> <?=$dish->dishName?> </p>
                    <i class="fa-regular fa-star"></i>
                  </name>
                                      <p id="category"> <?=$dish->dishCategory?> </p>

                  <price>
                                      <p id="price"> <?=$dish->dishPrice?> </p>

                    <i class="fa-solid fa-cart-shopping"></i>
                  </price>
                </information>
              </dish>      
   
</restaurant>
    <?php } ?>
  </section>

<?php } ?>