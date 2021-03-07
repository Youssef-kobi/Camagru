<?php

class setup{
    private $db;

    public function __construct()
    {              
        $this->db = new Database;
        $this->createtables();
    }

    public function createtables()
    {     
        $this->createUsers();
        $this->createPosts();
        $this->createComments();
        $this->createLikes();
    }

    public function createUsers()
    {
        $this->db->query('CREATE TABLE IF NOT EXISTS `camagru`.`users` (
            `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
            `username` varchar(255) DEFAULT NULL,
            `email` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `vKey` varchar(255) NOT NULL,
            `verified` tinyint(1) NOT NULL DEFAULT 0,
            `notification` tinyint(4) NOT NULL DEFAULT 1,
            `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;');
        $this->db->execute();
    }

    public function createPosts()
    {
        $this->db->query('CREATE TABLE  IF NOT EXISTS `camagru`.`posts` (
                            `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
                            `user_id` int(11) NOT NULL,
                            `path` varchar(255) NOT NULL,
                            `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;');
        $this->db->execute();
    }


    public function createLikes()
    {
        $this->db->query('CREATE TABLE  IF NOT EXISTS `camagru`.`likes` (
            `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
            `user_id` int(11) NOT NULL,
            `post_id` int(11) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
        $this->db->execute();

    }

    public function createComments()
    {
        $this->db->query('CREATE TABLE IF NOT EXISTS `camagru`.`comments` (
            `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `comment` varchar(255) NOT NULL,
            `post_id` int(11) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
        $this->db->execute();
    }
}

?>