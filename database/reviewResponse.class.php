<?php
  declare(strict_types = 1);

  class ReviewResponse {
    public int $reviewId;
    public int $restaurantOwnerId;
    public string $reviewText;
    

    public function __construct(int $reviewId, int $restaurantOwnerId, string $reviewText)
    {
      $this->reviewId = $reviewId;
      $this->restaurantOwnerId = $restaurantOwnerId;
      $this->reviewText = $reviewText;
  
    }

    static function getReviewResponse(PDO $db, int $reviewId) : ReviewResponse {
      $stmt = $db->prepare('
        SELECT ReviewResponse.ReviewId, ReviewResponse.RestaurantOwnerId, ReviewResponse.reviewText
        FROM ReviewRestaurant JOIN ReviewResponse USING (ReviewId) 
        WHERE ReviewResponse.ReviewId = ?
        GROUP BY ReviewResponse.RestaurantOwnerId
      ');
      $stmt->execute(array($reviewId));
  
      $reviewResponse = $stmt->fetch();

      return new ReviewResponse(
          intval($reviewResponse['ReviewId']), 
          intval($reviewResponse['RestaurantOwnerId']), 
          strval($reviewResponse['reviewText']),
        );
    }

    static public function addResponse(PDO $db, int $ownerId, int $reviewId, string $responseText)
  {
    $stmt = $db->prepare('
     INSERT INTO ReviewResponse ( ReviewId, RestaurantOwnerId, reviewText) 
      VALUES (:ReviewId, :RestaurantOwnerId, :reviewText)
      ');

    $stmt->bindParam(':ReviewId', $reviewId);
    $stmt->bindParam(':RestaurantOwnerId', $ownerId);
    $stmt->bindParam(':reviewText', $responseText);
    $stmt->execute();
  }

  }
?>

