CREATE TABLE Comments (
  comm_id INT (11) NOT NULL AUTO_INCREMENT,
  user_id INT (11) NOT NULL,
  post_id INT (11) NOT NULL,
  creationDate DATETIME,
  PRIMARY KEY (comm_id),
  FOREIGN KEY (post_id) REFERENCES Tweets (tweet_id)
);