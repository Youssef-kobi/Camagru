<?php
    class post{
        private $db;

        public function __construct() {
          $this->db = new Database;
    }

    public function getPosts(){
        $this->db->query('SELECT *,
                        posts.id as postId,
                        users.id as userId,
                        posts.created_at as postCreated,
                        users.created_at as userCreated
                        FROM posts
                        INNER JOIN users
                        ON posts.user_id = users.id
                        ORDER BY posts.created_at DESC

                        ');

        $results = $this->db->resultSet();
        return $results;
        //print_r($results);
    }
    public function addPost($data)
    {
        $this->db->query('INSERT INTO posts (user_id,path) VALUES(:user_id,:path)');
            //Binding Values

            $this->db->bind(':user_id',$data['user_id']);
            $this->db->bind(':path',$data['path']);
            //execute
            if($this->db->execute()){
                return true;
            }else {
                return false;
            }
            
    }
            // find user by Username
    public function findLikesByUserId($user_id,$post_id){
        echo 
        $this->db->query('SELECT *
                        FROM likes
                        WHERE user_id = :user_id AND
                        post_id = :post_id');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':post_id',$post_id);
        
    $row = $this->db->single();
    // check row 
    if ($this->db->rowCount() == 1){
        return true;
    }else {
        
        return false;   
    }
    }
    public function getLikes($post_id){
        $this->db->query('SELECT *,
        posts.id as postId,
        likes.id as likeId,
        users.id as userId
        FROM likes
        INNER JOIN posts
        ON likes.post_id = posts.id
        INNER JOIN users
        ON likes.user_id = users.id
       WHERE posts.id = :post_likes
                        ');
    $this->db->bind(':post_likes',$post_id);
        $row = $this->db->single();
        //$results = $this->db->resultSet();
        return $this->db->rowCount();
    }
}
    
?>