DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Roles;
DROP TABLE IF EXISTS Destinations;
DROP TABLE IF EXISTS Reviews;
DROP TABLE IF EXISTS Images;
DROP TABLE IF EXISTS SneakyTable;

-- Table: Users
CREATE TABLE Users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    id_Role INTEGER DEFAULT 0 NOT NULL,
    FOREIGN KEY (id_Role) REFERENCES Roles (id)
);

-- Table: Roles
CREATE TABLE Roles (
    id INTEGER PRIMARY KEY,
    name TEXT NOT NULL
);

-- Table: Destinations
CREATE TABLE Destinations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT NOT NULL
);

-- Table: Reviews
CREATE TABLE Reviews (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    comment TEXT NOT NULL,
    rating INTEGER NOT NULL,
    id_User INTEGER NOT NULL,
    id_Destination INTEGER NOT NULL,
    FOREIGN KEY (id_User) REFERENCES User (id),
    FOREIGN KEY (id_Destination) REFERENCES Destination (id)
);

-- Table: Images
CREATE TABLE Images (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    path TEXT NOT NULL,
    id_Destination INTEGER NOT NULL,
    FOREIGN KEY (id_Destination) REFERENCES Destination (id)
);

CREATE TABLE SneakyTable (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL
);