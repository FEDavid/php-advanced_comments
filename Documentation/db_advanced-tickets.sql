CREATE DATABASE db_advanced_tickets;
USE db_advanced_tickets;

CREATE TABLE Users (
    user_id INT NOT NULL AUTO_INCREMENT,
    user_name CHAR(50) NOT NULL,
    user_password VARCHAR(100) NOT NULL,
    PRIMARY KEY (user_id)
);

CREATE TABLE Posts (
    post_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    post_content TEXT NOT NULL,
    PRIMARY KEY (post_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

CREATE TABLE Comments (
    comment_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    comment_content TEXT NOT NULL,
    PRIMARY KEY (comment_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (post_id) REFERENCES Posts(post_id)
);

CREATE TABLE Comment_reply (
    user_id INT NOT NULL,
    comment_id INT NOT NULL,
    reply_content TEXT NOT NULL,
    PRIMARY KEY (user_id, comment_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (comment_id) REFERENCES Comments(comment_id)
);

INSERT INTO Users (user_name, user_password) VALUES
('Alice', 'password123'),
('Bob', 'securepass'),
('Charlie', 'pass456');

INSERT INTO Posts (user_id, post_content) VALUES
(1, 'This is Alice\'s first post'),
(2, 'Bob shares his thoughts here'),
(3, 'Charlie talks about coding');

INSERT INTO Comments (user_id, post_id, comment_content) VALUES
(2, 1, 'Nice post Alice!'),
(3, 1, 'Interesting thoughts!'),
(1, 2, 'I agree with this.'),
(3, 3, 'Great content!');

INSERT INTO Comment_reply (user_id, comment_id, reply_content) VALUES
(1, 1, 'Thank you Bob!'),
(1, 2, 'Glad you liked it Charlie!'),
(2, 3, 'Thanks for the support Alice!'),
(3, 4, 'Thanks, Charlie!');
