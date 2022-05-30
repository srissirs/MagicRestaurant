<?php
  declare(strict_types = 1);

  class Customer {
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
    

    public function __construct(int $customerId, string $userName, string $firstName, string $lastName, string $customerAddress, string $customerCity, string $customerCountry, string $customerPostalCode, string $customerPhone, string $customerEmail, int $restaurantOwner)
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
    }

    function name() {
      return $this->firstName . ' ' . $this->lastName;
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE Customer SET Username = ?, FirstName = ?, LastName = ?, CustomerAddress = ?, CustomerCity = ?, CustomerCountry = ?, CustomerPostalCode = ?, CustomerPhone = ?, CustomerEmail = ?, Password = ?, RestaurantOwner = ?
        WHERE CustomerId = ?
      ');

      $stmt->execute(array($this->userName, $this->firstName, $this->lastName, $this->customerAddress, $this->customerCity, $this->customerCountry, $this->customerPostalCode, $this->customerPhone, $this->customerEmail, $this->customerId));
    }
    
    static function getCustomerWithPassword(PDO $db, string $customerEmail, string $password) : ?Customer {
      $stmt = $db->prepare('
        SELECT CustomerId, Username, FirstName, LastName, CustomerAddress, CustomerCity, CustomerCountry, CustomerPostalCode, CustomerPhone, CustomerEmail, RestaurantOwner
        FROM Customer 
        WHERE lower(CustomerEmail) = ? AND Password = ?
      ');

      $stmt->execute(array(strtolower( $customerEmail), sha1($password)));
  
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
          intval($customer['RestaurantOwner'])
        );
      } else return null;
    }

    static function getCustomer(PDO $db, int $id) : Customer {
      $stmt = $db->prepare('
        SELECT CustomerId, Username, FirstName, LastName, CustomerAddress, CustomerCity, CustomerCountry, CustomerPostalCode, CustomerPhone, CustomerEmail, RestaurantOwner
        FROM Customer 
        WHERE CustomerId = ?
      ');

      $stmt->execute(array($id));
      $customer = $stmt->fetch();
      
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
          intval($customer['RestaurantOwner'])
      );
    }
      static public function getID(PDO $db,$username): int{
      try {
      $stmt = $db->prepare('SELECT CustomerId FROM Customer WHERE Username = ?');
      $stmt->execute(array($username));
      if($row = $stmt->fetch()){
        return intval($row['CustomerId']);
      }
    
    }catch(PDOException $e) {
      return -1;
    }
    }



    static public function duplicateUsername(PDO $db,$username) {
 
    try {
      $stmt = $db->prepare('SELECT CustomerId FROM Customer WHERE Username = ?');
      $stmt->execute(array($username));
      return $stmt->fetch()  !== false;
    
    }catch(PDOException $e) {
      return true;
    }
  }

  static public function duplicateEmail(PDO $db,$email) {

    try {
      $stmt = $db->prepare('SELECT CustomerId FROM Customer WHERE CustomerEmail = ?');
      $stmt->execute(array($email));
      return $stmt->fetch()  !== false;
    
    }catch(PDOException $e) {
      return true;
    }
  }




    static public function createUser($db,$username, $firstName,$lastName,$address,$city,$country,$postalCode,$phone,$email,$password,$restaurantOwner) : int{

 
      $passwordHash =sha1($password);
      
     
      
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
         $id = Customer::getID($db,$username);
         
        return $id;
      

  }

  
  }
?>