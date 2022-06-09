<?php 
  declare(strict_types = 1); 

  require_once('database/restaurant.class.php');
  require_once('database/review.class.php');
  require_once('database/reviewResponse.class.php');
  require_once('database/connection.database.php');



  
?>


<?php

function drawRestaurantReview(Restaurant $restaurant, array $reviews) { $db = getDatabaseConnection();?>
  
  <section id="reviews">
    <?php foreach ($reviews as $review) { ?>
        <reviewBox>
                <review>
                    <info>
                        <p id="name"> User Name </p>
                        <h3> 
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </h3> 
                    </info>
                    <p id="reviewBody"> <?=$review->reviewText?>  </p>
                </review>                <p id="response"> <?= ReviewResponse::getReviewResponse($db, intval($review->reviewId))->reviewText?> </p>

            </reviewBox>
</restaurant>
    <?php } ?>
  </section>

<?php } ?>