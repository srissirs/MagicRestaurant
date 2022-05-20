<?php 
  declare(strict_types = 1); 

  require_once('database/restaurant.class.php');
  require_once('database/review.class.php');
  require_once('database/reviewResponse.class.php');
  require_once('database/connection.database.php');
  
?>


<?php

function drawRestaurantReview(Restaurant $restaurant, array $reviews) { 
  $db = getDatabaseConnection();?>
<restaurant>
  <restaurantTopPage>
      
        <a href="restaurant.php?id= <?=$restaurant->restaurantId?>" > Dishes </a>
        <a href="restaurantReviews.php?id= <?=$restaurant->restaurantId?>"> Reviews </a>
      
      <form action="#">
        <select name="languages" id="lang" onchange="this.form.submit();">
          <option value="Chinese">Chinese</option>
          <option value="Italian">Italian</option>
        </select>
      </form>
    </restaurantTopPage>
  <section id="reviews">
    <?php foreach ($reviews as $review) {
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