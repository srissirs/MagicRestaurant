<?php
  declare(strict_types = 1);

  class ReviewResponse {
    public int $reviewId;
    public int $restaurantOwnerId;
    public string $reviewText;
    public int $reviewRating;
    

    public function __construct(int $reviewId, int $restaurantOwnerId, string $reviewText, int $reviewRating)
    {
      $this->reviewId = $reviewId;
      $this->restaurantOwnerId = $restaurantOwnerId;
      $this->reviewText = $reviewText;
      $this->reviewRating = $reviewRating;
    }

    static function getReviewResponse(PDO $db, int $reviewId) : array {
      $stmt = $db->prepare('
        SELECT ReviewId, RestaurantOwnerId, ReviewResponse.reviewText, ReviewRating
        FROM ReviewRestaurant JOIN ReviewResponse USING (ReviewId) 
        WHERE ReviewId = ?
        GROUP BY RestaurantOwnerId
      ');
      $stmt->execute(array($restaurantId));
  
      $reviewResponse = array();
  
      while ($reviewRestaurant = $stmt->fetch()) {
        $reviews[] = new ReviewRestaurant(
          intval($reviewRestaurant['ReviewId']), 
          intval($reviewRestaurant['RestaurantOwnerId']), 
          strvalue($reviewRestaurant['reviewText']),
          intval($reviewRestaurant['ReviewRating'])
        );
      }
      return $reviewResponse;
    }


    /*
    static function getReview(PDO $db, int $reviewId) : Dish {
      $stmt = $db->prepare('
        SELECT ReviewId, CustomerId, RestaurantID, ReviewText, ReviewRating
        FROM Review
        WHERE ReviewId = ?
      ');
      $stmt->execute(array($reviewId));
  
      $reviewRestaurant = $stmt->fetch();
  
      return new ReviewRestaurant(
        intval($reviewRestaurant['ReviewId']), 
          intval($reviewRestaurant['CustomerId']), 
          intval($reviewRestaurant['RestaurantId']), 
          $reviewRestaurant['ReviewText'],
          intval($reviewRestaurant['ReviewRating'])
      );
    }*/
  
  }
?>