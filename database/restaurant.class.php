<?php

declare(strict_types=1);

class Restaurant
{
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

  static function getRestaurants(PDO $db, int $count): array
  {
    $stmt = $db->prepare('SELECT *  FROM Restaurant');
    $stmt->execute();

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

  function saveRestaurant($db)
  {
    $stmt = $db->prepare('
          UPDATE Restaurant SET RestaurantName = ?, RestaurantAddress = ?
          WHERE RestaurantId = ?
        ');

    $stmt->execute(array($this->restaurantName, $this->restaurantAddress, $this->restaurantId));
  }


  static function getCategories(PDO $db, int $restaurantId): array
  {
    $stmt = $db->prepare('SELECT CategoryName FROM Category 
                            JOIN CategoryRestaurant 
                            WHERE CategoryRestaurant.CategoryId=Category.CategoryId 
                            AND RestaurantId = ?');
    $stmt->execute(array($restaurantId));
    $categories = array();
    while ($category = $stmt->fetch()) {
      $categories[] = $category['CategoryName'];
    }
    return $categories;
  }



    static function searchRestaurants(PDO $db, string $search) : array {
      $stmt = $db->prepare('SELECT *  FROM Restaurant WHERE RestaurantName LIKE ? OR Rating LIKE ?');
      $stmt->execute(array($search . '%',$search . '%'));

  
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


  static function getRestaurant(PDO $db, int $restaurantId): Restaurant
  {
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

  static public function addRestaurant(PDO $db, int $ownerId, string $restaurantName, string $restaurantAddress, string $restaurantCity, string $restaurantCountry, string $restaurantPostalCode, int $restaurantPhone, float $rating)
  {
    $stmt = $db->prepare('
     INSERT INTO Restaurant (RestaurantName, RestaurantAddress,RestaurantCity,RestaurantCountry,RestaurantPostalCode,RestaurantPhone,Rating ) 
      VALUES (:RestaurantName, :RestaurantAddress, :RestaurantCity,:RestaurantCountry,:RestaurantPostalCode,:RestaurantPhone,:Rating)
      ');

    $stmt->bindParam(':RestaurantName', $restaurantName);
    $stmt->bindParam(':RestaurantAddress', $restaurantAddress);
    $stmt->bindParam(':RestaurantCity', $restaurantCity);
    $stmt->bindParam(':RestaurantCountry', $restaurantCountry);
    $stmt->bindParam(':RestaurantPostalCode', $restaurantPostalCode);
    $stmt->bindParam(':RestaurantPhone', $restaurantPhone);
    $stmt->bindParam(':Rating', $rating);

    $stmt->execute();
    $id = $db->lastInsertId();

    $stmtt = $db->prepare('
     INSERT INTO RestaurantOwner (RestaurantOwnerId, RestaurantId ) 
      VALUES (:RestaurantOwnerId, :RestaurantId)
      ');

    $stmtt->bindParam(':RestaurantOwnerId', $ownerId);
    $stmtt->bindParam(':RestaurantId', $id);

    $stmtt->execute();
  }
  /*
  static public function getID(PDO $db, string $restaurantName, string $restaurantAddress): int
  {
    try {
      $stmt = $db->prepare('SELECT RestaurantId FROM Restaurant WHERE RestaurantName = ? AND RestaurantAddress= ?');
      $stmt->execute(array($restaurantName,$restaurantAddress ));
      if ($row = $stmt->fetch()) {
        return intval($row['RestaurantId']);
      }
    } catch (PDOException $e) {
      return -1;
>>>>>>> develop
    }
  }*/

  static function isOwner(PDO $db, int $restaurantId, int $customerId): int
  {
    $stmt = $db->prepare('SELECT * FROM RestaurantOwner WHERE RestaurantId=? AND RestaurantOwnerId=?');
    $stmt->execute(array($restaurantId, $customerId));

    if ($stmt->fetch())
      return 1;
    else return 0;
  }

  static function addCategory(PDO $db, int $restaurantId, string $category)
  {
    $stmt = $db->prepare('
     INSERT INTO Category ( CategoryName ) 
      VALUES (:CategoryName)
      ');

    $stmt->bindParam(':CategoryName', $category);
    $stmt->execute();

    $categoryId = $db->lastInsertId();

    $stmt = $db->prepare('
     INSERT INTO CategoryRestaurant ( RestaurantId, CategoryId ) 
      VALUES (:RestaurantId, :CategoryId)
      ');

      $stmt->bindParam(':RestaurantId', $restaurantId);
      $stmt->bindParam(':CategoryId', $categoryId);
      $stmt->execute();
  }
}
