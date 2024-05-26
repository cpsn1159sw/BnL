-- Creating the database and using it
CREATE DATABASE IF NOT EXISTS db_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_shop;

-- Creating tables with constraints

CREATE TABLE Administrator (
    AdminID INT PRIMARY KEY AUTO_INCREMENT,
    FullName VARCHAR(100) NOT NULL,
    Address VARCHAR(255),
    Email VARCHAR(100) UNIQUE NOT NULL,
    Phone VARCHAR(20) UNIQUE NOT NULL,
    Password VARCHAR(100) NOT NULL,
    Role VARCHAR(20)
);
CREATE TABLE logintokenA (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    AdminID INT NOT NULL,
    Token VARCHAR(100) DEFAULT NULL,
    Create_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Update_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (AdminID) REFERENCES Administrator(AdminID)
);
CREATE TABLE Categories (
    CategoryID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL
);

CREATE TABLE Customer (
    CustomerID INT PRIMARY KEY AUTO_INCREMENT,
    FullName VARCHAR(100) NOT NULL,
    Address VARCHAR(255) NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    Phone VARCHAR(20) UNIQUE NOT NULL,
    Password VARCHAR(100) NOT NULL,
    ForgotToken VARCHAR(255) NOT NULL,
    ActiveToken VARCHAR(255) NOT NULL,
    Status INT(1) NOT NULL DEFAULT 0,
    Create_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Update_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE logintokenC (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT NOT NULL,
    Token VARCHAR(100) DEFAULT NULL,
    Create_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Update_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)
);

CREATE TABLE Products (
    ProductID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL,
    Description TEXT,
    CategoryID INT,
    Price DECIMAL(18, 2),
    Size VARCHAR(20),
    StockQuantity INT,
    FOREIGN KEY (CategoryID) REFERENCES Categories(CategoryID)
);

CREATE TABLE Orders (
    OrderID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT,
    OrderDate DATETIME,
    Status VARCHAR(50),
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)
);

CREATE TABLE OrderDetails (
    OrderID INT,
    ProductID INT,
    Quantity INT,
    UnitPrice DECIMAL(18, 2),
    TotalAmount DECIMAL(18, 2),
    PRIMARY KEY (OrderID, ProductID),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID)
);

CREATE TABLE Exchange (
    ExchangeID INT PRIMARY KEY AUTO_INCREMENT,
    OrderDetailID INT,
    ProductID INT,
    Comment TEXT,
    ImageLink VARCHAR(255),
    FOREIGN KEY (OrderDetailID) REFERENCES OrderDetails(OrderID),
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID)
);

-- Adding CHECK constraints

ALTER TABLE Products
ADD CONSTRAINT chk_price CHECK (Price > 0);

ALTER TABLE Products
ADD CONSTRAINT chk_stockquantity CHECK (StockQuantity >= 0);

ALTER TABLE Orders
ADD CONSTRAINT chk_status CHECK (Status IN ('Delivered', 'Cancelled', 'Pending'));

ALTER TABLE OrderDetails
ADD CONSTRAINT chk_unitprice CHECK (UnitPrice > 0);

ALTER TABLE OrderDetails
ADD CONSTRAINT chk_quantity CHECK (Quantity > 0);
