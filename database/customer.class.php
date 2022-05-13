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

    public function __construct(int $customerId, string $userName, string $firstName, string $lastName, string $customerAddress, string $customerCity, string $customerCountry, string $customerPostalCode, string $customerPhone, string $customerEmail)
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
    }

    function name() {
      return $this->firstName . ' ' . $this->lastName;
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE Customer SET Username = ?, FirstName = ?, LastName = ?, CustomerAddress = ?, CustomerCity = ?, CustomerCountry = ?, CustomerPostalCode = ?, CustomerPhone = ?, CustomerEmail = ?
        WHERE CustomerId = ?
      ');

      $stmt->execute(array($this->userName, $this->firstName, $this->lastName, $this->customerAddress, $this->customerCity, $this->customerCountry, $this->customerPostalCode, $this->customerPhone, $this->customerEmail, $this->customerId));
    }
    
    static function getCustomerWithPassword(PDO $db, string $email, string $password) : ?Customer {
      $stmt = $db->prepare('
        SELECT CustomerId, Username, FirstName, LastName, CustomerAddress, CustomerCity, CustomerCountry, CustomerPostalCode, CustomerPhone, CustomerEmail
        FROM Customer 
        WHERE lower(email) = ? AND password = ?
      ');

      $stmt->execute(array(strtolower($email), sha1($password)));
  
      if ($customer = $stmt->fetch()) {
        return new Customer(
          $customer['CustomerId'],
          $customer['Username'],
          $customer['FirstName'],
          $customer['LastName'],
          $customer['CustomerAddress'],
          $customer['CustomerCity'],
          $customer['CustomerCountry'],
          $customer['CustomerPostalCode'],
          $customer['CustomerPhone'],
          $customer['CustomerEmail']
        );
      } else return null;
    }

    static function getCustomer(PDO $db, int $id) : Customer {
      $stmt = $db->prepare('
        SELECT CustomerId, Username, FirstName, LastName, CustomerAddress, CustomerCity, CustomerCountry, CustomerPostalCode, CustomerPhone, CustomerEmail
        FROM Customer 
        WHERE CustomerId = ?
      ');

      $stmt->execute(array($id));
      $customer = $stmt->fetch();
      
      return new Customer(
          $customer['CustomerId'],
          $customer['Username'],
          $customer['FirstName'],
          $customer['LastName'],
          $customer['CustomerAddress'],
          $customer['CustomerCity'],
          $customer['CustomerCountry'],
          $customer['CustomerPostalCode'],
          $customer['CustomerPhone'],
          $customer['CustomerEmail']
      );
    }

  }
?>