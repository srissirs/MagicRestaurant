<?php 
  declare(strict_types = 1); 

    require_once('database/connection.database.php');

  require_once('database/restaurant.class.php');
  require_once('database/review.class.php');
  require_once('database/reviewResponse.class.php');
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

<?php function drawRestaurantHeader(Restaurant $restaurant) { ?>
  <restaurantHeader>
      <restaurantInfo>
  <h2><?=$restaurant->restaurantName?></h2>
  <h3> 
          <p id="rating"> <?=$restaurant->rating?> </p>
          <i class="fa fa-star checked"></i>
          <i class="fa fa-star checked"></i>
          <i class="fa fa-star checked"></i>
          <i class="fa fa-star checked"></i>
          <i class="fa fa-star checked"></i>
        </h3> 
        <h4> <?=$restaurant->restaurantAddress?> </h4> 
  </restaurantInfo>
</restaurantHeader>
<?php } ?>

<?php function drawRestaurant(Restaurant $restaurant, array $dishes, array $reviews, array $categories) { ?>
<restaurant>
  <restaurantTopPage>
        <a > Dishes </a>
        <a> Reviews </a>
      <form action="#">
        <select>
          <option value="Tudo"> Tudo </option>
          <?php  foreach($categories as $category){?>
              <option value="<?=$category?>" > <?=$category?> </option>
            <?php } ?>
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

                  <category>
                    <p id="category"> <?=$dish->dishCategory?> </p>
                </category>

                  <price>
                      <p id="price"> <?=$dish->dishPrice?> </p>

                    <i class="fa-solid fa-cart-shopping"></i>
                  </price>
                  
                  
                </information>
              </dish> 
              
            
   
</restaurant>
    <?php } ?>
  </section>

   <section id="reviews">
    <?php foreach ($reviews as $review) {
      $db = getDatabaseConnection();
      $response = ReviewResponse::getReviewResponse($db, intval($review->reviewId));
       ?>
        <reviewBox>
                <review>
                    <info>
                        <p id="name"> <?=ReviewRestaurant::getReviewerName($db, intval($review->customerId))?>  </p>
                        <h3> 
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </h3> 
                    </info>
                    <p id="reviewBody"> <?=$review->reviewText?>  </p>
                </review>                
                <p id="response"> Resposta: <?= $response->reviewText?> </p>

            </reviewBox>
</restaurant>
    <?php } ?>
  </section>

<?php } ?>