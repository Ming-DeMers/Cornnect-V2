CREATE TABLE users (
  id INTEGER NOT NULL UNIQUE,
  name TEXT NOT NULL,
  netid TEXT NOT NULL UNIQUE,
  year INTEGER NOT NULL,
  major TEXT NOT NULL,
  clubs TEXT,
  interests TEXT,
  bio TEXT,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT)
);

CREATE TABLE sessions (
  id INTEGER NOT NULL UNIQUE,
  user_id INTEGER,
  netid TEXT,
  session TEXT NOT NULL UNIQUE,
  last_login TEXT NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT) FOREIGN KEY (netid) REFERENCES users(netid)
);

CREATE TABLE groups (
  id INTEGER NOT NULL UNIQUE,
  name TEXT NOT NULL UNIQUE,
  PRIMARY KEY(id AUTOINCREMENT)
);

CREATE TABLE user_groups (
  id INTEGER NOT NULL UNIQUE,
  netid INTEGER NOT NULL,
  group_id INTEGER NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT) FOREIGN KEY(netid) REFERENCES users(netid),
  FOREIGN KEY(group_id) REFERENCES groups(id)
);

CREATE TABLE posts (
  id INTEGER NOT NULL UNIQUE,
  netid TEXT NOT NULL,
  date INTEGER NOT NULL,
  location TEXT,
  desc TEXT,
  file_name TEXT NOT NULL,
  file_ext TEXT NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT) FOREIGN KEY (netid) REFERENCES users(netid)
);

CREATE TABLE comments (
  id INTEGER NOT NULL UNIQUE,
  post_id INTEGER NOT NULL UNIQUE,
  netid TEXT NOT NULL UNIQUE,
  date INTEGER NOT NULL,
  comment TEXT NOT NULL,
  PRIMARY KEY (id AUTOINCREMENT) FOREIGN KEY (post_id) REFERENCES posts(id) FOREIGN KEY (netid) REFERENCES users(netid)
);

CREATE TABLE tags (
  id INTEGER NOT NULL UNIQUE,
  post_id INTEGER NOT NULL,
  tag TEXT NOT NULL,
  PRIMARY KEY (id AUTOINCREMENT) FOREIGN KEY (post_id) REFERENCES posts(id)
);

INSERT INTO
  users (
    name,
    netid,
    year,
    major,
    clubs,
    interests,
    bio,
    username,
    password
  )
VALUES
  (
    'Johnny John Johnston',
    'jjj45',
    2011,
    'IT@Cornell',
    '',
    'Coding',
    'I am ur admin.',
    'jjj45',
    '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'
  );

INSERT INTO
  users (
    name,
    netid,
    year,
    major,
    clubs,
    interests,
    bio,
    username,
    password
  )
VALUES
  (
    'Ming DeMers',
    'mtd64',
    2025,
    'InfoSci',
    'CAC',
    'Coding',
    'I made this site lol.',
    'mtd64',
    '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'
  );

INSERT INTO
  users (
    name,
    netid,
    year,
    major,
    clubs,
    interests,
    bio,
    username,
    password
  )
VALUES
  (
    'Ezra Cornell',
    'ez455',
    2026,
    'Biology',
    NULL,
    NULL,
    "I'm the woman, not the founder!",
    'ez455',
    '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'
  );

INSERT INTO
  groups (id, name)
VALUES
  (1, 'admin');

-- user Johnny John Johnston is in admin group
INSERT INTO
  user_groups (netid, group_id)
VALUES
  ('jjj45', 1);

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'mtd64',
    2023 -03 -03,
    'Cafe Jennie',
    'Guys I am so hungry. But this INFO 2300 Website must come first!!',
    'CAFE_JENNIE.JPG',
    'jpg'
  );

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'ez455',
    2023 -03 - 30,
    'Clark Hall',
    'What? I just saw a person stealing a TV here, lol.',
    'TV_STEALING.JPG',
    'jpg'
  );

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'mtd64',
    2022,
    'The Bardo',
    "Help, I'm stuck!",
    'the_bardo.jpg',
    'jpg'
  );

INSERT INTO
  comments (post_id, netid, date, comment)
VALUES
  (
    1,
    'ez455',
    2023 -09 -20,
    'I am so hungry too. I am going to go get food. I will be back in 5 minutes.'
  );

INSERT INTO
  comments (post_id, netid, date, comment)
VALUES
  (
    2,
    'mtd64',
    2023 -09 -20,
    "Wasn't me!"
  );

INSERT INTO
  tags (post_id, tag)
VALUES
  (1, 'Cafe Jennie');

INSERT INTO
  tags (post_id, tag)
VALUES
  (1, 'hungry');

INSERT INTO
  tags (post_id, tag)
VALUES
  (2, 'Clark Hall');

INSERT INTO
  tags (post_id, tag)
VALUES
  (2, 'stealing');

INSERT INTO
  tags (post_id, tag)
VALUES
  (3, 'The Bardo');
