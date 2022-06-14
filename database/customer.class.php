<?php

declare(strict_types=1);
require_once('restaurant.class.php');

class Customer
{
  public int $customerId;
  public string $userName;
  public string $firstName;
  public string $lastName;
  public string $customerAddress;
  public string $customerCity;
  public string $customerCountry;
  public string $customerPostalCode;
  public string $customerPhone;
  public string $customerEmail;
  public int $restaurantOwner;
  public string $passwordHash;


  public function __construct(int $customerId, string $userName, string $firstName, string $lastName, string $customerAddress, string $customerCity, string $customerCountry, string $customerPostalCode, string $customerPhone, string $customerEmail, int $restaurantOwner, string $passwordHash)
  {
    $this->customerId = $customerId;
    $this->userName = $userName;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->customerAddress = $customerAddress;
    $this->customerCity = $customerCity;
    $this->customerCountry = $customerCountry;
    $this->customerPostalCode = $customerPostalCode;
    $this->customerPhone = $customerPhone;
    $this->customerEmail = $customerEmail;
    $this->restaurantOwner = $restaurantOwner;
    $this->passwordHash = $passwordHash;
  }

  function name()
  {
    return $this->firstName . ' ' . $this->lastName;
  }

  function saveProfile($db)
  {
    $stmt = $db->prepare('
        UPDATE Customer SET Username = ?, FirstName = ?, LastName = ?, CustomerAddress = ?, CustomerCity = ?, CustomerCountry = ?, CustomerPostalCode = ?, CustomerPhone = ?, CustomerEmail = ?, Password = ?
        WHERE CustomerId = ?
      ');

    $stmt->execute(array($this->userName, $this->firstName, $this->lastName, $this->customerAddress, $this->customerCity, $this->customerCountry, $this->customerPostalCode, $this->customerPhone, $this->customerEmail, $this->passwordHash, $this->customerId));
  }

  static function getCustomerWithPassword(PDO $db, string $customerEmail, string $password): ?Customer
  {
    $stmt = $db->prepare('
        SELECT *
        FROM Customer 
        WHERE lower(CustomerEmail) = ?
      ');

    $stmt->execute(array(strtolower($customerEmail)));

    if ($customer = $stmt->fetch()) {
      if(password_verify($password,$customer['Password'])){
        return new Customer(
          intval($customer['CustomerId']),
          $customer['Username'],
          $customer['FirstName'],
          $customer['LastName'],
          $customer['CustomerAddress'],
          $customer['CustomerCity'],
          $customer['CustomerCountry'],
          $customer['CustomerPostalCode'],
          $customer['CustomerPhone'],
          $customer['CustomerEmail'],
          intval($customer['RestaurantOwner']),
          $customer['Password']
        );
      }
    } 
    return null;
  }

  static public function getCustomer(PDO $db, int $id): Customer
  {
    $stmt = $db->prepare('
        SELECT CustomerId, Username, FirstName, LastName, CustomerAddress, CustomerCity, CustomerCountry, CustomerPostalCode, CustomerPhone, CustomerEmail, Password, RestaurantOwner
        FROM Customer 
        WHERE CustomerId = ?
      ');

    $stmt->execute(array($id));
    if ($customer = $stmt->fetch()) {

      return new Customer(
        intval($customer['CustomerId']),
        $customer['Username'],
        $customer['FirstName'],
        $customer['LastName'],
        $customer['CustomerAddress'],
        $customer['CustomerCity'],
        $customer['CustomerCountry'],
        $customer['CustomerPostalCode'],
        $customer['CustomerPhone'],
        $customer['CustomerEmail'],
        intval($customer['RestaurantOwner']),
        $customer['Password']
      );
    } else return null;
  }
  static public function getID(PDO $db, $username): int
  {
    try {
      $stmt = $db->prepare('SELECT CustomerId FROM Customer WHERE Username = ?');
      $stmt->execute(array($username));
      if ($row = $stmt->fetch()) {
        return intval($row['CustomerId']);
      }
    } catch (PDOException $e) {
      return -1;
    }
  }



  static public function duplicateUsername(PDO $db, $username)
  {

    try {
      $stmt = $db->prepare('SELECT CustomerId FROM Customer WHERE Username = ?');
      $stmt->execute(array($username));
      return $stmt->fetch()  !== false;
    } catch (PDOException $e) {
      return true;
    }
  }

  static public function duplicateEmail(PDO $db, $email)
  {

    try {
      $stmt = $db->prepare('SELECT CustomerId FROM Customer WHERE CustomerEmail = ?');
      $stmt->execute(array($email));
      return $stmt->fetch()  !== false;
    } catch (PDOException $e) {
      return true;
    }
  }

  static public function getFavoriteRestaurants(PDO $db,int $customerId): array {
    $stmt=$db->prepare('SELECT *
    FROM Restaurant,RestaurantFavorite
    WHERE CustomerId=? 
    AND Restaurant.RestaurantId=RestaurantFavorite.RestaurantId');
    $stmt->execute(array($customerId));
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

  static public function getFavoriteDishes(PDO $db,int $customerId): array {
    $stmt=$db->prepare('SELECT *
    FROM Dish,DishFavorite,Category
    WHERE CustomerId=? 
    AND DishCategory=CategoryId
    AND Dish.DishId=DishFavorite.DishId');
    $stmt->execute(array($customerId));
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

  
  static public function isDishFavorited(PDO $db,int $customerId,int $dishId):bool  {
    
    try {
      $stmt = $db->prepare('SELECT * FROM DishFavorite WHERE CustomerId=? AND DishId=?');
      $stmt->execute(array($customerId,$dishId));
      return $stmt->fetch() !== false;
    
    }catch(PDOException $e) {
      return true;
    }
  }
  static public function isRestaurantFavorited(PDO $db,int $customerId,int $restaurantId):bool  {
    
    try {
      $stmt = $db->prepare('SELECT * FROM RestaurantFavorite WHERE CustomerId=? AND RestaurantId=?');
      $stmt->execute(array($customerId,$restaurantId));
      return $stmt->fetch() !== false;
    
    }catch(PDOException $e) {
      return true;
    }
  }

static public function createFavDish(PDO $db,int $customerId,int $dishId) : void{
  $stmt = $db->prepare('INSERT INTO DishFavorite(DishId,CustomerId) VALUES (:DishId,:CustomerId)');
  $stmt->bindParam(':DishId', $dishId);
  $stmt->bindParam(':CustomerId', $customerId);
  $stmt->execute();
}

static public function createFavRestaurant(PDO $db,int $customerId,int $restaurantId) : void{
  $stmt = $db->prepare('INSERT INTO RestaurantFavorite(RestaurantId,CustomerId) VALUES (:RestaurantId,:CustomerId)');
  $stmt->bindParam(':RestaurantId', $restaurantId);
  $stmt->bindParam(':CustomerId', $customerId);
  $stmt->execute();
}

static public function deleteFavDish(PDO $db, int $customerId,int $dishId ) : void{
  $stmt = $db->prepare('DELETE FROM DishFavorite WHERE DishId=:DishId AND CustomerId=:CustomerId;');
  $stmt->bindParam(':DishId', $dishId);
  $stmt->bindParam(':CustomerId', $customerId);
  $stmt->execute();
}

static public function deleteFavRestaurant(PDO $db, int $customerId,int $restaurantId ) : void{
  $stmt = $db->prepare('DELETE FROM RestaurantFavorite WHERE RestaurantId=:RestaurantId AND CustomerId=:CustomerId;');
  $stmt->bindParam(':RestaurantId', $restaurantId);
  $stmt->bindParam(':CustomerId', $customerId);
  $stmt->execute();
}


  static public function createUser($db, $username, $firstName, $lastName, $address, $city, $country, $postalCode, $phone, $email, $password, $restaurantOwner): int
  {
    $options = ['cost' => 12];
    $passwordHash = password_hash($password,PASSWORD_DEFAULT,$options);

    $stmt = $db->prepare('INSERT INTO Customer ( FirstName, LastName, CustomerAddress, CustomerCity, CustomerCountry, CustomerPostalCode, CustomerPhone, CustomerEmail, Password,Username, RestaurantOwner) 
        VALUES (:FirstName,:LastName,:CustomerAddress,:CustomerCity,:CustomerCountry,:CustomerPostalCode, :CustomerPhone, :CustomerEmail,:Password, :Username,:RestaurantOwner)');

    $stmt->bindParam(':FirstName', $firstName);
    $stmt->bindParam(':LastName', $lastName);
    $stmt->bindParam(':CustomerAddress', $address);
    $stmt->bindParam(':CustomerCity', $city);
    $stmt->bindParam(':CustomerCountry', $country);
    $stmt->bindParam(':CustomerPostalCode', $postalCode);
    $stmt->bindParam(':CustomerPhone', $phone);
    $stmt->bindParam(':CustomerEmail', $email);
    $stmt->bindParam(':Password', $passwordHash);
    $stmt->bindParam(':Username', $username);
    $stmt->bindParam(':RestaurantOwner', $restaurantOwner);

    $stmt->execute();
    $id = Customer::getID($db, $username);

    return $id;
  }

  static function getCustomerRestaurants(PDO $db, int $customerId): array
  {
    $stmt = $db->prepare('
        SELECT Restaurant.RestaurantId, RestaurantName, RestaurantAddress, RestaurantCity, RestaurantCountry, RestaurantPostalCode, RestaurantPhone, Rating
        FROM Restaurant, Customer,RestaurantOwner
        WHERE Customer.CustomerId = ?
        AND Customer.CustomerId = RestaurantOwner.RestaurantOwnerId
        AND RestaurantOwner.RestaurantId = Restaurant.RestaurantId
        Group By Restaurant.RestaurantId;
        ');
    $stmt->execute(array($customerId));

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

  static function getCustomerRestaurant(PDO $db, int $customerId, int $restaurantId): Restaurant
  {
    $stmt = $db->prepare('
    SELECT Restaurant.RestaurantId, RestaurantName, RestaurantAddress, RestaurantCity, RestaurantCountry, RestaurantPostalCode, RestaurantPhone, Rating
    FROM Restaurant, Customer,RestaurantOwner
    WHERE Customer.CustomerId = ?
    AND Customer.RestaurantOwner = RestaurantOwner.RestaurantOwnerId
    AND RestaurantOwner.RestaurantId = Restaurant.RestaurantId
    AND Restaurant.RestaurantId = ?
    ;
    ');
    $stmt->execute(array($customerId, $restaurantId));

    if ($restaurant = $stmt->fetch()) {
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
}
