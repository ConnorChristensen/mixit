CREATE TABLE IF NOT EXISTS Users (
    `username` VARCHAR(30) UNIQUE NOT NULL,
    `password` VARCHAR(120) NOT NULL,
    `email` VARCHAR(60) NOT NULL,
    `status` VARCHAR(60) DEFAULT "user",
    PRIMARY KEY (`username`),
    FOREIGN KEY (`username`) references Fav_Bevs(`username`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS Bevs (
    `bevId` INT(6) UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(30) NOT NULL,
    `type` VARCHAR(30),
    `glass` VARCHAR(20),
    `photo` VARCHAR(30),
    `description` VARCHAR(50),
    `instructions` VARCHAR(50),
    `ingredientList` VARCHAR(50),
    PRIMARY KEY (`bevId`),
    FOREIGN KEY (`bevId`) references Bev_Rating(`bevId`)   
);


CREATE TABLE IF NOT EXISTS User_Liked (
    `username` VARCHAR(30) NOT NULL,
    `bevId` INT(6) NOT NULL,                  
    PRIMARY KEY (`username`, `bevId`),
    FOREIGN KEY (`bevId`) references Bevs(`bevId`)
);


CREATE TABLE IF NOT EXISTS Ingredients (
    `name` VARCHAR(30) NOT NULL,
    `bevId` INT(6) NOT NULL,
    PRIMARY KEY (`name`, `bevId`),
    FOREIGN KEY (`bevId`) references Bevs(`bevId`)
        ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS Type (
    `name` VARCHAR(30) NOT NULL,
    `bevId` INT(6) NOT NULL,
    PRIMARY KEY (`name`, `bevId`),
    FOREIGN KEY (`bevId`) references Bevs(`bevId`)
        ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS Bev_Rating (
    `bevId` INT(6) UNIQUE NOT NULL,
    `likes` INT(10) DEFAULT 0,
    PRIMARY KEY (`bevId`)
);


CREATE TRIGGER `addBevsToTables` 
    AFTER INSERT ON `Bevs`
    FOR EACH ROW 
    BEGIN
        INSERT INTO Bev_Rating(`bevId`)
            VALUES (New.bevId);
        INSERT INTO Type
            VALUES (New.type, New.bevId);
    END;


CREATE TRIGGER `userLiked`
    AFTER INSERT ON `User_Liked`
    FOR EACH ROW
    BEGIN
        UPDATE Bev_Rating
            SET likes = likes + 1
            WHERE bevId = New.bevId;
    END;
 
 
CREATE TRIGGER `userUnliked`
    AFTER DELETE ON `User_Liked`
    FOR EACH ROW
    BEGIN
        UPDATE Bev_Rating
            SET likes = likes - 1
            WHERE bevId = New.bevId;
    END;







