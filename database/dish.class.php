<?php

declare(strict_types=1);

class Dish
{
  public int $dishId;
  public string $dishName;
  public float $dishPrice;
  public int $restaurantId;
  public string $dishCategory;
  public int $photo;


  public function __construct(int $dishId, string $dishName, float $dishPrice, int $restaurantId, string $dishCategory, int $photo)
  {
    $this->dishId = $dishId;
    $this->dishName = $dishName;
    $this->dishPrice = $dishPrice;
    $this->restaurantId = $restaurantId;
    $this->dishCategory = $dishCategory;
    $this->photo = $photo;
  }

  static function getRestaurantDishes(PDO $db, int $restaurantId): array
  {
    $stmt = $db->prepare('
      SELECT DishId, DishName, DishPrice, Dish.RestaurantId, CategoryName, DishPhoto
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
        $dish["CategoryName"],
        intval($dish['DishPhoto'])
      );
    }
    return $dishes;
  }

  static function getDish(PDO $db, int $dishId): Dish
  {
    $stmt = $db->prepare('
        SELECT DishId, DishName, DishPrice, RestaurantId,CategoryName, DishPhoto
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
      $dish["CategoryName"],
      intval($dish['DishPhoto'])
    );
  }

  

 static function searchDishes(PDO $db, string $search, int $id) : array {
      $stmt = $db->prepare('SELECT DishId, DishName, DishPrice, RestaurantId, CategoryName, DishPhoto
      FROM Dish, Category WHERE DishName LIKE ? AND CategoryId=DishCategory AND RestaurantId = ?');
      $stmt->execute(array($search . '%',$id));

  
      $dishes = array();
  
      while ($dish = $stmt->fetch()) {
        $dishes[] = new Dish(
          intval($dish['DishId']), 
          $dish['DishName'],
          floatval($dish['DishPrice']),
          intval($dish['RestaurantId']),
          $dish['CategoryName'],
          intval($dish['DishPhoto'])
        );
      }
      return $dishes;
    }
  

  static function getDishCategory(PDO $db, string $dishCategory): int
  {
    try {
      $stmt = $db->prepare('SELECT CategoryId FROM Category WHERE CategoryName=? ');
      $stmt->execute(array($dishCategory));
      if ($categoryId = $stmt->fetch()) {
        return intval($categoryId['CategoryId']);
      }else
      return -1;
    } catch (PDOException $e) {
      return -1;
    }
  }

  static function addCategory(PDO $db, string $dishCategory, int $restaurantId): int
  {
    $stmt = $db->prepare('
     INSERT INTO Category (CategoryName) 
      VALUES (:CategoryName)
      ');
    $stmt->bindParam(':CategoryName', $dishCategory);
    $stmt->execute();
    $id = $db->lastInsertId();

    $stmt = $db->prepare('
     INSERT INTO CategoryRestaurant (RestaurantId,CategoryId) 
      VALUES (:RestaurantId, :CategoryId)
      ');
    $stmt->bindParam(':RestaurantId', $restaurantId);
    $stmt->bindParam(':CategoryId', $id);
    $stmt->execute();
    return intval($id);
  }

  static public function addDish(PDO $db, string $dishName, float $dishPrice, int $restaurantId, int $dishCategory, int $dishPhoto)
  {
    $stmt = $db->prepare('
     INSERT INTO Dish (DishName, DishPrice,RestaurantId,DishCategory, DishPhoto) 
      VALUES (:DishName, :DishPrice, :RestaurantId,:DishCategory,:DishPhoto )
      ');

    $stmt->bindParam(':DishName', $dishName);
    $stmt->bindParam(':DishPrice', $dishPrice);
    $stmt->bindParam(':RestaurantId', $restaurantId);
    $stmt->bindParam(':DishCategory', $dishCategory);
    $stmt->bindParam(':DishPhoto', $dishPhoto);

    $stmt->execute();
  }

  static function getDishPhoto(PDO $db, Dish $dish): int
  {
    try {
      $stmt = $db->prepare('SELECT DishPhoto FROM Dish WHERE DishId=? ');
      $stmt->execute(array($dish->dishId));
      if ($dishPhoto = $stmt->fetch()) {
        $photo= intval($dishPhoto['DishPhoto']);
        return $photo;
      }else
      return -1;
    } catch (PDOException $e) {
      return -1;
    }
  }
}

