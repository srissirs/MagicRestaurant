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


    static function getCategories(PDO $db, int $restaurantId) : array {
      $stmt = $db->prepare('SELECT CategoryName FROM Category 
                            JOIN CategoryRestaurant 
                            WHERE CategoryRestaurant.CategoryId=Category.CategoryId 
                            AND RestaurantId = ?');
      $stmt->execute(array($restaurantId));
      $categories= array();
      while ($category = $stmt->fetch()) {
        print(strval($categories['CategoryName']));
        $categories[]=$category['CategoryName'];
      }
      return $categories;
    }

   

    static function searchRestaurants(PDO $db, string $search) : array {
      $stmt = $db->prepare('SELECT *  FROM Restaurant WHERE RestaurantName LIKE ?');
      $stmt->execute(array($search . '%'));

  
      $restaurants = array();
        while ($restaurant = $stmt->fetch()) {
          $restaurants[] = new Restaurant(
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