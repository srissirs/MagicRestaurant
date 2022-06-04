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
	RestaurantOwner INT,
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
	DishCategory INTEGER  NOT NULL,
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
	OrderDate DATE,
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
	CONSTRAINT PK_ReviewRestaurant PRIMARY KEY  (ReviewId)
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
	CategoryName NVARCHAR(40)	
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

CREATE INDEX IFK_CategoryRestaurantRestaurantId ON Restaurant (RestaurantId);
CREATE INDEX IFK_CategoryRestaurantCategoryId ON Category (CategoryId);

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

INSERT INTO Customer (CustomerId, FirstName, LastName, CustomerAddress, CustomerCity, CustomerCountry, CustomerPostalCode, CustomerPhone, CustomerEmail, Password,Username, RestaurantOwner) 
VALUES (1, 'Teresa', 'Ferreira', 'Rua das Flores', 'Braga', 'Portugal', '4400-403', '913746653', 'teresa.ferreira@gmail.com', '2ea6201a068c5fa0eea5d81a3863321a87f8d533','Tete',1 ),
(2, 'Carlos', 'Almeida', 'Rua do sapo', 'Porto', 'Portugal', '4500-406', '913722613', 'carlosalmeida@gmail.com', '5f1cf9d7c7baf267c3ff2896dfa522612452e565','Cambalhota',1 ),
(3, 'Susana', 'Almeida', 'Rua das cerpas', 'Coimbra', 'Portugal', '4501-416', '935477854', 'susana@hotmail.com','261503def9f6f3c38ba9e723d25de9576455f6bd' ,'User1212',1 ),
(4, 'Hugo', 'Pereira', 'Rua das almas', 'Paredes', 'Portugal', '4502-404', '915873093', 'hugo2000@gmail.com',  '17b6c082db6729968a80dd994847036735af63fa','Senhor Restaurant',1),
(5, 'Rui', 'das Cruzes', 'Rua da praceta', 'Almada', 'Portugal', '4200-446', '915943573', 'cruzrui@gmail.com',  'a0fe0efefb2359ede56352cf425055951dd0e511','Nice',1 ),
(6, 'Sara Isabel', 'Correia', 'Rua dos lobos', 'Baltar', 'Portugal', '4400-422', '939822005', 'scorreia@gmail.com', '92b66370c2874c0bdcacc669cb433ae6daa5f053','Desformatado',1),
(7, 'Ana Maria', 'Santos', 'Rua dos Santos', 'Paredes', 'Portugal', '4402-407', '965587974', 'anamaria@hotmail.com','3684acf97bbe609b8bb2e0fe965a6598a81ec4b9','User12123' ,1),
(8, 'Carlota', 'Teixeira Ferreira', 'Rua Escola da Souta', 'Viana do Castelo', 'Portugal', '4312-401', '935488623', 'carlota@hotmail.com','4d1b627ed82d6d713d0175d72bc2f414a3e0dbfb' ,'Lopes',1  ),
(9, 'Carlota', 'Teixeira Ferreira', 'Rua Escola da Souta', 'Viana do Castelo', 'Portugal', '4312-401', '935488623', 'carlota@hotmail.com','f2988cd2a9c0be376f4e1182baec57852342c999' ,'LTW' ,1),
(10,'Carla','Penedo Penedo','Rua dos Clérigos','Porto','Portugal','4900-231','963258750','carlacarla@gmail.com','b67ffcc48fd4c495c633880edf052179898c5287','Customer',1),
(11,'Pedro','Lee','Rua Maira Alberta','Porto','Portugal','4900-323','96258741','pedrooo@gmail.com','1014c1c251dad729d3e05337a090b5624b34a780','PL',0),
(12,'Tiago','Pessoa','Rua Mãe','Lisboa','Portugal','4200-212','9684321','21123@gmail.com','9c0f61b68f0219823fcfab86e534926450ba8a08','TiagoPessoa2021',0),
(13,'Sara','Tenente','Rua ALbertina Conceição','Porto','Portugal','4200-978','965412300','Sris@hotmail.com','629ab68ce423925a9aab63e1495368b407064c98','SrisSris',0),
(14,'Luisa','Lima','Rua dos Olhos Azuis','Porto','Porto','4900-121','965412300','jiokl@gmail.com','93c8e75c919c4865739ef898c41f1f66cfabfa37','Luisaa',0),
(15,'Clara','Claridade','Rua Casa Ajuda','Porto','Portugal','4900-123','987456321','party@gmail.com','c654096707eb03dae337dcc8176cba4774c6050f','Lolo',0);


INSERT INTO Category(CategoryId,CategoryName) VALUES(1,'Comida Portuguesa');
INSERT INTO Category(CategoryId,CategoryName) VALUES(2,'Fast Food');
INSERT INTO Category(CategoryId,CategoryName) VALUES(3,'Comida Indiana');
INSERT INTO Category(CategoryId,CategoryName) VALUES(4,'Comida Brasileira');
INSERT INTO Category(CategoryId,CategoryName) VALUES(5,'Comida Chinesa');
INSERT INTO Category(CategoryId,CategoryName) VALUES(6,'Comida Japonesa');
INSERT INTO Category(CategoryId,CategoryName) VALUES(7,'Comida Espanhola');
INSERT INTO Category(CategoryId,CategoryName) VALUES(8,'Comida Francesa');
INSERT INTO Category(CategoryId,CategoryName) VALUES(9,'Comida Mexicana');
INSERT INTO Category(CategoryId,CategoryName) VALUES(10,'Comida Vietnamisa');
INSERT INTO Category(CategoryId,CategoryName) VALUES(11,'Comida Russa');
INSERT INTO Category(CategoryId,CategoryName) VALUES(12,'Comida Italiana');
INSERT INTO Category(CategoryId,CategoryName) VALUES(13,'Comida Egípcia');
INSERT INTO Category(CategoryId,CategoryName) VALUES(14,'Comida Tailandesa');
INSERT INTO Category(CategoryId,CategoryName) VALUES(15,'Comida Alemã');






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


INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(1,'Sopa de Pedra',8.25,1,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(2,'Bitoque',3.65,1,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(3,'Francesinha',05,1,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(4,'Polvo à Lagareiro',4.95,1,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(5,'Arroz de Polvo',2.35,1,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(6,'Tripas à Moda do Porto',1.35,1,1);

INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(7,'Hambúrguer',9.95,1,2);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(8,'Batatas Fritas',5.75,1,2);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(9,'Gelado',6.75,1,2);

INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(10,'Caril',9.55,1,3);


INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(1,1);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(1,2);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(1,3);


INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(11,'Frango na manteiga',4.85,2,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(12,'Caril de Peice',4.15,2,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(13,'Vindaloo',0.65,2,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(14,'Samosa',35,2,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(15,' Lassi',6.35,2,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(16,'Pão de Queijo',3.35,2,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(17,'Coxinha',6.65,2,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(18,'Arroz com feij├úo',1.15,2,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(19,'Feijoada',8.35,2,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(20,'Farofa',9.35,2,4);

INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(2,3);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(2,4);

INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(21,'Carne-de-Sol',3.95,3,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(22,'Porco Agridoce',25,3,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(23,'Frango Gong Bao',5.45,3,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(24,'Arroz Frito',5.35,3,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(25,'Pato de Pequim',1.55,3,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(26,'Dumplings',7.65,3,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(27,'Sushi',2.15,3,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(28,'Hossomakis',8.55,3,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(29,'Sashimi',4.15,3,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(30,'Yakisoba',1.25,3,6);

INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(3,4);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(3,5);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(3,6);

INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(31,'Robata',3.95,4,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(32,'Uramakis',6.85,4,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(33,'Niguiri',8.15,4,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(34,'Tempura',4.85,4,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(35,'Temakis',9.55,4,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(36,'Paella',8.15,4,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(37,'Cocido madrileño',9.45,4,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(38,'Gazpacho',8.65,4,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(39,'Tortilla española',3.65,4,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(40,'Torta de Santiago',9.65,4,7);

INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(4,6);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(4,7);

INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(41,'Tapas espanholas',2.45,5,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(42,'Magret de canard',1.65,5,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(43,'Moules frites',2.25,5,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(44,'Soufflê au fromage',9.25,5,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(45,'Tacos',0.15,5,9);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(46,'Fajitas',3.35,5,9);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(47,'Pho Hanói',7.75,5,10);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(48,'Borscht',85,5,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(49,'Smetana',5.75,5,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(50,'Solyanka',6.55,5,11);

INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(5,7);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(5,8);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(5,9);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(5,10);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(5,11);

INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(51,'Stroganov',6.55,6,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(52,'Shashlyk',3.85,6,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(53,'Kholodets',5.25,6,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(54,'Lasanha ',25,6,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(55,'Pizza',75,6,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(56,'Bisteca Fiorentina',5.95,6,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(57,'Macarrão à Bolonhesa',1.25,6,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(58,'Risoto',3.65,6,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(59,'Cacio e Pepe',9.45,6,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(60,'Ful medames',1.25,6,13);

INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(6,11);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(6,12);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(6,13);

INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(61,'Hamam mahshi',8.55,7,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(62,'Hawawshi',5.25,7,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(63,'Kebab',6.45,7,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(64,'PAD THAI',25,7,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(65,'KAI MED MA MUANG (GALINHA COM CAJU)',0.15,7,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(66,'GAENG MATSAMAN (CARIL MASSAMAN)',8.75,7,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(67,'KHAO PAD (ARROZ FRITO)',5.15,7,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(68,'GAENG DAENG (CARIL VERMELHO)',4.15,7,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(69,'Eisbein',5.25,7,15);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(70,'Sauerkraut',3.45,7,15);

INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(7,13);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(7,14);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(7,15);

INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(71,'Kartoffelsalat',0.85,8,15);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(72,'Sopa de Pedra',75,8,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(73,'Bitoque',7.85,8,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(74,'Francesinha',6.15,8,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(75,'Polvo à Lagareiro',1.15,8,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(76,'Arroz de Polvo',4.95,8,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(77,'Tripas à Moda do Porto',7.45,8,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(78,'Hambúrguer',3.35,8,2);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(79,'Batatas Fritas',1.85,8,2);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(80,'Gelado',9.15,8,2);


INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(8,15);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(8,1);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(8,2);

INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(81,'Caril',0.15,9,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(82,'Frango na manteiga',45,9,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(83,'Caril de Peice',4.25,9,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(84,'Vindaloo',1.95,9,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(85,'Samosa',1.25,9,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(86,' Lassi',4.25,9,3);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(87,'Pão de Queijo',3.35,9,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(88,'Coxinha',0.95,9,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(89,'Arroz com feij├úo',9.65,9,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(90,'Feijoada',1.85,9,4);


INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(9,3);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(9,4);

INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(91,'Farofa',7.25,10,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(92,'Carne-de-Sol',5.85,10,4);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(93,'Porco Agridoce',2.45,10,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(94,'Frango Gong Bao',4.15,10,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(95,'Arroz Frito',8.45,10,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(96,'Pato de Pequim',5.15,10,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(97,'Dumplings',1.95,10,5);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(98,'Sushi',5.35,10,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(99,'Hossomakis',5.15,10,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(100,'Sashimi',5.55,10,6);


INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(10,4);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(10,5);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(10,6);

INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(101,'Yakisoba',2.95,11,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(102,'Robata',6.15,11,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(103,'Uramakis',5.25,11,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(104,'Niguiri',1.15,11,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(105,'Tempura',1.95,11,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(106,'Temakis',3.95,11,6);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(107,'Paella',0.85,11,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(108,'Cocido madrileño',4.95,11,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(109,'Gazpacho',7.15,11,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(110,'Tortilla española',4.65,11,7);


INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(11,6);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(11,7);

INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(111,'Torta de Santiago',3.55,12,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(112,'Tapas espanholas',15,12,7);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(113,'Magret de canard',105,12,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(114,'Moules frites',5.95,12,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(115,'Soufflê au fromage',2.15,12,8);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(116,'Tacos',8.55,12,9);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(117,'Fajitas',7.85,12,9);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(118,'Pho Hanói',1.35,12,10);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(119,'Borscht',0.55,12,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(120,'Smetana',6.25,12,11);


INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(12,7);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(12,8);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(12,9);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(12,10);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(12,11);

INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(121,'Solyanka',85,13,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(122,'Stroganov',5.75,13,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(123,'Shashlyk',7.45,13,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(124,'Kholodets',8.45,13,11);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(125,'Lasanha ',2.95,13,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(126,'Pizza',25,13,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(127,'Bisteca Fiorentina',7.35,13,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(128,'Macarrão à Bolonhesa',3.15,13,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(129,'Risoto',6.25,13,12);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(130,'Cacio e Pepe',9.35,13,12);


INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(13,11);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(13,12);

INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(131,'Ful medames',2.35,14,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(132,'Hamam mahshi',9.95,14,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(133,'Hawawshi',1.25,14,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(134,'Kebab',2.25,14,13);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(135,'PAD THAI',5.55,14,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(136,'KAI MED MA MUANG (GALINHA COM CAJU)',0.15,14,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(137,'GAENG MATSAMAN (CARIL MASSAMAN)',8.95,14,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(138,'KHAO PAD (ARROZ FRITO)',15,14,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(139,'GAENG DAENG (CARIL VERMELHO)',5.65,14,14);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(140,'Eisbein',8.15,14,15);

INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(14,13);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(14,14);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(14,15);

INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(141,'Sauerkraut',8.95,15,15);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(142,'Kartoffelsalat',3.95,15,15);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(143,'Sopa de Pedra',2.85,15,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(144,'Bitoque',3.25,15,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(145,'Francesinha',0.75,15,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(146,'Polvo à Lagareiro',9.45,15,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(147,'Arroz de Polvo',5.75,15,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(148,'Tripas à Moda do Porto',3.95,15,1);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(149,'Hambúrguer',65,15,2);
INSERT INTO DISH(DishId,DishName,DishPrice,RestaurantId,DishCategory) VALUES(150,'Batatas Fritas',1.45,15,2);

INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(15,15);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(15,1);
INSERT INTO CategoryRestaurant(RestaurantId,CategoryId) VALUES(15,2);

INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(1,1,24,'received','2022-5-25');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(2,2,23,'received','2022-5-24');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(3,3,22,'received','2022-5-24');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(4,4,21,'received','2022-5-23');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(5,5,20,'received','2022-5-22');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(6,6,19,'received','2022-5-22');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(7,7,18,'received','2022-5-22');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(8,8,17,'received','2022-5-22');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(9,9,16,'preparing','2022-5-22');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(10,11,15,'preparing','2022-5-22');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(11,12,14,'preparing','2022-5-21');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(12,1,13,'preparing','2022-5-20');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(13,2,12,'preparing','2022-5-20');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(14,2,11,'preparing','2022-5-15');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(15,11,10,'preparing','2022-5-15');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(16,13,9,'preparing','2022-5-15');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(17,3,8,'preparing','2022-5-14');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(18,4,7,'preparing','2022-5-13');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(19,6,6,'preparing','2022-5-13');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(20,3,5,'preparing','2022-5-13');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(21,11,4,'preparing','2022-5-12');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(22,12,3,'preparing','2022-5-11');

INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(23,1,1,'ready','2022-5-6');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(24,2,2,'ready','2022-5-5');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(25,3,3,'ready','2022-5-4');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(26,4,4,'ready','2022-5-3');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(27,5,5,'ready','2022-5-2');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(28,6,6,'ready','2022-5-1');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(29,7,7,'ready','2022-5-1');

INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(31,8,4,'delivered','2022-04-27');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(32,9,5,'delivered','2022-04-24');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(33,10,6,'delivered','2022-04-24');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(34,11,1,'delivered','2022-4-22');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(35,12,2,'delivered','2022-04-14');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(36,13,11,'delivered','2022-04-13');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(37,15,22,'delivered','2022-04-4');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(38,7,20,'delivered','2022-04-3');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(39,9,13,'delivered','2022-4-2');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(40,2,16,'delivered','2022-4-1');

INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(41,1,2,'delivered','2022-03-1');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(42,3,1,'delivered','2022-03-14');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(43,4,11,'delivered','2022-03-17');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(44,5,12,'delivered','2022-03-05');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(45,6,13,'delivered','2022-02-02');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(46,14,7,'delivered','2022-02-01');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(47,14,8,'delivered','2022-02-05');

INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(48,1,3,'delivered','2021-02-15');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(49,3,6,'delivered','2021-01-30');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(50,4,1,'delivered','2021-01-17');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(51,5,2,'delivered','2021-03-05');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(52,6,3,'delivered','2021-01-05');

INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(53,11,7,'delivered','2021-01-05');
INSERT INTO CustomerOrder(OrderId,RestaurantId,CustomerId,OrderState,OrderDate) VALUES(54,11,8,'delivered','2021-01-05');

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
INSERT INTO ReviewResponse(ReviewId,RestaurantOwnerId,reviewText) VALUES(17,15,'Obrigado ;)');