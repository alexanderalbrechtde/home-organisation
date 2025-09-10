<?php

$pdo = new PDO('sqlite:' . __DIR__ . '/home-organisation.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$pdo->exec("DROP TABLE IF EXISTS user");
$pdo->exec("DROP TABLE IF EXISTS room");
$pdo->exec("DROP TABLE IF EXISTS reminder");
$pdo->exec("DROP TABLE IF EXISTS item");
$pdo->exec("DROP TABLE IF EXISTS user_to_room");
$pdo->exec("DROP TABLE IF EXISTS room_to_reminder");
$pdo->exec("DROP TABLE IF EXISTS user_to_reminder");
$pdo->exec("DROP TABLE IF EXISTS item_to_user");
$pdo->exec("DROP TABLE IF EXISTS item_to_room");


$pdo->exec("
    CREATE TABLE user(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
       first_Name TEXT(30) NOT NULL,
       last_Name TEXT(30) NOT NULL,
       email TEXT(30) NOT NULL,
       password TEXT(30) NOT NULL
);
    CREATE TABLE room(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT(30) NOT NULL,
        description TEXT,
        created_by INTEGER NOT NULL,
        created_at TEXT NOT NULL DEFAULT (datetime('now')),
        FOREIGN KEY (created_by) REFERENCES user(id)
);
    CREATE TABLE reminder(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT(20) NOT NULL,
        notes TEXT,
        due_at TEXT,
        priority INTEGER NOT NULL,
        status TEXT NOT NULL DEFAULT 'open' CHECK (status IN ('open','done','snoozed','archived')),
        created_at TEXT NOT NULL DEFAULT (datetime('now')),
        created_by INTEGER NOT NULL,
        created_for INTEGER NOT NULL,
        FOREIGN KEY (created_by) REFERENCES user(id),
        FOREIGN KEY (created_for) REFERENCES room(id)
);
    CREATE TABLE item(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT(30) NOT NULL,
        category TEXT(30) NOT NULL,
        amount INTEGER NOT NULL CHECk(amount >=0),
        created_by INTEGER NOT NULL,
        created_for INTEGER NOT NULL,
        FOREIGN KEY (created_by) REFERENCES user(id),
        FOREIGN KEY (created_for) REFERENCES room(id)
);
CREATE UNIQUE INDEX IF NOT EXISTS uniq_item_name_category
  ON item(name, category);

    CREATE TABLE user_to_room(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        owner_user_id INTEGER NOT NULL,
        room_id INTEGER NOT NULL,
        FOREIGN KEY (owner_user_id) REFERENCES user(id),
        FOREIGN KEY (room_id) REFERENCES room(id)
);
    CREATE TABLE user_to_reminder(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        owner_user_id INTEGER NOT NULL,
        reminder_id INTEGER NOT NULL,
        FOREIGN KEY (owner_user_id) REFERENCES user(id),
        FOREIGN KEY (reminder_id) REFERENCES reminder(id)
);
    CREATE TABLE room_to_reminder(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        room_id INTEGER NOT NULL,
        reminder_id INTEGER NOT NULL,
        FOREIGN KEY (room_id) REFERENCES room(id),
        FOREIGN KEY (reminder_id) REFERENCES reminder(id)  
    );
    CREATE TABLE item_to_room(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        item_id INTEGER NOT NULL,
        room_id INTEGER NOT NULL,
        FOREIGN KEY (item_id) REFERENCES item(id),
        FOREIGN KEY (room_id) REFERENCES room(id)
    );
    CREATE TABLE item_to_user(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        item_id INTEGER NOT NULL,
        user_id INTEGER NOT NULL,
        FOREIGN KEY (item_id) REFERENCES item(id),
        FOREIGN KEY (user_id) REFERENCES user(id)
    );
"
);
