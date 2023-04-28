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
    20230304,
    'Cafe Jennie',
    'Guys I am so hungry. But this INFO 2300 Website must come first!!',
    'CAFE_JENNIE.JPG',
    -- photo is courtesy of Cornell Store
    'jpg'
  );

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'ez455',
    20230420,
    'Clark Hall',
    'What? I just saw a person stealing a TV here, lol.',
    'TV_STEALING.JPG',
    -- Adobe stock, By stock28studio
    'jpg'
  );

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'mtd64',
    20221015,
    'The Bardo',
    "Help, I'm stuck!",
    'the_bardo.jpg',
    -- “Home & the Underworld,” by Antony Gormley, 1989. Earth, rabbit skin glue, and black pigment on paper. 28 x 38 cm.
    'jpg'
  );

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'mtd64',
    20230327,
    'Feeney Way',
    'Whoa! Is that The Pres and VP at Dragon Day??',
    'DDPres_2.JPG',
    -- Ming DeMers
    'jpg'
  );

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'ez455',
    20230324,
    'Temple of Zeus',
    "Ugh! I'm just trying to do some work at Zeus!",
    'Zeus_streaking.JPG',
    -- Ming DeMers
    'jpg'
  );

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'mtd64',
    20230327,
    'McGraw Tower',
    "I can see my house from up here! Here's a cool photo of GSH",
    'mcgraw_gsh.JPG',
    'jpg'
  );

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'ez455',
    20230127,
    'Libe Slope',
    "Whoa, the slope is so pretty at sunset!",
    'sunset_at_libe.JPG',
    'jpg'
  );

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'mtd64',
    20221212,
    'Lincoln Hall',
    "This a cappella concert is pretty good",
    'a8_concert.JPG',
    'jpg'
  );

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'ez455',
    20230126,
    'Lynah Rink',
    "go big red!",
    'mhockey.JPG',
    'jpg'
  );

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'ez455',
    20230227,
    'Ho Plaza',
    "dang, it's really cold today",
    'cold_day_campus.JPG',
    'jpg'
  );

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'mtd64',
    20230213,
    'Lindseth Climbing Center',
    "I love rock climbing! Go rocks!",
    'lindseth.JPG',
    'jpg'
  );

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'jjj45',
    20230123,
    'Big Red Barn',
    "Free chocolate going on right now!",
    'chocolada.JPG',
    'jpg'
  );

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'mtd64',
    20230307,
    'Libe Slope',
    "Cornell may have cancelled classes over an inch of snow, but at least we get to go sledding!",
    'mcgraw_gsh.JPG',
    'jpg'
  );

INSERT INTO
  posts (netid, date, location, desc, file_name, file_ext)
VALUES
  (
    'ez455',
    20230501,
    'Libe Slope',
    "Guys! I finally made some friends!",
    'hammocking.JPG',
    'jpg'
  );

INSERT INTO
  comments (post_id, netid, date, comment)
VALUES
  (
    1,
    'ez455',
    20230920,
    'I am so hungry too. I am going to go get food. I will be back in 5 minutes.'
  );

INSERT INTO
  comments (post_id, netid, date, comment)
VALUES
  (
    2,
    'mtd64',
    20230920,
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

INSERT INTO
  tags (post_id, tag)
VALUES
  (3, 'stuck');

INSERT INTO
  tags (post_id, tag)
VALUES
  (4, 'Feeney Way');

INSERT INTO
  tags (post_id, tag)
VALUES
  (4, 'Dragon Day');

INSERT INTO
  tags (post_id, tag)
VALUES
  (5, 'Temple of Zeus');

INSERT INTO
  tags (post_id, tag)
VALUES
  (5, 'Dragon Day');

INSERT INTO
  tags (post_id, tag)
VALUES
  (6, 'McGraw Tower');

INSERT INTO
  tags (post_id, tag)
VALUES
  (6, 'Temple of Zeus');

INSERT INTO
  tags (post_id, tag)
VALUES
  (7, 'Libe Slope');

INSERT INTO
  tags (post_id, tag)
VALUES
  (7, 'sunset');

INSERT INTO
  tags (post_id, tag)
VALUES
  (8, 'Lincoln Hall');

INSERT INTO
  tags (post_id, tag)
VALUES
  (8, 'concert');

INSERT INTO
  tags (post_id, tag)
VALUES
  (9, 'Lynah Rink');

INSERT INTO
  tags (post_id, tag)
VALUES
  (9, 'hockey');

INSERT INTO
  tags (post_id, tag)
VALUES
  (9, 'big red');

INSERT INTO
  tags (post_id, tag)
VALUES
  (10, 'Ho Plaza');

INSERT INTO
  tags (post_id, tag)
VALUES
  (10, 'cold');

INSERT INTO
  tags (post_id, tag)
VALUES
  (10, 'snow');

INSERT INTO
  tags (post_id, tag)
VALUES
  (11, 'Lindseth Climbing Center');

INSERT INTO
  tags (post_id, tag)
VALUES
  (11, 'rock climbing');

INSERT INTO
  tags (post_id, tag)
VALUES
  (11, 'rocks');

INSERT INTO
  tags (post_id, tag)
VALUES
  (12, 'Big Red Barn');

INSERT INTO
  tags (post_id, tag)
VALUES
  (12, 'chocolate');

INSERT INTO
  tags (post_id, tag)
VALUES
  (13, 'Libe Slope');

INSERT INTO
  tags (post_id, tag)
VALUES
  (13, 'sledding');

INSERT INTO
  tags (post_id, tag)
VALUES
  (14, 'Libe Slope');

INSERT INTO
  tags (post_id, tag)
VALUES
  (14, 'hammocking');

INSERT INTO
  tags (post_id, tag)
VALUES
  (14, 'friends');
