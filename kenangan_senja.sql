CREATE DATABASE kenangan_senja;
USE kenangan_senja;

CREATE TABLE users (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  email VARCHAR(255),
  password VARCHAR(255)
);

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Admin', 'kenangansenja@gmail.com', '$2y$10$nmVj3/M3ThvpM3OQdYU2B.MQ9fJWL7vpf90dawhDXobbY47xuK8Su');

CREATE TABLE menus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    menu_name VARCHAR(255),
    menu_image VARCHAR(255),
    description TEXT,
    price DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  menu_id INT(11),
  orderer_name VARCHAR(255),
  quantity VARCHAR(255),
  table_number VARCHAR(255),
  status VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO menus (menu_name, menu_image, description, price, created_at, updated_at) 
VALUES ('Espresso', 'menu.jpg', NULL , 15000, NOW(), NOW());

