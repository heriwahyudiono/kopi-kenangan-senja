CREATE DATABASE kenangan_senja;
USE kenangan_senja;

CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    menu_name VARCHAR(255),
    menu_image VARCHAR(255),
    description TEXT,
    price DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO menu (menu_name, menu_image, description, price, created_at, updated_at) 
VALUES ('Espresso', 'menu.jpg', '-', 15000, NOW(), NOW());


