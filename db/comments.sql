CREATE TABLE Comments (
  comm_id INT (11) NOT NULL AUTO_INCREMENT,
  user_id INT (11),
  creationDate DATETIME,
  PRIMARY KEY (comm_id),
  FOREIGN KEY (user_id) REFERENCES Users (id)
);