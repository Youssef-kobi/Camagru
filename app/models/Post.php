<?php
    class post{
        private $db;

        public function __construct() {
          $this->db = new Database;
          new setup;
    }

    public function getPosts($data){
        $this->db->query('SELECT *,
                        posts.id as postId,
                        users.id as userId,
                        posts.created_at as postCreated,
                        users.created_at as userCreated
                        FROM posts
                        INNER JOIN users
                        ON posts.user_id = users.id
                        ORDER BY posts.created_at DESC
                        LIMIT :first_post , :limit
                        ');
            $this->db->bind(':first_post', $data['first_post']);
            $this->db->bind(':limit',$data['limit']);
        $results = $this->db->resultSet();
        return $results;
    }
    public function totalPosts(){
        $this->db->query('SELECT *
                        FROM posts
                        ');

        $results = $this->db->resultSet();
        return $this->db->rowCount();
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
    public function delete_post($data)
    {
        $this->db->query('DELETE FROM posts WHERE id =:post_id');
            //Binding Values

            $this->db->bind(':post_id',$data['postId']);
            //execute
            if($this->db->execute()){
                return true;
            }else {
                return false;
            }   
    }
            // find user by Username
    public function findLikesByUserId($user_id,$post_id){

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
    public function getEmailPostCreator($post_id){

        $this->db->query('SELECT email
                        FROM posts
                        INNER JOIN users
                        ON posts.user_id = users.id
                        WHERE posts.id = :post_id');
        $this->db->bind(':post_id',$post_id);
        
        $row = $this->db->single();
        // check row 
        return $row;
    }

    public function isnotify($user_id){
        $this->db->query('SELECT *
        FROM users
        WHERE id = :user_id');
        $this->db->bind(':user_id',$user_id);

        $row = $this->db->single(); 
        return $row;

    }
    public function getLikes($post_id)
    {
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
    public function addLike($data)
    {
        $this->db->query('INSERT INTO likes (user_id,post_id) VALUES(:user_id,:post_id)');
            //Binding Values
            $this->db->bind(':user_id',$data['user_id']);
            $this->db->bind(':post_id',$data['postId']);
            //execute
            if($this->db->execute()){
                return true;
            }else {
                return false;
            }
            
    }
    public function removeLike($data)
    {
        $this->db->query('DELETE FROM likes  WHERE user_id =:user_id AND post_id =:post_id');
            //Binding Values
            $this->db->bind(':user_id',$data['user_id']);
            $this->db->bind(':post_id',$data['postId']);
            //execute
            if($this->db->execute()){
                return true;
            }else {
                return false;
            }
            
    }
    public function addMessage($data)
    {
        $this->db->query('INSERT INTO comments (user_id,post_id,comment) VALUES(:user_id,:post_id,:comment)');
            //Binding Values
            $this->db->bind(':user_id',$data['user_id']);
            $this->db->bind(':post_id',$data['postId']);
            $this->db->bind(':comment',$data['message']);
            //execute
            if($this->db->execute()){
                return true;
            }else {
                return false;
            }
            
    }
    public function getMessages($post_id){
        $this->db->query('SELECT *,
        posts.id as postId,
        users.id as userId,
        comments.created_at as created_at
        FROM comments
        INNER JOIN posts
        ON comments.post_id = posts.id
        INNER JOIN users
        ON comments.user_id = users.id
        WHERE posts.id = :post_id
        ORDER BY comments.created_at DESC');
        $this->db->bind(':post_id',$post_id);
        $results = $this->db->resultSet();
        return $results;
    }
}
    
?>