<?php
class Users extends Controller{
    public function __construct(){
        $this->userModel = $this->model('User');
    }
    public function register(){
        if (isLoggedIn()) {
            redirect('posts/index');
        }
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
                if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                    $data['email_err'] = 'Input is not an email';
                }
            }
            //Password Validation
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter a Password';
            }elseif (strlen($data['password']) < 6  || (strtolower($data['password']) == $data['password']) ) {
                $data['password_err'] = 'Password must be at least 6 characters and have at least an upper case'; 
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
                    'message' => "<a href='".URLROOT."/users/login?vKey=".$data['vKey']."&"."username=".$data['username']."'>Register Account</a>",
                    'headers' => "From:youssef.kobi \r\n"."MIME-Version: 1.0 \r\n"."Content-type:text/html;charset=UTF-8 \r\n",
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
        if (isLoggedIn()) {
            redirect('posts/index');
        }
        if( isset($_GET['vKey'])){
           // $vKey = $_GET['vKey'];
            if (isset($_GET['vKey']) && isset($_GET['username'])) {
                //Verify user
                //die($_GET['username']);
                if (!$this->userModel->verifyUser($_GET['username'],$_GET['vKey'])) {
                    //$data['username_err'] = 'vKey not set !  please check your email';
                    echo "vkey not ";
                }
            }
            //echo $vKey;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
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

                if (!$this->userModel->isVerfied($data['username'])) {
                    $data['username_err'] = 'Account not Verified!  please check your email';
                }                
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
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Process from
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']), 
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'current_password' => trim($_POST['current_password']),
                'current_password_err' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'notification'=> ''
            ];
            $data['notification'] = isset($_POST['notification']) ? 1 : 0 ;
            //die($data['notification']);
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
                if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                    $data['email_err'] = 'Input is not an email';
                }
            }
            //Password Validation
            if (empty($data['password'])) {
                $data['password'] = '';
            }elseif (strlen($data['password']) < 6   ) {
                $data['password_err'] = 'Password must be at least 6 characters'; 
            }

            //Password confirmation Validation
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 0 ;//to be edited
            }else{
                if ($data['password'] != $data['confirm_password']  ) {
                $data['confirm_password_err'] = 'Passwords do Not match'; 
            }
            }
            if (empty($data['current_password'])) {
                $data['current_password_err'] = "Please Enter your current Password" ;//to be edited
            }else{
                //$data['current_password' ]= password_hash($data['current_password'],PASSWORD_DEFAULT);
                if (!$this->userModel->login($_SESSION['user_username'],$data['current_password']) ) {
                    $data['current_password_err'] = 'Password do Not match'; 
            }
            }
            // check if all errors are empty
            if (empty($data['username_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])&& empty($data['current_password_err'])) {
                // edit User
                if($this->userModel->editProfile($data)){
                    if (empty($data['password'])) {
                        $data['password'] = $data['current_password'];
                        $loggedInUser = $this->userModel->login($data['username'], $data['current_password']);
                        if($loggedInUser){
                        
                            //Fash('register_success','You are registered and can log in');
                            //Create Session
                            $this->createUserSession($loggedInUser);
                            
                        }else {
                            die('failed loggedin');
                        }
                    }else {
                        $loggedInUser = $this->userModel->login($data['username'], $data['password']);
                        if($loggedInUser){
                        
                            //Fash('register_success','You are registered and can log in');
                            //Create Session
                            $this->createUserSession($loggedInUser);
                            
                        }else {
                            die('failed loggedin');
                        }
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
                'current_password'=>'',
                'current_password_err'=>'',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            //load view
            $this->view('users/profile',$data);
            }
    }
    public function pwd(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Process from
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
               // 'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'email_err'=>'',
                'new_pwd'=> md5(time().trim($_POST['email']))
                   ];
            //Email Validation
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter an email';
            }else {
                if(!$this->userModel->findUserByemail($data['email'])){
                    $data['email_err'] = 'Please enter a registred email';
            }
             // check if all errors are empty
            if (empty($data['email_err'])){
                //Generation a Random password
                if ($this->userModel->editpwd($data)) {
                    // Send email
                    $vEmail = [
                        'email' => $data['email'],
                        'subject' => "Password Reset",
                        'message' => "<a href='http://localhost/users/login'>Your new Password is =".$data['new_pwd']."</a>",
                        'headers' => "From:youssef.kobi \r\n"."MIME-Version: 1.0 \r\n"."Content-type:text/html;charset=UTF-8 \r\n",
                        ];
                        mail($vEmail['email'],$vEmail['subject'],$vEmail['message'],$vEmail['headers']);
                        flash('register_success','Your New Password has been sent to your email');
                        redirect('users/login');
                }else {
                    die('Something Went Wrong');
                }
            }else {
                $this->view('users/pwd',$data); 
            }         
        }
        $this->view('users/pwd',$data); 
        }else{
            // Init data
            $data = [
                'email' => '',
                'new_pwd' => '',
            ];
            //load view
             $this->view('users/pwd',$data);
             }
    }
}
?>