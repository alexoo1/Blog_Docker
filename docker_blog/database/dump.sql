CREATE TABLE user (
    userid int UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    lastName varchar(255),
    firstName varchar(255),
    email varchar(255),
    password varchar(255)
);

CREATE TABLE article(
    blogid INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    titre varchar(15),
    description text,
    date date,
    userid int UNSIGNED NOT NULL,
    FOREIGN KEY (userid) REFERENCES user(userid)
);

CREATE TABLE comment(
    commentid INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    description text,
    date datetime,
    userid int UNSIGNED NOT NULL,
    FOREIGN KEY (userid) REFERENCES user(userid)
);

INSERT INTO user (lastName, firstName, email, password)
VALUES ('toto', 'titi', 'titi@toto.com', 'titi');