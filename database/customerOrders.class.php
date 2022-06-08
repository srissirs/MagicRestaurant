<?php

declare(strict_types=1);

class CustomerOrder
{
  public int $orderId;
  public int $customerId;
  public int $restaurantId;
  public string $orderState;
  public array $dishes;
  public string $orderDate;


  public function __construct(int $orderId, int $customerId, int $restaurantId, string $orderState, string $orderDate)
  {
    $this->orderId = $orderId;
    $this->customerId = $customerId;
    $this->restaurantId = $restaurantId;
    $this->orderState = $orderState;
    $this->orderDate = $orderDate;
  }

  static function getCustomerOrders(PDO $db, int $customerId): array
  {
    $stmt = $db->prepare('
        SELECT OrderId, CustomerId, RestaurantId, OrderState, OrderDate
        FROM CustomerOrder 
        WHERE CustomerId = ?
      ');
    $stmt->execute(array($customerId));

    $orders = array();

    while ($order = $stmt->fetch()) {
      $orders[] = new CustomerOrder(
        intval($order['OrderId']),
        intval($order['CustomerId']),
        intval($order['RestaurantId']),
        $order['OrderState'],
        strval($order['OrderDate']),
      );
    }
    return $orders;
  }


  static function getCustomerOrdersDishes(PDO $db, int $customerId): array
  {
    $stmt = $db->prepare('
        SELECT OrderId, CustomerId, RestaurantId, OrderState, OrderDate
        FROM CustomerOrder 
        WHERE CustomerId = ?
        GROUP BY CustomerId
      ');
    $stmt->execute(array($customerId));

    $orders = array();

    while ($order = $stmt->fetch()) {
      $orders[] = new CustomerOrder(
        intval($order['OrderId']),
        intval($order['CustomerId']),
        intval($order['RestaurantId']),
        $order['OrderState'],
        $order['OrderDate']
      );
    }
    return $orders;
  }


  static function getOrderDishes(PDO $db, int $orderId): array
  {
    $stmt = $db->prepare('
        SELECT distinct *
        FROM CustomerOrder JOIN DishOrder JOIN Dish
        WHERE CustomerOrder.orderId = ? AND Dish.dishId=DishOrder.dishId and CustomerOrder.orderId=DishOrder.orderId
      ');
    $stmt->execute(array($orderId));

    $dishes = array();

    while ($dish = $stmt->fetch()) {
      $dishes[] = new Dish(
        intval($dish['DishId']),
        strval($dish['DishName']),
        floatval($dish['DishPrice']),
        intval($dish['RestaurantId']),
        strval($dish['DishCategory'])
      );
    }
    return $dishes;
  }

  static function getQuantity(PDO $db, int $orderId, int $dishId): int
  {
    $stmt = $db->prepare('
      SELECT DishOrder.Quantity
        FROM CustomerOrder JOIN DishOrder 
        WHERE CustomerOrder.OrderId = DishOrder.OrderId AND DishOrder.DishId=? and DishOrder.OrderId=?
      ');
    $stmt->execute(array( $dishId,$orderId));

    if ($quantity = $stmt->fetch()) {
      return intval($quantity['Quantity']);
    }else return 0;
  }

  static function getTotalPrice(array $dishes): float
  {
    $total = 0;
    foreach ($dishes as $dish) {
      $total = $total + $dish->dishPrice;
    }
    return floatval($total);
  }
  static public function addOrder(PDO $db, int $customerid, int $restaurantId, string $orderState, string $orderDate): int
  {
    $stmt = $db->prepare('
       INSERT INTO CustomerOrder ( CustomerId, RestaurantId, OrderState, OrderDate) 
        VALUES (:CustomerId, :RestaurantId, :OrderState, :OrderDate)
        ');

    $stmt->bindParam(':CustomerId', $customerid);
    $stmt->bindParam(':RestaurantId', $restaurantId);
    $stmt->bindParam(':OrderState', $orderState);
    $stmt->bindParam(':OrderDate', $orderDate);

    $stmt->execute();
    return intval($db->lastInsertId());
  }

  static public function addDishOrder(PDO $db, int $dishId, int $quantity, int $orderId)
  {
    $stmt = $db->prepare('
       INSERT INTO DishOrder ( OrderId, DishId, Quantity) 
        VALUES (:OrderId, :DishId, :Quantity)
        ');

    $stmt->bindParam(':OrderId', $orderId);
    $stmt->bindParam(':DishId', $dishId);
    $stmt->bindParam(':Quantity', $quantity);

    $stmt->execute();
  }
}
