DROP TABLE IF EXISTS Customer;
DROP TABLE IF EXISTS RestaurantOwner;
DROP TABLE IF EXISTS Restaurant;
DROP TABLE IF EXISTS Dish;
DROP TABLE IF EXISTS CustomerOrder;
DROP TABLE IF EXISTS DishOrder;
DROP TABLE IF EXISTS DishFavorite;
DROP TABLE IF EXISTS RestaurantFavorite;
DROP TABLE IF EXISTS ReviewRestaurant;
DROP TABLE IF EXISTS ReviewResponse;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS CategoryRestaurant;

/*******************************************************************************
   Create Tables
********************************************************************************/

CREATE TABLE Customer
(
    CustomerId INTEGER  NOT NULL,
    Username INTEGER NOT NULL,
	FirstName NVARCHAR(40)  NOT NULL,
    LastName NVARCHAR(20)  NOT NULL,
    CustomerAddress NVARCHAR(70),
    CustomerCity NVARCHAR(40),
    CustomerCountry NVARCHAR(40),
    CustomerPostalCode NVARCHAR(10),
    CustomerPhone NVARCHAR(24),
    CustomerEmail NVARCHAR(60) NOT NULL,
    Password NVARCHAR(40) NOT NULL,
    CONSTRAINT PK_Customer PRIMARY KEY  (CustomerId)
);

CREATE TABLE RestaurantOwner
(
    RestaurantOwnerId INTEGER  NOT NULL,
    RestaurantId INTEGER  NOT NULL,
    FOREIGN KEY (RestaurantOwnerId) REFERENCES Customer (CustomerId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId) 
		ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Restaurant
(
    RestaurantId INTEGER  NOT NULL,
    RestaurantName NVARCHAR(40)  NOT NULL,
    RestaurantAddress NVARCHAR(70),
    RestaurantCity NVARCHAR(40),
    RestaurantCountry NVARCHAR(40),
    RestaurantPostalCode NVARCHAR(10),
    RestaurantPhone NVARCHAR(24),
    RestaurantPhoto STRING,
    Rating FLOAT CONSTRAINT check_restaurantRating check(rating>=0 AND rating<=5),
    CONSTRAINT PK_Restaurant PRIMARY KEY (RestaurantId)
);

CREATE TABLE Dish
(
    DishId INTEGER  NOT NULL,
    DishName NVARCHAR(40)  NOT NULL,
    DishPrice FLOAT NOT NULL,
    RestaurantId INTEGER  NOT NULL,
    DishPhoto STRING,
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT PK_Dish PRIMARY KEY (DishId)
);


CREATE TABLE CustomerOrder
(
    OrderId INTEGER  NOT NULL,
    CustomerId INTEGER  NOT NULL,
    RestaurantId INTEGER  NOT NULL,
    OrderState NVARCHAR(40)  NOT NULL,
    FOREIGN KEY (CustomerId) REFERENCES Customer (CustomerId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT PK_Order PRIMARY KEY (OrderId)
);

CREATE TABLE DishOrder
(
    OrderId INTEGER  NOT NULL,
    DishId INTEGER  NOT NULL,
    FOREIGN KEY (OrderId) REFERENCES CustomerOrder (OrderId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (DishId) REFERENCES Dish (DishId) 
		ON DELETE CASCADE ON UPDATE CASCADE
);



CREATE TABLE DishFavorite
(
    DishId INTEGER  NOT NULL,
    CustomerId INTEGER  NOT NULL,
    FOREIGN KEY (DishId) REFERENCES Dish (DishId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (CustomerId) REFERENCES Customer (CustomerId) 
		ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE RestaurantFavorite
(
    RestaurantId INTEGER  NOT NULL,
    CustomerId INTEGER  NOT NULL,
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (CustomerId) REFERENCES Customer (CustomerId) 
		ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ReviewRestaurant
(
    ReviewId INTEGER  NOT NULL,
    CustomerId INTEGER  NOT NULL,
	RestaurantId INTEGER  NOT NULL,
    reviewText STRING,
    ReviewRating INT NOT NULL,
	FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (CustomerId) REFERENCES Customer (CustomerId) 
		ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE ReviewResponse
(
    ReviewId INTEGER  NOT NULL,
    RestaurantOwnerId INTEGER  NOT NULL,
	reviewText STRING,
	FOREIGN KEY (RestaurantOwnerId) REFERENCES RestaurantOwner (RestaurantOwnerId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (ReviewId) REFERENCES Review (ReviewId) 
		ON DELETE CASCADE ON UPDATE CASCADE
);

/*   PARTE DO HUGO    */
CREATE TABLE Category(
	CategoryId INTEGER NOT NULL,
	Name NVARCHAR(40)	
);

CREATE TABLE CategoryRestaurant(
	RestaurantId INTEGER NOT NULL,
	CategoryId INTEGER NOT NULL,
	FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (CategoryId) REFERENCES Category (CategoryId) ON DELETE CASCADE ON UPDATE CASCADE
);



/*******************************************************************************
   Create Foreign Keys
********************************************************************************/

CREATE INDEX IFK_RestaurantOwnerRestaurantOwnerId ON RestaurantOwner (RestaurantOwnerId);
CREATE INDEX IFK_RestaurantOwnerRestaurantId ON RestaurantOwner (RestaurantId);
CREATE INDEX IFK_DishRestaurantID ON Dish (RestaurantId);
CREATE INDEX IFK_CustomerRestaurantID ON CustomerOrder (RestaurantId);
CREATE INDEX IFK_OrderCustomerID ON CustomerOrder (CustomerId);
CREATE INDEX IFK_DishOrderRestaurantID ON Dish (DishId);
CREATE INDEX IFK_DishOrderCustomerID ON CustomerOrder (OrderId);
CREATE INDEX IFK_DishFavoriteDishID ON DishFavorite (DishId);
CREATE INDEX IFK_DishFavoriteCustomerID ON DishFavorite (CustomerId);
CREATE INDEX IFK_ReviewCustomerID ON ReviewRestaurant (CustomerId);

CREATE INDEX IFK_ReviewResponseRestaurantOwnerId on RestaurantOwner (RestaurantOwnerId);
CREATE INDEX IFK_ReviewRestaurantId ON Restaurant (RestaurantId);

CREATE INDEX IFK_ReviewResponseReviewID ON ReviewResponse (ReviewId);


/*******************************************************************************
   Populate Tables
********************************************************************************/

INSERT INTO Customer (CustomerId, FirstName, LastName, CustomerAddress, CustomerCity, CustomerCountry, CustomerPostalCode, CustomerPhone, CustomerEmail, Password,Username) 
VALUES (1, 'Teresa', 'Ferreira', 'Rua das Flores', 'Braga', 'Portugal', '4400-403', '913746653', 'teresa.ferreira@gmail.com', '1111111','Tete' ),
(2, 'Carlos', 'Almeida', 'Rua do sapo', 'Porto', 'Portugal', '4500-406', '913722613', 'carlosalmeida@gmail.com', '11111111','Cambalhota' ),
 (3, 'Susana', 'Almeida', 'Rua das cerpas', 'Coimbra', 'Portugal', '4501-416', '935477854', 'susana@hotmail.com','111111' ,'User1212' ),
(4, 'Hugo', 'Pereira', 'Rua das almas', 'Paredes', 'Portugal', '4502-404', '915873093', 'hugo2000@gmail.com',  '11111111','Senhor Restaurant' ),
 (5, 'Rui', 'das Cruzes', 'Rua da praceta', 'Almada', 'Portugal', '4200-446', '915943573', 'cruzrui@gmail.com',        '11111111','Nice' ),
(6, 'Sara Isabel', 'Correia', 'Rua dos lobos', 'Baltar', 'Portugal', '4400-422', '939822005', 'scorreia@gmail.com',         '11111111','Desformatado'),
(7, 'Ana Maria', 'Santos', 'Rua dos Santos', 'Paredes', 'Portugal', '4402-407', '965587974', 'anamaria@hotmail.com',        '11111111','User12123' ),
 (8, 'Carlota', 'Teixeira Ferreira', 'Rua Escola da Souta', 'Viana do Castelo', 'Portugal', '4312-401', '935488623', 'carlota@hotmail.com','11111111' ,'Lopes'  ),
(9, 'Carlota', 'Teixeira Ferreira', 'Rua Escola da Souta', 'Viana do Castelo', 'Portugal', '4312-401', '935488623', 'carlota@hotmail.com',       '11111111' ,'LTW' ),
(10,'Carla','Penedo Penedo','Rua dos Clérigos','Porto','Portugal','4900-231','963258750','carlacarla@gmail.com','111111111','Customer'),
(11,'Pedro','Lee','Rua Maira Alberta','Porto','Portugal','4900-323','96258741','pedrooo@gmail.com','111111','PL'),
(12,'Tiago','Pessoa','Rua Mãe','Lisboa','Portugal','4200-212','9684321','21123@gmail.com','11111','TiagoPessoa2021'),
(13,'Sara','Tenente','Rua ALbertina Conceição','Porto','Portugal','4200-978','965412300','Sris@hotmail.com','111111','SrisSris'),
(14,'Luisa','Lima','Rua dos Olhos Azuis','Porto','Porto','4900-121','965412300','jiokl@gmail.com','1111111','Luisaa'),
(15,'Clara','Claridade','Rua Casa Ajuda','Porto','Portugal','4900-123','987456321','party@gmail.com','111111','Lolo');


INSERT INTO Category(CategoryId,Name) VALUES(1,'Comida Portuguesa');
INSERT INTO Category(CategoryId,Name) VALUES(2,'Fast Food');
INSERT INTO Category(CategoryId,Name) VALUES(3,'Comida Indiana');
INSERT INTO Category(CategoryId,Name) VALUES(4,'Comida Brasileira');
INSERT INTO Category(CategoryId,Name) VALUES(5,'Comida Chinesa');
INSERT INTO Category(CategoryId,Name) VALUES(6,'Comida Japonesa');
INSERT INTO Category(CategoryId,Name) VALUES(7,'Comida Espanhola');
INSERT INTO Category(CategoryId,Name) VALUES(8,'Comida Francesa');
INSERT INTO Category(CategoryId,Name) VALUES(9,'Comida Mexicana');
INSERT INTO Category(CategoryId,Name) VALUES(10,'Comida Vietnamisa');
INSERT INTO Category(CategoryId,Name) VALUES(11,'Comida Russa');
INSERT INTO Category(CategoryId,Name) VALUES(12,'Comida Italiana');
INSERT INTO Category(CategoryId,Name) VALUES(13,'Comida Egípcia');
INSERT INTO Category(CategoryId,Name) VALUES(14,'Comida Tailandesa');
INSERT INTO Category(CategoryId,Name) VALUES(15,'Comida Madeirense');

INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(1,1);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(1,4);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(1,15);

INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(2,2);

INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(3,3);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(3,6);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(3,13);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(3,14);

INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(4,4);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(5,5);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(5,6);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(5,7);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(5,8);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(5,15);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(6,6);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(7,7);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(8,8);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(8,10);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(8,11);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(8,13);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(8,14);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(9,9);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(10,10);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(11,11);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(12,12);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(13,13);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(14,14);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(15,15);



INSERT INTO RestaurantOwner(RestaurantOwnerId,RestaurantId) VALUES (1,1);
INSERT INTO RestaurantOwner(RestaurantOwnerId,RestaurantId) VALUES (1,2);
INSERT INTO RestaurantOwner(RestaurantOwnerId,RestaurantId) VALUES (2,3);
INSERT INTO RestaurantOwner(RestaurantOwnerId,RestaurantId) VALUES (3,4);
INSERT INTO RestaurantOwner(RestaurantOwnerId,RestaurantId) VALUES (3,5);
INSERT INTO RestaurantOwner(RestaurantOwnerId,RestaurantId) VALUES (4,6);
INSERT INTO RestaurantOwner(RestaurantOwnerId,RestaurantId) VALUES (5,7);
INSERT INTO RestaurantOwner(RestaurantOwnerId,RestaurantId) VALUES (5,8);
INSERT INTO RestaurantOwner(RestaurantOwnerId,RestaurantId) VALUES (5,9);
INSERT INTO RestaurantOwner(RestaurantOwnerId,RestaurantId) VALUES (6,10);
INSERT INTO RestaurantOwner(RestaurantOwnerId,RestaurantId) VALUES (7,11);
INSERT INTO RestaurantOwner(RestaurantOwnerId,RestaurantId) VALUES (8,12);
INSERT INTO RestaurantOwner(RestaurantOwnerId,RestaurantId) VALUES (8,13);
INSERT INTO RestaurantOwner(RestaurantOwnerId,RestaurantId) VALUES (9,14);
INSERT INTO RestaurantOwner(RestaurantOwnerId,RestaurantId) VALUES (10,15);




INSERT INTO Restaurant(RestaurantId,
			RestaurantName,
			RestaurantAddress,
			RestaurantCity,
			RestaurantCountry,
			RestaurantPostalCode,
			RestaurantPhone,
			Rating) 
			VALUES (1,
				'Tasquinha da ajuda',
				'Rua São José',
				'Porto',
				'Portugal',
				'1800-543',
				'+351 987987555',
				3.5);


INSERT INTO Restaurant(RestaurantId,
			RestaurantName,
			RestaurantAddress,
			RestaurantCity,
			RestaurantCountry,
			RestaurantPostalCode,
			RestaurantPhone,
			Rating) 
			VALUES (2,
				'Zipp',
				'Rua do Breiner',
				'Porto',
				'Portugal',
				'1800-786',
				'+351 987000000',
				1);
INSERT INTO Restaurant(RestaurantId,
			RestaurantName,
			RestaurantAddress,
			RestaurantCity,
			RestaurantCountry,
			RestaurantPostalCode,
			RestaurantPhone,
			Rating) 
			VALUES (3,
				'O Pardal',
				'Rua dos Caldeireiros Escadas do Caminho Novo',
				'Porto',
				'Portugal',
				'1800-243',
				'+351 963541287',
				2.5);
INSERT INTO Restaurant(RestaurantId,
			RestaurantName,
			RestaurantAddress,
			RestaurantCity,
			RestaurantCountry,
			RestaurantPostalCode,
			RestaurantPhone,
			Rating) 
			VALUES (4,
				'Ristaurante',
				'Rua de Cândido dos Reis',
				'Porto',
				'Portugal',
				'1800-453',
				'+351 963852025',
				4.5);
INSERT INTO Restaurant(RestaurantId,
			RestaurantName,
			RestaurantAddress,
			RestaurantCity,
			RestaurantCountry,
			RestaurantPostalCode,
			RestaurantPhone,
			Rating) 
			VALUES (5,
				'Café e Pastelaria',
				'Rua das Carmelitas',
				'Porto',
				'Portugal',
				'1800-678',
				'+351 963014785'
				,2);
INSERT INTO Restaurant(RestaurantId,
			RestaurantName,
			RestaurantAddress,
			RestaurantCity,
			RestaurantCountry,
			RestaurantPostalCode,
			RestaurantPhone,
			Rating) 
			VALUES (6,
				'Cova',
				'Rua do Carvalhido',
				'Porto',
				'Portugal',
				'1800-776',
				'+351 965823147',
				3.5);
INSERT INTO Restaurant(RestaurantId,
			RestaurantName,
			RestaurantAddress,
			RestaurantCity,
			RestaurantCountry,
			RestaurantPostalCode,
			RestaurantPhone,
			Rating) 
			VALUES (7,
				'Máguas',
				'Rua de Cedofeita',
				'Porto',
				'Portugal',
				'1800-344',
				'+351 96325840',
				4.0);
INSERT INTO Restaurant(RestaurantId,
			RestaurantName,
			RestaurantAddress,
			RestaurantCity,
			RestaurantCountry,
			RestaurantPostalCode,
			RestaurantPhone,
			Rating) 
			VALUES (8,
				'Oitenta e Oito',
				'Rua dos Clérigos',
				'Porto',
				'Portugal',
				'1800-233',
				'+351 968574301',
				5.0);
INSERT INTO Restaurant(RestaurantId,
			RestaurantName,
			RestaurantAddress,
			RestaurantCity,
			RestaurantCountry,
			RestaurantPostalCode,
			RestaurantPhone,
			Rating) 
			VALUES (9,
				'Lacinhos',
				'Rua dos Clérigos',
				'Porto',
				'Portugal',
				'1800-333',
				'+351 963214785',
				4.5);
INSERT INTO Restaurant(RestaurantId,
			RestaurantName,
			RestaurantAddress,
			RestaurantCity,
			RestaurantCountry,
			RestaurantPostalCode,
			RestaurantPhone,
			Rating) 
			VALUES (10,
				'TOP 10',
				'Rua Santa Maria',
				'Porto',
				'Portugal',
				'1800-222',
				'+351 987654789',
				4.0);
INSERT INTO Restaurant(RestaurantId,
			RestaurantName,
			RestaurantAddress,
			RestaurantCity,
			RestaurantCountry,
			RestaurantPostalCode,
			RestaurantPhone,
			Rating) 
			VALUES (11,
				'Longe',
				'Rua do Senhor Roubado',
				'Porto',
				'Portugal',
				'1800-999',
				'+351 902365874',
				3.0);
INSERT INTO Restaurant(RestaurantId,
			RestaurantName,
			RestaurantAddress,
			RestaurantCity,
			RestaurantCountry,
			RestaurantPostalCode,
			RestaurantPhone,
			Rating) 
			VALUES (12,
				'Apóstolos',
				'Rua Jesus Cristo',
				'Porto',
				'Portugal',
				'1800-888',
				'+351 97541236',
				2.0);
INSERT INTO Restaurant(RestaurantId,
			RestaurantName,
			RestaurantAddress,
			RestaurantCity,
			RestaurantCountry,
			RestaurantPostalCode,
			RestaurantPhone,
			Rating) 
			VALUES (13,
				'Lucky 13',
				'Rua das 13 Cidades',
				'Porto',
				'Portugal',
				'1800-777',
				'+351 963524178',
				4.0);
INSERT INTO Restaurant(RestaurantId,
			RestaurantName,
			RestaurantAddress,
			RestaurantCity,
			RestaurantCountry,
			RestaurantPostalCode,
			RestaurantPhone,
			Rating) 
			VALUES (14,
				'Com',
				'Rua 7',
				'Porto',
				'Portugal',
				'1800-789',
				'+351 925925952',
				3.0);
INSERT INTO Restaurant(RestaurantId,
			RestaurantName,
			RestaurantAddress,
			RestaurantCity,
			RestaurantCountry,
			RestaurantPostalCode,
			RestaurantPhone,
			Rating) 
			VALUES (15,
				'Aniversário',
				'Rua Central',
				'Porto',
				'Portugal',
				'1800-987',
				'+351 987987987',
				3.0);


INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(1,'Massa com Atum',9.15,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(2,'Sopa de Pedra',45,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(3,'Bitoque',1.55,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(4,'Bifinhos de Frango',5.35,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(5,'Francesinha',3.35,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(6,'Pimentos',2.55,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(7,'Gelado',5.55,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(8,'Bolo',2.85,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(9,'Coca-Cola',7.95,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(10,'Cachorro Quente',8.15,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(11,'Lasanha',0.85,2);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(12,'Hambúrguer',8.95,2);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(13,'Arroz com pequi',9.75,2);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(14,'Polvo à Lagareiro',6.85,2);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(15,'Leitão à Bairrada',1.25,2);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(16,'Cataplana de Mariscos',3.65,2);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(17,'Arroz de Polvo',7.85,2);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(18,'Arroz de Pato',9.95,2);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(19,'Tripas à Moda do Porto',8.45,2);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(20,'Curry massaman',1.35,2);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(21,'Pizza napolitana',4.15,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(22,'Pato à pequim',45,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(23,'Frango Piri-piri',5.25,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(24,'Lagosta',9.35,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(25,'Kebab',9.25,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(26,'Lasanha',7.75,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(27,'Caranguejo com manteiga de alho',5.15,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(28,'Fajitas',2.55,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(29,'Fish and chips',5.15,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(30,'Caranguejo com pimenta malagueta',4.35,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(31,'Frango ├á parmegiana',7.85,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(32,'Tacos',4.65,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(33,'Arroz de frango',4.15,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(34,'Paella de frutos do mar',1.55,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(35,'Empadão ',15,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(36,'Empanada',5.15,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(37,'Espeto de Roj├úo',3.45,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(38,'Massa com Atum',5.85,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(39,'Sopa de Pedra',8.95,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(40,'Bitoque',2.65,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(41,'Bifinhos de Frango',6.95,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(42,'Francesinha',4.95,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(43,'Pimentos',6.35,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(44,'Gelado',5.15,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(45,'Bolo',2.65,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(46,'Coca-Cola',5.35,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(47,'Cachorro Quente',9.55,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(48,'Lasanha',5.55,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(49,'Hambúrguer',6.15,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(50,'Arroz com pequi',6.35,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(51,'Polvo à Lagareiro',3.15,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(52,'Leitão à Bairrada',3.95,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(53,'Cataplana de Mariscos',0.95,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(54,'Arroz de Polvo',0.25,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(55,'Arroz de Pato',35,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(56,'Tripas à Moda do Porto',6.15,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(57,'Curry massaman',4.95,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(58,'Pizza napolitana',9.65,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(59,'Pato à pequim',6.25,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(60,'Frango Piri-piri',8.55,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(61,'Lagosta',2.45,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(62,'Kebab',9.25,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(63,'Lasanha',6.15,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(64,'Caranguejo com manteiga de alho',95,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(65,'Fajitas',3.35,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(66,'Fish and chips',65,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(67,'Caranguejo com pimenta malagueta',4.75,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(68,'Frango ├á parmegiana',3.95,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(69,'Tacos',85,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(70,'Arroz de frango',3.85,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(71,'Paella de frutos do mar',0.55,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(72,'Empadão ',1.95,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(73,'Empanada',8.75,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(74,'Espeto de Roj├úo',5.25,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(75,'Massa com Atum',3.15,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(76,'Sopa de Pedra',3.45,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(77,'Bitoque',6.85,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(78,'Bifinhos de Frango',9.55,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(79,'Francesinha',3.85,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(80,'Pimentos',6.95,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(81,'Gelado',7.15,9);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(82,'Bolo',6.45,9);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(83,'Coca-Cola',2.55,9);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(84,'Cachorro Quente',0.55,9);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(85,'Lasanha',7.45,9);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(86,'Hambúrguer',75,9);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(87,'Arroz com pequi',15,9);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(88,'Polvo à Lagareiro',1.45,9);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(89,'Leitão à Bairrada',55,9);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(90,'Cataplana de Mariscos',9.75,9);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(91,'Arroz de Polvo',25,10);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(92,'Arroz de Pato',9.85,10);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(93,'Tripas à Moda do Porto',9.35,10);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(94,'Curry massaman',3.75,10);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(95,'Pizza napolitana',5.55,10);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(96,'Pato à pequim',105,10);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(97,'Frango Piri-piri',0.15,10);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(98,'Lagosta',7.45,10);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(99,'Kebab',9.95,10);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(100,'Lasanha',8.15,10);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(101,'Caranguejo com manteiga de alho',3.65,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(102,'Fajitas',4.45,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(103,'Fish and chips',0.65,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(104,'Caranguejo com pimenta malagueta',55,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(105,'Frango ├á parmegiana',2.75,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(106,'Tacos',4.95,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(107,'Arroz de frango',4.65,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(108,'Paella de frutos do mar',6.35,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(109,'Empadão ',55,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(110,'Empanada',3.45,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(111,'Espeto de Roj├úo',0.75,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(112,'Massa com Atum',8.35,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(113,'Sopa de Pedra',6.75,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(114,'Bitoque',2.75,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(115,'Bifinhos de Frango',6.65,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(116,'Francesinha',0.15,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(117,'Pimentos',2.55,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(118,'Gelado',4.75,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(119,'Bolo',2.25,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(120,'Coca-Cola',2.25,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(121,'Cachorro Quente',1.65,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(122,'Lasanha',6.75,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(123,'Hambúrguer',8.95,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(124,'Arroz com pequi',1.25,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(125,'Polvo à Lagareiro',0.85,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(126,'Leitão à Bairrada',4.25,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(127,'Cataplana de Mariscos',5.35,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(128,'Arroz de Polvo',0.85,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(129,'Arroz de Pato',2.85,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(130,'Tripas à Moda do Porto',0.35,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(131,'Curry massaman',95,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(132,'Pizza napolitana',95,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(133,'Pato à pequim',1.65,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(134,'Frango Piri-piri',0.55,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(135,'Lagosta',4.95,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(136,'Kebab',1.45,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(137,'Lasanha',3.55,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(138,'Caranguejo com manteiga de alho',55,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(139,'Fajitas',9.65,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(140,'Fish and chips',1.45,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(141,'Caranguejo com pimenta malagueta',4.85,15);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(142,'Frango ├á parmegiana',65,15);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(143,'Tacos',1.95,15);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(144,'Arroz de frango',5.55,15);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(145,'Paella de frutos do mar',5.75,15);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(146,'Empadão ',2.25,15);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(147,'Empanada',0.15,15);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(148,'Espeto de Roj├úo',6.35,15);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(149,'Massa com Atum',105,15);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId) VALUES(150,'Sopa de Pedra',8.65,15);




INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(1,1,24,'received');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(2,2,23,'received');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(3,3,22,'received');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(4,4,21,'received');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(5,5,20,'received');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(6,6,19,'received');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(7,7,18,'received');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(8,8,17,'received');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(9,9,16,'preparing');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(10,11,15,'preparing');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(11,12,14,'preparing');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(12,1,13,'preparing');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(13,2,12,'preparing');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(14,2,11,'preparing');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(15,11,10,'preparing');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(16,13,9,'preparing');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(17,3,8,'preparing');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(18,4,7,'preparing');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(19,6,6,'preparing');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(20,3,5,'preparing');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(21,11,4,'preparing');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(22,12,3,'preparing');

INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(23,1,1,'ready');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(24,2,2,'ready');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(25,3,3,'ready');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(26,4,4,'ready');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(27,5,5,'ready');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(28,6,6,'ready');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(29,7,7,'ready');

INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(31,8,4,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(32,9,5,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(33,10,6,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(34,11,1,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(35,12,2,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(36,13,11,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(37,15,22,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(38,7,20,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(39,9,13,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(40,2,16,'delivered');

INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(41,1,2,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(42,3,1,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(43,4,11,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(44,5,12,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(45,6,13,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(46,14,7,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(47,14,8,'delivered');

INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(48,1,3,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(49,3,6,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(50,4,1,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(51,5,2,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(52,6,3,'delivered');



INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(53,11,7,'delivered');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState) VALUES(54,11,8,'delivered');

INSERT INTO DishOrder(OrderId,DishId) VALUES(1,2);
INSERT INTO DishOrder(OrderId,DishId) VALUES(1,4);
INSERT INTO DishOrder(OrderId,DishId) VALUES(1,10);

INSERT INTO DishOrder(OrderId,DishId) VALUES(2,11);
INSERT INTO DishOrder(OrderId,DishId) VALUES(2,13);
INSERT INTO DishOrder(OrderId,DishId) VALUES(2,14);
INSERT INTO DishOrder(OrderId,DishId) VALUES(2,16);

INSERT INTO DishOrder(OrderId,DishId) VALUES(3,22);
INSERT INTO DishOrder(OrderId,DishId) VALUES(3,21);
INSERT INTO DishOrder(OrderId,DishId) VALUES(3,22);
INSERT INTO DishOrder(OrderId,DishId) VALUES(3,30);

INSERT INTO DishOrder(OrderId,DishId) VALUES(4,31);
INSERT INTO DishOrder(OrderId,DishId) VALUES(4,33);
INSERT INTO DishOrder(OrderId,DishId) VALUES(4,40);
INSERT INTO DishOrder(OrderId,DishId) VALUES(4,40);

INSERT INTO DishOrder(OrderId,DishId) VALUES(5,45);

INSERT INTO DishOrder(OrderId,DishId) VALUES(6,55);
INSERT INTO DishOrder(OrderId,DishId) VALUES(6,55);
INSERT INTO DishOrder(OrderId,DishId) VALUES(6,54);
INSERT INTO DishOrder(OrderId,DishId) VALUES(6,58);

INSERT INTO DishOrder(OrderId,DishId) VALUES(7,68);

INSERT INTO DishOrder(OrderId,DishId) VALUES(8,80);
INSERT INTO DishOrder(OrderId,DishId) VALUES(8,80);
INSERT INTO DishOrder(OrderId,DishId) VALUES(8,80);
INSERT INTO DishOrder(OrderId,DishId) VALUES(8,80);

INSERT INTO DishOrder(OrderId,DishId) VALUES(9,87);

INSERT INTO DishOrder(OrderId,DishId) VALUES(10,110);

INSERT INTO DishOrder(OrderId,DishId) VALUES(11,113);
INSERT INTO DishOrder(OrderId,DishId) VALUES(11,113);
INSERT INTO DishOrder(OrderId,DishId) VALUES(11,118);
INSERT INTO DishOrder(OrderId,DishId) VALUES(11,119);

INSERT INTO DishOrder(OrderId,DishId) VALUES(12,9);
INSERT INTO DishOrder(OrderId,DishId) VALUES(12,6);

INSERT INTO DishOrder(OrderId,DishId) VALUES(13,12);
INSERT INTO DishOrder(OrderId,DishId) VALUES(13,12);
INSERT INTO DishOrder(OrderId,DishId) VALUES(13,12);

INSERT INTO DishOrder(OrderId,DishId) VALUES(13,16);
INSERT INTO DishOrder(OrderId,DishId) VALUES(13,16);
INSERT INTO DishOrder(OrderId,DishId) VALUES(13,16);
INSERT INTO DishOrder(OrderId,DishId) VALUES(13,16);
INSERT INTO DishOrder(OrderId,DishId) VALUES(13,16);

INSERT INTO DishOrder(OrderId,DishId) VALUES(14,20);

INSERT INTO DishOrder(OrderId,DishId) VALUES(15,110);
INSERT INTO DishOrder(OrderId,DishId) VALUES(15,109);
INSERT INTO DishOrder(OrderId,DishId) VALUES(15,101);
INSERT INTO DishOrder(OrderId,DishId) VALUES(15,103);

INSERT INTO DishOrder(OrderId,DishId) VALUES(16,125);
INSERT INTO DishOrder(OrderId,DishId) VALUES(16,124);

INSERT INTO DishOrder(OrderId,DishId) VALUES(17,23);

INSERT INTO DishOrder(OrderId,DishId) VALUES(18,34);
INSERT INTO DishOrder(OrderId,DishId) VALUES(18,35);
INSERT INTO DishOrder(OrderId,DishId) VALUES(18,36);
INSERT INTO DishOrder(OrderId,DishId) VALUES(18,37);
INSERT INTO DishOrder(OrderId,DishId) VALUES(18,40);
INSERT INTO DishOrder(OrderId,DishId) VALUES(18,35);
INSERT INTO DishOrder(OrderId,DishId) VALUES(18,35);
INSERT INTO DishOrder(OrderId,DishId) VALUES(18,36);

INSERT INTO DishOrder(OrderId,DishId) VALUES(19,59);

INSERT INTO DishOrder(OrderId,DishId) VALUES(20,30);
INSERT INTO DishOrder(OrderId,DishId) VALUES(20,21);
INSERT INTO DishOrder(OrderId,DishId) VALUES(20,27);

INSERT INTO DishOrder(OrderId,DishId) VALUES(21,110);

INSERT INTO DishOrder(OrderId,DishId) VALUES(22,112);

INSERT INTO DishOrder(OrderId,DishId) VALUES(23,1);
INSERT INTO DishOrder(OrderId,DishId) VALUES(23,1);
INSERT INTO DishOrder(OrderId,DishId) VALUES(23,2);
INSERT INTO DishOrder(OrderId,DishId) VALUES(23,3);

INSERT INTO DishOrder(OrderId,DishId) VALUES(24,18);

INSERT INTO DishOrder(OrderId,DishId) VALUES(25,21);
INSERT INTO DishOrder(OrderId,DishId) VALUES(25,21);
INSERT INTO DishOrder(OrderId,DishId) VALUES(25,21);

INSERT INTO DishOrder(OrderId,DishId) VALUES(26,36);

INSERT INTO DishOrder(OrderId,DishId) VALUES(27,46);

INSERT INTO DishOrder(OrderId,DishId) VALUES(28,56);
INSERT INTO DishOrder(OrderId,DishId) VALUES(28,55);
INSERT INTO DishOrder(OrderId,DishId) VALUES(28,57);
INSERT INTO DishOrder(OrderId,DishId) VALUES(28,60);

INSERT INTO DishOrder(OrderId,DishId) VALUES(29,67);

INSERT INTO DishOrder(OrderId,DishId) VALUES(31,78);

INSERT INTO DishOrder(OrderId,DishId) VALUES(32,89);

INSERT INTO DishOrder(OrderId,DishId) VALUES(33,100);
INSERT INTO DishOrder(OrderId,DishId) VALUES(33,99);
INSERT INTO DishOrder(OrderId,DishId) VALUES(33,99);
INSERT INTO DishOrder(OrderId,DishId) VALUES(33,99);
INSERT INTO DishOrder(OrderId,DishId) VALUES(33,98);
INSERT INTO DishOrder(OrderId,DishId) VALUES(33,95);

INSERT INTO DishOrder(OrderId,DishId) VALUES(34,110);

INSERT INTO DishOrder(OrderId,DishId) VALUES(35,120);

INSERT INTO DishOrder(OrderId,DishId) VALUES(36,128);

INSERT INTO DishOrder(OrderId,DishId) VALUES(37,147);
INSERT INTO DishOrder(OrderId,DishId) VALUES(37,150);
INSERT INTO DishOrder(OrderId,DishId) VALUES(37,145);
INSERT INTO DishOrder(OrderId,DishId) VALUES(37,144);
INSERT INTO DishOrder(OrderId,DishId) VALUES(37,143);

INSERT INTO DishOrder(OrderId,DishId) VALUES(38,70);

INSERT INTO DishOrder(OrderId,DishId) VALUES(39,90);
INSERT INTO DishOrder(OrderId,DishId) VALUES(39,89);
INSERT INTO DishOrder(OrderId,DishId) VALUES(39,88);

INSERT INTO DishOrder(OrderId,DishId) VALUES(40,15);
INSERT INTO DishOrder(OrderId,DishId) VALUES(40,11);
INSERT INTO DishOrder(OrderId,DishId) VALUES(40,20);

INSERT INTO DishOrder(OrderId,DishId) VALUES(41,10);
INSERT INTO DishOrder(OrderId,DishId) VALUES(41,10);
INSERT INTO DishOrder(OrderId,DishId) VALUES(41,10);

INSERT INTO DishOrder(OrderId,DishId) VALUES(42,23);
INSERT INTO DishOrder(OrderId,DishId) VALUES(43,34);
INSERT INTO DishOrder(OrderId,DishId) VALUES(44,45);
INSERT INTO DishOrder(OrderId,DishId) VALUES(44,48);
INSERT INTO DishOrder(OrderId,DishId) VALUES(45,57);
INSERT INTO DishOrder(OrderId,DishId) VALUES(46,134);
INSERT INTO DishOrder(OrderId,DishId) VALUES(46,131);
INSERT INTO DishOrder(OrderId,DishId) VALUES(47,132);
INSERT INTO DishOrder(OrderId,DishId) VALUES(47,140);
INSERT INTO DishOrder(OrderId,DishId) VALUES(47,140);

INSERT INTO DishOrder(OrderId,DishId) VALUES(48,10);
INSERT INTO DishOrder(OrderId,DishId) VALUES(48,10);
INSERT INTO DishOrder(OrderId,DishId) VALUES(48,10);

INSERT INTO DishOrder(OrderId,DishId) VALUES(49,23);
INSERT INTO DishOrder(OrderId,DishId) VALUES(50,34);
INSERT INTO DishOrder(OrderId,DishId) VALUES(51,45);
INSERT INTO DishOrder(OrderId,DishId) VALUES(51,48);
INSERT INTO DishOrder(OrderId,DishId) VALUES(52,57);



INSERT INTO DishFavorite(DishId,CustomerId) VALUES (1,15);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (5,15);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (8,15);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (9,15);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (10,1);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (11,2);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (13,3);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (14,4);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (17,5);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (19,6);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (20,6);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (21,6);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (22,7);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (25,7);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (26,7);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (27,8);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (28,8);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (30,8);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (31,9);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (33,9);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (36,9);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (38,10);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (39,10);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (41,10);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (42,12);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (44,12);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (48,12);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (49,12);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (50,12);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (51,12);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (53,15);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (67,15);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (67,1);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (68,2);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (80,3);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (90,14);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (101,13);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (103,13);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (105,14);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (110,1);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (115,6);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (118,6);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (120,7);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (123,8);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (125,9);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (127,9);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (128,9);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (129,9);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (130,4);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (132,3);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (133,2);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (135,1);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (137,3);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (138,5);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (139,7);
INSERT INTO DishFavorite(DishId,CustomerId) VALUES (147,9);


INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(1,1);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(1,2);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(1,3);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(1,4);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(1,15);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(2,11);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(2,13);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(2,11);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(3,1);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(3,15);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(4,4);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(4,3);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(5,15);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(6,3);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(7,4);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(8,5);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(9,7);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(10,7);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(11,9);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(11,3);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(11,2);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(11,15);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(12,15);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(12,1);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(13,13);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(13,11);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(13,1);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(13,4);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(14,15);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(14,1);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(14,2);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(15,4);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(15,8);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(15,9);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(15,1);
INSERT INTO RestaurantFavorite(RestaurantId,CustomerId)VALUES(15,2);

INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(1,2,1,'Adorei!!',5);
INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(18,3,1,'Comida fantástica! Mas encontrei cabelo no meu prato',2);

INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(2,16,2,'Comida boa mas chegou fria. :',1);

INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(3,1,3,'Horrivel. Não recomendo.',2);
INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(19,6,3,'Não vale a pena ir',3);

INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(4,11,4,'Fantástico',5);
INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(20,1,4,'Podia ser melhor mas mesmo assim a comida está boa',4);

INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(5,12,5,'Ótimo ambiente para comer uma francesinha e tomar umas cervejas com amigos.',3);
INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(21,2,5,'Pior comida que comi na vida',1);

INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(6,13,6,'Muito bom. Vou voltar!',4);
INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(22,3,6,'Comida Mediana',3);

INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(7,20,7,'Comida lamentável e nojenta.',4);
INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(8,4,8,'Comecei a ser fã do restaurante!!',5);
INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(9,5,9,'A comida era razoável',4);
INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(10,3,9,'Adorei!!',5);
INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(11,6,10,'Podia ser melhor a comida.',4);
INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(12,1,11,'Sabia muito a óleo a comida mas tirando isso estava bom',3);
INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(13,2,12,'Horrivel',2);
INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(14,7,14,'Não recomdo a ninguém',1);
INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(15,8,14,'Adorei!!',5);
INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(16,11,13,'Adorei tudo, vou continuar a mandar vir deste restaurante',4);
INSERT INTO ReviewRestaurant(ReviewId,CustomerId,RestaurantId,reviewText,ReviewRating) VALUES(17,22,15,'Comida básica e barata',3);

INSERT INTO ReviewResponse(ReviewId,RestaurantOwnerId,reviewText) VALUES(1,1,'Muito obrigado <3');
INSERT INTO ReviewResponse(ReviewId,RestaurantOwnerId,reviewText) VALUES(2,2,'A culpa não é nossa.');
INSERT INTO ReviewResponse(ReviewId,RestaurantOwnerId,reviewText) VALUES(3,3,'Pedimos desculpa se não gostou do serviço');
INSERT INTO ReviewResponse(ReviewId,RestaurantOwnerId,reviewText) VALUES(5,5,'Obrigado eheheh');
INSERT INTO ReviewResponse(ReviewId,RestaurantOwnerId,reviewText) VALUES(7,7,'Então porque é que deu 4 na review? Foi erro?');
INSERT INTO ReviewResponse(ReviewId,RestaurantOwnerId,reviewText) VALUES(9,9,'Iremos fazer o nosso melhor para melhorar a comida');
INSERT INTO ReviewResponse(ReviewId,RestaurantOwnerId,reviewText) VALUES(10,9,'Muito obrigado! Agradecemos.');
INSERT INTO ReviewResponse(ReviewId,RestaurantOwnerId,reviewText) VALUES(11,10,'Ok vamos ter isso em consideração');
INSERT INTO ReviewResponse(ReviewId,RestaurantOwnerId,reviewText) VALUES(14,14,':(');
INSERT INTO ReviewResponse(ReviewId,RestaurantOwnerId,reviewText) VALUES(15,14,'Muito obrigado. Ficamos felizes que gostou');
INSERT INTO ReviewResponse(ReviewId,RestaurantOwnerId,reviewText) VALUES(18,15,'Obrigado ;)');