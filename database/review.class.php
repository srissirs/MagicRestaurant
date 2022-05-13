<?php
  declare(strict_types = 1);

  class ReviewRestaurant {
    public int $reviewId;
    public int $customerId;
    public int $restaurantId;
    public string $reviewText;
    public int $reviewRating;

    

    public function __construct(int $reviewId, int $customerId, int $restaurantId, string $reviewText, int $reviewRating )
    {
      $this->reviewId = $reviewId;
      $this->customerId = $customerId;
      $this->restaurantId = $restaurantId;
      $this->reviewText = $reviewText;
      $this->reviewRating = $reviewRating;
    }

    static function getRestaurantReviews(PDO $db, int $restaurantId) : array {
      $stmt = $db->prepare('
        SELECT ReviewId, CustomerId, RestaurantID, ReviewText, ReviewRating
        FROM ReviewRestaurant JOIN Restaurant USING (RestaurantId) 
        WHERE RestaurantId = ?
        GROUP BY ReviewId
      ');
      $stmt->execute(array($restaurantId));
  
      $reviews = array();
     
  
      while ($reviewRestaurant = $stmt->fetch()) {
        $reviews[] = new ReviewRestaurant(
          intval($reviewRestaurant['ReviewId']), 
          intval($reviewRestaurant['CustomerId']), 
          intval($reviewRestaurant['RestaurantId']), 
          strval($reviewRestaurant['ReviewText']),
          intval($reviewRestaurant['ReviewRating'])
        );
      }
      return $reviews;
    }

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
          strval($reviewRestaurant['ReviewText']),
          intval($reviewRestaurant['ReviewRating'])
      );
    }
  
  }
?>