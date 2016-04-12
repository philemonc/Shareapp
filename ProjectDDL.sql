CREATE TABLE member (
name VARCHAR (64) NOT NULL,
email VARCHAR(256) PRIMARY KEY,
password VARCHAR(16) NOT NULL,
address VARCHAR (256) NOT NULL,
contactNumber INT NOT NULL,
adminFlag BIT NOT NULL
);

CREATE TABLE item (
email VARCHAR(64) REFERENCES member(email) ON DELETE CASCADE,
type CHAR(10) CHECK(type='tools' OR type='appliances' OR type='furnitures' OR type='books'),
itemID INT PRIMARY KEY,
feeFlag BIT NOT NULL,
itemName VARCHAR(256) NOT NULL,
pickupLocation VARCHAR(256) NOT NULL,
returnLocation VARCHAR(256) NOT NULL,
availableDate DATE NOT NULL,
description VARCHAR(256),
availabilityFlag BIT NOT NULL
);

CREATE TABLE bidding (
name VARCHAR(64),
email VARCHAR(256) REFERENCES member(email) ON DELETE CASCADE,
feeAmount MONEY NOT NULL,
itemID INT REFERENCES item(itemID) ON DELETE CASCADE,
itemName VARCHAR(256),
PRIMARY KEY (email, itemID),
dateTime TIMESTAMP,
successbid BIT NOT NULL,
pendingstatus BIT NOT NULL
);

CREATE TABLE loan (
borrower VARCHAR(256) REFERENCES member(email) ON DELETE CASCADE,
lender VARCHAR(256) REFERENCES member(email) ON DELETE CASCADE,
itemID INT REFERENCES item(itemID) ON DELETE CASCADE,
borrowDate DATE,
returnDate DATE,
CHECK(returnDate>=borrowDate),
PRIMARY KEY (borrower, lender, itemID)
);
