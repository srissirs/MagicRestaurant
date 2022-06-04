<?php
  declare(strict_types = 1);

  class Dish {
    public int $dishId;
    public string $dishName;
    public float $dishPrice;
    public int $restaurantId;
    public string $dishCategory;
    

    public function __construct(int $dishId, string $dishName, float $dishPrice, int $restaurantId, string $dishCategory )
    {
      $this->dishId = $dishId;
      $this->dishName = $dishName;
      $this->dishPrice = $dishPrice;
      $this->restaurantId = $restaurantId;
      $this->dishCategory = $dishCategory;
    }

    static function getRestaurantDishes(PDO $db, int $restaurantId) : array {
      $stmt = $db->prepare('
      SELECT DishId, DishName, DishPrice, Dish.RestaurantId, CategoryName
      FROM Dish,Restaurant,Category
      WHERE Dish.RestaurantId = ?
      AND Restaurant.RestaurantId=Dish.RestaurantId
      AND CategoryId=DishCategory
      Group By DishId;
      ');
      $stmt->execute(array($restaurantId));
  
      $dishes = array();
  
      while ($dish = $stmt->fetch()) {
        $dishes[] = new Dish(
          intval($dish['DishId']), 
          $dish['DishName'],
          floatval($dish['DishPrice']),
          intval($dish['RestaurantId']),
          $dish["CategoryName"]
        );
      }
      return $dishes;
    }

    static function getDish(PDO $db, int $dishId) : Dish {
      $stmt = $db->prepare('
        SELECT DishId, DishName, DishPrice, RestaurantId,CategoryName
        FROM Dish,Category
        WHERE DishId = ? 
        AND CategoryId=DishCategory
      ');
      $stmt->execute(array($dishId));
  
      $dish = $stmt->fetch();
  
      return new Dish(
          intval($dish['DishId']), 
          $dish['DishName'],
          floatval($dish['DishPrice']),
          intval($dish['RestaurantId']),
          $dish["CategoryName"]
        );
    }
  
  }
?>