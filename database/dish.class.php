<?php
  declare(strict_types = 1);

  class Dish {
    public int $dishId;
    public string $dishName;
    public float $dishPrice;
    public int $restaurantId;

    

    public function __construct(int $dishId, string $dishName, float $dishPrice, int $restaurantId )
    {
      $this->dishId = $dishId;
      $this->dishName = $dishName;
      $this->dishPrice = $dishPrice;
      $this->restaurantId = $restaurantId;
    }

    static function getRestaurantDishes(PDO $db, int $restaurantId) : array {
      $stmt = $db->prepare('
        SELECT DishId, DishName, DishPrice, RestaurantId
        FROM Dish JOIN Restaurant USING (RestaurantId) 
        WHERE RestaurantId = ?
        GROUP BY DishId
      ');
      $stmt->execute(array($restaurantId));
  
      $dishes = array();
  
      while ($dish = $stmt->fetch()) {
        $dishes[] = new Dish(
          intval($dish['DishId']), 
          $dish['DishName'],
          floatval($dish['DishPrice']),
          intval($dish['RestaurantId'])
        );
      }
      return $dishes;
    }

    static function getDish(PDO $db, int $dishId) : Dish {
      $stmt = $db->prepare('
        SELECT DishId, DishName, DishPrice, RestaurantId
        FROM Dish
        WHERE DishId = ?
      ');
      $stmt->execute(array($dishId));
  
      $dish = $stmt->fetch();
  
      return new Dish(
        intval($dish['DishId']), 
        $dish['DishName'], 
        floatval($dish['DishPrice']),
        intval($dish['RestaurantId'])
      );
    }
  
  }
?>