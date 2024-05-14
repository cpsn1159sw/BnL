CREATE DATABASE db_shop
go
use db_shop
go
CREATE TABLE Administrator (
    AdminID INT PRIMARY KEY IDENTITY,
    Account VARCHAR(100) UNIQUE NOT NULL,
    Password VARCHAR(100) NOT NULL,
    FullName VARCHAR(100),
    Email VARCHAR(100),
    Phone VARCHAR(20),
    Address VARCHAR(255),
    Role VARCHAR(10) DEFAULT 'Admin' CHECK (Role IN ('Admin', 'Staff')) -- Role chỉ có thể là 'Admin' hoặc 'Staff'
);
CREATE TABLE Categories (
    CategoryID INT PRIMARY KEY IDENTITY,
    Name NVARCHAR(100) NOT NULL
);
CREATE TABLE Customer (
    CustomerID INT PRIMARY KEY IDENTITY,
    FullName NVARCHAR(100),
    Email NVARCHAR(100),
    Phone NVARCHAR(20),
    Address NVARCHAR(255),
	Account NVARCHAR(100) UNIQUE NOT NULL,
	Password NVARCHAR(100) UNIQUE NOT NULL
);
CREATE TABLE Products (
    ProductID INT PRIMARY KEY IDENTITY,
    Name NVARCHAR(100) NOT NULL,
    Description TEXT,
    CategoryID INT,
	Price DECIMAL(18, 2),
    Size NVARCHAR(20),
    Color NVARCHAR(50),
    StockQuantity INT,
    FOREIGN KEY (CategoryID) REFERENCES Categories(CategoryID)
);
CREATE TABLE Orders (
    OrderID INT PRIMARY KEY IDENTITY,
    CustomerID INT,
    OrderDate DATETIME,
    TotalAmount DECIMAL(18, 2),
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)
);
CREATE TABLE Revenue (
    RevenueID INT PRIMARY KEY IDENTITY,
    OrderID INT,
    Date DATE,
    Amount DECIMAL(18, 2),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID)
);
CREATE TABLE Feedback (
    FeedbackID INT PRIMARY KEY IDENTITY,
    CustomerID INT,
    ProductID INT,
    Rating INT,
    Comment NVARCHAR(MAX),
    Date DATE,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID),
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID)
);
CREATE TABLE OrderDetails (
    OrderDetailID INT PRIMARY KEY IDENTITY,
    OrderID INT,
    ProductID INT,
    Quantity INT,
    UnitPrice DECIMAL(18, 2),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID)
);

-- Thêm ràng buộc CHECK vào bảng Revenue
ALTER TABLE Revenue
ADD CONSTRAINT Amount CHECK (Amount >= 0);

-- Thêm ràng buộc CHECK vào bảng Products
ALTER TABLE Products
ADD CONSTRAINT Price CHECK (Price > 0);
ALTER TABLE Products
ADD CONSTRAINT StockQuantity CHECK (StockQuantity >= 0);

-- Thêm ràng buộc CHECK vào bảng Orders
ALTER TABLE Orders
ADD CONSTRAINT TotalAmount CHECK (TotalAmount > 0);

-- Thêm ràng buộc CHECK vào bảng OrderDetails
ALTER TABLE OrderDetails
ADD CONSTRAINT UnitPrice CHECK (UnitPrice > 0);
ALTER TABLE OrderDetails
ADD CONSTRAINT Quantity CHECK (Quantity > 0);