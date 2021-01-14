CREATE TABLE site_news (
    sn_id INT NOT NULL AUTO_INCREMENT,
    sn_created_by VARCHAR(100) NOT NULL,
    sn_context TEXT NOT NULL,
    sn_created_at TIMESTAMP NOT NULL,
    sn_published_at TIMESTAMP NULL,
    PRIMARY KEY (sn_id)
);
