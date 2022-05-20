<?php
  declare(strict_types = 1);

  class CustomerOrder {
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

    static function getCustomerOrders(PDO $db, int $customerId) : array {
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


     static function getCustomerOrdersDishes(PDO $db, int $customerId) : array {
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


     static function getOrderDishes(PDO $db, int $orderId) : array {
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
        intval($dish['RestaurantId'])
       );
      }
      return $dishes;
    }

    static function getTotalPrice(array $dishes) : float {
      $total=0;
      foreach($dishes as $dish){
          $total=$total+$dish->dishPrice;
      }
      return floatval($total);
    }

  
  }
?>