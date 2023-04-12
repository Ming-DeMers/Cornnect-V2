CREATE TABLE users (
  id INTEGER NOT NULL UNIQUE,
  name TEXT NOT NULL,
  netid TEXT NOT NULL UNIQUE,
  year INTEGER NOT NULL,
  major TEXT NOT NULL,
  clubs TEXT,
  interests TEXT,
  bio TEXT,
  PRIMARY KEY(id AUTOINCREMENT)
);

CREATE TABLE posts (
  id INTEGER NOT NULL UNIQUE,
  netid TEXT NOT NULL UNIQUE,
  date INTEGER NOT NULL,
  location TEXT,
  desc TEXT,
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
  users (name, netid, year, major, clubs, interests, bio)
VALUES
  (
    'Ming DeMers',
    'mtd64',
    2025,
    'InfoSci',
    'CAC',
    'Coding',
    'I made this site lol.'
  );

INSERT INTO
  users (name, netid, year, major, clubs, interests, bio)
VALUES
  (
    'Ezra Cornell',
    'ez455',
    2026,
    'Biology',
    NULL,
    NULL,
    "I'm the woman, not the founder!"
  );

INSERT INTO
  posts (netid, date, location, desc)
VALUES
  (
    'mtd64',
    2023 -03 -03,
    'Cafe Jennie',
    'Guys I am so hungry. But this INFO 2300 Website must come first!!'
  );

INSERT INTO
  posts (netid, date, location, desc)
VALUES
  (
    'ez455',
    2023 -03 - 30,
    'Clark Hall',
    'What? I just saw a person stealing a TV here, lol.'
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
