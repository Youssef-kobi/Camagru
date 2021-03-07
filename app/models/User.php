<?php
    class User {

        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function register($data){
            $this->db->query('INSERT INTO users (username, email, password,vKey) VALUES(:username,:email,:password,:vKey)');
            //Binding Values
            $this->db->bind(':username',$data['username']);
            $this->db->bind(':email',$data['email']);
            $this->db->bind(':password',$data['password']);
            $this->db->bind(':vKey',$data['vKey']);
            //execute
            if($this->db->execute()){
                return true;
            }else {
                return false;
            }
            
        }

        public function login($username,$password){
            $this->db->query('SELECT * FROM users WHERE username = :username');
            $this->db->bind(':username',$username);
            $row = $this->db->single();
            $hashed_password = $row->password;
            if (password_verify($password,$hashed_password)) {
                return $row;
            }else {
                return false;
            }
        }
        // find user by Username
        public function findUserByUsername($username){
            
            $this->db->query('SELECT * FROM users WHERE username = :username');
            $this->db->bind(':username',$username);
            
        $row = $this->db->single();
        // check row 
        if ($this->db->rowCount() > 0){
            return true;
        }else {
            
            return false;   
        }
        } 
        public function verifyUser($username, $vKey){
            
            $this->db->query('UPDATE users SET verified = 1 WHERE username = :username AND vKey = :vKey');
            $this->db->bind(':username',$username);
            $this->db->bind(':vKey',$vKey);
        // check row 
        if ($this->db->execute()){
            return true;
        }else {
            return false;   
        }
        }
        public function isVerfied($username){
            
            $this->db->query('SELECT *
            FROM users
            WHERE username = :username AND
                  verified = "1"
                ');
            $this->db->bind(':username',$username);
            // $this->db->bind(':vKey',$vKey);

            $row = $this->db->single();
            // check row 
        if ($this->db->rowCount() == 1){
            return true;
        }else {
            return false;   
        }
}
        public function findUserByemail($email){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);

        $row = $this->db->single();
        // check row 
        if ($this->db->rowCount() > 0){
            return true;
        }else {
            return false;   
        }
        } 
        public function editProfile($data){
            if (isset($data['username']) || isset($data['email']) || $data['password'] == 0 || isset($data['notification']) ) {

                if (isset($data['username']) ) {
                    $this->db->query('UPDATE users SET username=:username WHERE id = :user_id');                 
                    //Binding Values
                    $this->db->bind(':user_id',$_SESSION['user_id']);
                    $this->db->bind(':username',$data['username']);
                    //execute
                    if(!$this->db->execute()){
                        return false;
                    }
                }
                if (isset($data['email']) ) {
                    $this->db->query('UPDATE users SET email=:email WHERE id = :user_id');                 
                    //Binding Values
                    $this->db->bind(':user_id',$_SESSION['user_id']);
                    $this->db->bind(':email',$data['email']);
                    //execute
                    if(!$this->db->execute()){
                        return false;
                    }
                }
                if (!empty($data['password']) ) {

                    $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                
                    $this->db->query('UPDATE users SET password=:password WHERE id=:user_id');                 
                    //Binding Values
                    $this->db->bind(':user_id',$_SESSION['user_id']);
                    $this->db->bind(':password',$data['password']);
                    //execute
                    if(!$this->db->execute()){
                        return false;
                    }
                }
                if (isset($data['notification']) ) {
                
                    $this->db->query('UPDATE users SET notification =:notification WHERE id=:user_id');                 
                    //Binding Values
                    $this->db->bind(':user_id',$_SESSION['user_id']);
                    $this->db->bind(':notification',$data['notification']);
                    //execute
                    if(!$this->db->execute()){
                        return false;
                    }
                }
                return true;
        }

}

        public function isNotify($username){
            
            $this->db->query('SELECT *
            FROM users
            WHERE username = :username AND
                  notification = "1"
                ');
            $this->db->bind(':username',$username);
            // $this->db->bind(':vKey',$vKey);

            $row = $this->db->single();
            // check row 
        if ($this->db->rowCount() == 1){
            return true;
        }else {
            return false;   
        }
}
public function editpwd($data){

        $data['new_pwd'] = password_hash($data['new_pwd'],PASSWORD_DEFAULT);
    
        $this->db->query('UPDATE users SET password=:password WHERE email =:email');                 
        //Binding Values
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':password',$data['new_pwd']);
        //execute
        if($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }
}
?>
    

