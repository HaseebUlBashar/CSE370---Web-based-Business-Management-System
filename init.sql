
CREATE DATABASE IF NOT EXISTS business_db;
USE business_db;

CREATE TABLE users(
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(100),
  role VARCHAR(20)
);
INSERT INTO users(username,password,role) VALUES
('manager',MD5('manager123'),'manager'),
('employee',MD5('employee123'),'employee');

CREATE TABLE products(
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  buying_price DECIMAL(10,2),
  selling_price DECIMAL(10,2),
  stock INT,
  sold INT DEFAULT 0
);
INSERT INTO products(name,buying_price,selling_price,stock) VALUES
('Soap',20,30,50),
('Shampoo',50,80,40),
('Rice',40,55,100);

CREATE TABLE employees(
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  shift VARCHAR(50),
  monthly_salary DECIMAL(10,2),
  start_date DATE
);
INSERT INTO employees(name,shift,monthly_salary,start_date) VALUES
('Alice','Morning',15000,'2024-01-01'),
('Bob','Evening',16000,'2024-02-01');

CREATE TABLE sales_log(
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT,
  qty INT,
  price DECIMAL(10,2),
  sale_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE restock_log(
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT,
  qty INT,
  expense DECIMAL(10,2),
  restock_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE revenue_daily(
  date DATE PRIMARY KEY,
  earning DECIMAL(10,2),
  expenses DECIMAL(10,2),
  profit DECIMAL(10,2)
);

CREATE TABLE to_be_restocked(
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT,
  needed INT,
  date DATE
);
