<?php
  declare(strict_types = 1);

  class Restaurant {
    public int $restaurantId;
    public string $restaurantName;
    public string $restaurantAddress;
    public string $restaurantCity;
    public string $restaurantCountry;
    public string $restaurantPostalCode;
    public string $restaurantPhone;
    public float $rating;

    public function __construct(int $restaurantId, string $restaurantName, string $restaurantAddress, string $restaurantCity, string $restaurantCountry, string $restaurantPostalCode, string $restaurantPhone, float $rating)
    { 
      $this->restaurantId = $restaurantId;
      $this->restaurantName = $restaurantName;
      $this->restaurantAddress = $restaurantAddress;
      $this->restaurantCity = $restaurantCity;
      $this->restaurantCountry = $restaurantCountry;
      $this->restaurantPostalCode = $restaurantPostalCode;
      $this->restaurantPhone = $restaurantPhone;
      $this->rating = $rating;
    }

    static function getRestaurants(PDO $db, int $count) : array {
      $stmt = $db->prepare('SELECT *  FROM Restaurant');
      $stmt->execute();
  
      $restaurants = array();
      while ($restaurant = $stmt->fetch()) {
        $restaurants[] = new Restaurant(
          $restaurant['RestaurantId'],
          $restaurant['RestaurantName'],
          $restaurant['RestaurantAddress'],
          $restaurant['RestaurantCity'],
          $restaurant['RestaurantCountry'],
          $restaurant['RestaurantPostalCode'],
          $restaurant['RestaurantPhone'],
          $restaurant['Rating']
        );
      }
  
      return $restaurants;
    }

    static function searchRestaurants(PDO $db, string $search, int $count) : array {
      $stmt = $db->prepare('SELECT *  FROM Restaurant ');
      $stmt->execute(array($search . '%', $count));
  
      $restaurants = array();
        while ($restaurant = $stmt->fetch()) {
          $restaurants[] = new Restaurant(
            intval($restaurant['RestaurantId']),
            $restaurants['RestaurantName'],
            $restaurants['RestaurantAddress'],
            $restaurants['RestaurantCity'],
            $restaurants['RestaurantCountry'],
            $restaurants['RestaurantPostalCode'],
            $restaurants['RestaurantPhone'],
            floatval($restaurant['Rating'])
          );
        }
      return $restaurants;
    }


    static function getRestaurant(PDO $db, int $restaurantId) : Restaurant {
      $stmt = $db->prepare('SELECT * FROM Restaurant WHERE RestaurantId=?');
      $stmt->execute(array($restaurantId));
  
      $restaurant = $stmt->fetch();

      return new Restaurant(
            intval($restaurant['RestaurantId']),
            $restaurant['RestaurantName'],
            $restaurant['RestaurantAddress'],
            $restaurant['RestaurantCity'],
            $restaurant['RestaurantCountry'],
            $restaurant['RestaurantPostalCode'],
            $restaurant['RestaurantPhone'],
            floatval($restaurant['Rating'])
          );
    }  
  }
?>