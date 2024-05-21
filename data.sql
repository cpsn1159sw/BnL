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
    Role VARCHAR(20) CHECK (Role IN ('Admin'))
);

CREATE TABLE Categories (
    CategoryID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL
);

CREATE TABLE Customer (
    CustomerID INT PRIMARY KEY AUTO_INCREMENT,
    FullName VARCHAR(100),
    Address VARCHAR(255),
    Email VARCHAR(100) UNIQUE NOT NULL,
    Phone VARCHAR(20) UNIQUE NOT NULL,
    Password VARCHAR(100),
    ForgotToken VARCHAR(255),
    ActiveToken VARCHAR(255),
    Status INT(1) NOT NULL DEFAULT 0,
    Create_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Update_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE Products (
    ProductID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL,
    Description TEXT,
    CategoryID INT,
    Price DECIMAL(18, 2),
    Size VARCHAR(20),
    Color VARCHAR(50),
    StockQuantity INT,
    FOREIGN KEY (CategoryID) REFERENCES Categories(CategoryID)
);

CREATE TABLE Orders (
    OrderID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT,
    OrderDate DATETIME,
    TotalAmount DECIMAL(18, 2),
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)
);

CREATE TABLE Revenue (
    RevenueID INT PRIMARY KEY AUTO_INCREMENT,
    OrderID INT,
    Date DATE,
    Amount DECIMAL(18, 2),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID)
);

CREATE TABLE Feedback (
    FeedbackID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT,
    ProductID INT,
    Rating INT,
    Comment TEXT,
    Date DATE,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID),
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID)
);

CREATE TABLE OrderDetails (
    OrderDetailID INT PRIMARY KEY AUTO_INCREMENT,
    OrderID INT,
    ProductID INT,
    Quantity INT,
    UnitPrice DECIMAL(18, 2),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID)
);

-- Adding CHECK constraints
ALTER TABLE Revenue
ADD CONSTRAINT CHECK (Amount >= 0);

ALTER TABLE Products
ADD CONSTRAINT CHECK (Price > 0);

ALTER TABLE Products
ADD CONSTRAINT CHECK (StockQuantity >= 0);

ALTER TABLE Orders
ADD CONSTRAINT CHECK (TotalAmount > 0);

ALTER TABLE OrderDetails
ADD CONSTRAINT CHECK (UnitPrice > 0);

ALTER TABLE OrderDetails
ADD CONSTRAINT CHECK (Quantity > 0);