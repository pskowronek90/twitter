CREATE TABLE Tweets (
tweet_id INT (11) NOT NULL AUTO_INCREMENT,
user_id INT (11),
username VARCHAR (255) NOT NULL,
text TEXT NOT NULL,
creationDate DATETIME,
PRIMARY KEY (tweet_id),
FOREIGN KEY (user_id) REFERENCES Users (id)
);