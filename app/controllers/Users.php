<?php
class Users extends Controller{
    public function __construct(){
        $this->userModel = $this->model('User');
    }
    public function register(){
        //Check for Post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Process from
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'vKey'=> md5(time().trim($_POST['username'])),
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            //Username Validation
            if (empty($data['username'])) {
                $data['username_err'] = 'Please enter a Username';
            }else{
                if($this->userModel->findUserByUsername($data['username'])){
                $data['username_err'] = 'Username is already taken';
                }
            }

            //Email Validation
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter an Email';
            }else {
                if($this->userModel->findUserByemail($data['email'])){
                    $data['email_err'] = 'Email is already taken';
                }
            }
            //Password Validation
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter a Password';
            }elseif (strlen($data['password']) < 6   ) {
                $data['password_err'] = 'Password must be at least 6 characters'; 
            }

            //Password confirmation Validation
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm Password';
            }else{
                if ($data['password'] != $data['confirm_password']  ) {
                $data['confirm_password_err'] = 'Passwords do Not match'; 
            }
            }
            // check if all errors are empty
            if (empty($data['username_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Hash password
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                // register User
                if($this->userModel->register($data)){
                    $vEmail = [
                    'email' => $data['email'],
                    'subject' => "Verification email",
                    'message' => "<a href='http://localhost/camagru/users/register?vKey=$vKey'>Register Account</a>",
                    'headers' => "From: \r\n"."MIME-Version: 1.0 \r\n"."Content-type:text/html;charset=UTF-8 \r\n",
                    ];
                    mail($vEmail['email'],$vEmail['subject'],$vEmail['message'],$vEmail['headers']);
                    flash('register_success','You are registered and can log in');
                    redirect('users/login');
                }else {
                    die('Something went Wrong');
                }
            } else {
                $this->view('users/register',$data);   
            }
        }else{
            // Init data
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            //load view
            $this->view('users/register',$data);
            }
    }
    public function login(){
        //Check for Post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Process from
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            
            $data = [
                'username' => trim($_POST['username']),
                //'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
            ];
    
            //Username Validation
            if (empty($data['username'])) {
                $data['username_err'] = 'Please enter a Username';
            }
            //Password Validation
                if (empty($data['password'])) {
                    $data['password_err'] = 'Please enter a Password';
                }

            //Check for user/email
            if($this->userModel->findUserByUsername($data['username'])){
                //user found

            }else{
                $data['username_err'] = 'No User found! please Register';
            }
            // check if errors are empty
            if (empty($data['username_err']) && empty($data['password_err'])) {
                //Check and set logged in user
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);
                if($loggedInUser){
                    //Create Session
                    $this->createUserSession($loggedInUser);  
                }else {
                    $data['password_err'] = 'Password incorrect';
                $this->view('users/login',$data);
                }
            } else {
                $this->view('users/login',$data);   
            }
        }else{
            // Init data
            $data = [
                'username' => '',
                'password' => '',
                'username_err' => '',
                'password_err' => ''
            ];
            //load view
            $this->view('users/login',$data);
        }
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_username'] = $user->username;
        $_SESSION['user_email'] = $user->email;
        redirect('posts');
    }
    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_username']);
        unset($_SESSION['user_email']);
        session_destroy();
        redirect('users/login');
    }
    public function profile(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Process from
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            //Username Validation
            if (empty($data['username'])) {
                $data['username'] = $_SESSION['user_username'];
            }else{
                if($this->userModel->findUserByUsername($data['username'])){
                $data['username_err'] = 'Username is already taken';
                }
            }

            //Email Validation
            if (empty($data['email'])) {
                $data['email'] = $_SESSION['user_email'];
            }else {
                if($this->userModel->findUserByemail($data['email'])){
                    $data['email_err'] = 'Email is already taken';
                }
            }
            //Password Validation
            if (empty($data['password'])) {
                $data['password'] = '';//to be edited
            }elseif (strlen($data['password']) < 6   ) {
                $data['password_err'] = 'Password must be at least 6 characters'; 
            }

            //Password confirmation Validation
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = '';//to be edited
            }else{
                if ($data['password'] != $data['confirm_password']  ) {
                $data['confirm_password_err'] = 'Passwords do Not match'; 
            }
            }
            // check if all errors are empty
            if (empty($data['username_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Hash password
                
                
                // edit User
                if($this->userModel->editProfile($data)){

                    $loggedInUser = $this->userModel->login($data['username'], $data['password']);
                    if($loggedInUser){
                        
                        //Fash('register_success','You are registered and can log in');
                        //Create Session
                        $this->createUserSession($loggedInUser);
                        
                    }else {
                        die('failed loggedin');
                    }
                }else {
                    die('Something went Wrong');
                }
            } else {
                
                $this->view('users/profile',$data);   
            }
        }else{
            // Init data
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            //load view
            $this->view('users/profile',$data);
            }
    }

}

?>