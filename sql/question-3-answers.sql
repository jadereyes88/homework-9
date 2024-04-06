-- select by id 1:
SELECT * FROM post WHERE id = 1;


-- select all posts where title = includes "title 2":
SELECT * FROM post WHERE title LIKE '%title 2%';

-- select all posts and order by the title column alphabetically:
SELECT * FROM post ORDER BY title ASC;

-- insert 3 new posts
INSERT INTO post (title, content) VALUES 
('Post Title 1', 'Content of post 1'),
('Post Title 2', 'Content of post 2'),
('Post Title 3', 'Content of post 3');

-- update posts where id = 1, set the title to "new title"
UPDATE post SET title = 'Updated Post' WHERE id = 1;

-- delete post where id = 2
DELETE FROM post WHERE id = 2;
