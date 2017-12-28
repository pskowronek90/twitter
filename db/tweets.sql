CREATE TABLE Tweets (
  tweet_id int(11) NOT NULL,
  user_id int(11) DEFAULT NULL,
  text text NOT NULL,
  creationDate datetime,
  PRIMARY KEY (comm_id),
  FOREIGN KEY (user_id) REFERENCES Users (id)
);