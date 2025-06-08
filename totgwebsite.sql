CREATE DATABASE IF NOT EXISTS admin_cred;

USE admin_cred;

CREATE TABLE admin_cred (
    sl_no INT AUTO_INCREMENT PRIMARY KEY,
    admin_name VARCHAR(150),
    admin_pass VARCHAR(150)
);

INSERT INTO admin_cred (admin_name, admin_pass)
VALUES ('aman', 'aman9162');
