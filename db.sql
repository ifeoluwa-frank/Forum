CREATE DATABASE forum;


CREATE TABLE user_credentials(
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);


CREATE TABLE post_data(
    post_id INT AUTO INCREMENT PRIMARY KEY,
    post_title VARCHAR(255) NOT NULL,
    post_category VARCHAR(255) NOT NULL,
    post_content LONGTEXT NOT NULL
);


ALTER TABLE post_data
ADD COLUMN post_image VARCHAR(255);

ALTER TABLE post_data
ADD COLUMN read_count VARCHAR (255);


CREATE TABLE post_category(
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255) NOT NULL
);