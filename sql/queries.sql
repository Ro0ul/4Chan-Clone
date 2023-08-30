CREATE TABLE post( 
    id INT AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    image_src VARCHAR(255),
    posted_at DATETIME NOT NULL,
    board VARCHAR(50) NOT NULL,
    PRIMARY KEY(id)
)
/*Comments*/
CREATE TABLE comment(
    id INT AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    post_id INT NOT NULL,
    posted_at DATETIME NOT NULL,
    image_src VARCHAR(255),
    board VARCHAR(50) NOT NULL,
    FOREIGN KEY(post_id)
        REFERENCES post(id)
        ON DELETE CASCADE
)