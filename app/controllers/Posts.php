<?php
    class Posts extends Controller{

        public function __construct() {
            
            $this->postModel = $this->model('Post');;
        }
            public function index(){
                $data = [
                    'posts' => '',
                    'currentPage'=> '',
                    'total'=>'',
                    'limit'=> '',
                    'total'=>'',
                    'first_post'=> '',
                    'offset'=>'',
                    'page'=>''


                    //'comments' => $comments
                ];
                // On détermine sur quelle page on se trouve
                if(isset($_GET['page']) && !empty($_GET['page'])){
                    $data['currentPage'] = (int) strip_tags($_GET['page']);
                }else{
                    $data['currentPage'] = 1;
                }
                // //Get posts
                // $posts = $this->postModel->getPosts();

                // Find out how many items are in the table
                $data['total'] =$this->postModel->totalPosts();
                // How many items to list per page
                $data['limit'] = 5;
            
                $data['first_post'] = ($data['currentPage'] * $data['limit']) - $data['limit'];
                // How many pages will there be
                $data['pages'] = ceil($data['total'] / $data['limit']);
                
                //echo ($data['pages']);
                // What page are we currently on?
                $data['page'] = min($data['pages'], filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
            'options' => array(
                'default'   => 1,
                'min_range' => 1,
            ),
              )));
            // Calculate the offset for the query
            $data['offset'] = ($data['page'] - 1)  * ($data['limit']);
           // $comments = $this->postModel->getMessages();
          $data['posts'] = $this->postModel->getPosts($data);
            $this->view('posts/index',$data);
    }
        public function add(){
            if (!isLoggedIn()) {
                    redirect('users/login');
                }
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
                if ($_POST['form'] === "A") {
                    $upload_dir = "../public/img/uploads/";
                    $data = [
                        'user_id' => trim($_SESSION['user_id']),
                        'img' => $_POST['imgData'],
                        'sticker' => $_POST['sticker'],
                        'filter' => $_POST['filter'],
                        'path' => ""
                    ];
                    //upload image to server
                    //die ($_POST['sticker']);
                    $data['img'] = str_replace('data:image/png;base64,', '', $data['img']);
                    $data['img'] = str_replace(' ', '+', $data['img']);
                    $data['img'] = base64_decode($data['img']);
                    $data['img'] = imagecreatefromstring($data['img']);
                   // die ($data['sticker']);
                    $data['sticker'] = imagecreatefrompng(str_replace( URLROOT."/public",'.',$data['sticker']));
                    //phpinfo();
                    //die ($data['sticker']);
                    
                    switch ($data['filter']) {
                        case 'grayscale(100%)':
                            $data['filter']= IMG_FILTER_GRAYSCALE;
                            break;
                        case 'invert(100%)':
                            $data['filter']= IMG_FILTER_NEGATE;
                            break;
                        default:
                        $data['filter']= null;
                            break;
                    }
                   if (isset($data['filter'])) {
                        imagefilter($data['img'], $data['filter']);
                   }
                    imagecopymerge($data['img'],$data['sticker'],600,400,0,0,100,100,100);
                    
                    $data['path'] = $upload_dir.time().".png";
                    if (imagepng($data['img'],$data['path'])) {
                        if ($this->postModel->addPost($data)) {
                            flash('post_message','Post Added');
                            redirect('posts');
                        } else {
                            die('Something went wrong');
                        }
                        
                    }else {
                        die('Something went wrong');
                    }
                }elseif ($_POST['form'] === "B") {
                                       
                    $filename = $_FILES["file"]["name"];
                    $upload_dir = "../public/img/uploads/";
                    $filename = str_replace(" ", "" ,$filename);
                    $filepath = "../public/img/pictures/" . $filename;
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($filepath,PATHINFO_EXTENSION));
                    $data = [
                        'user_id' => trim($_SESSION['user_id']),
                        'img' => $filepath,
                        'sticker' => $_POST['sticker_uploads'],
                        'filter' => $_POST['filter_uploads'],
                        'path' => ""
                    ];
                    // Check if image file is a actual image or fake image
                    if(isset($_POST["submit"])) {

                    $check = getimagesize($_FILES["file"]["tmp_name"]);
                    if($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }
                    }

                    // Check if file already exists
                    // if (file_exists($filepath)) {
                    // echo "Sorry, file already exists.";
                    // $uploadOk = 0;
                    // }

                    // Check file size
                    if ($_FILES["file"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
                    echo "Sorry, only JPG, JPEG, PNG files are allowed.";
                    $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                    } else {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $filepath)) {
                        switch ($imageFileType) {
                            case 'jpg':
                                $data['img'] = imagecreatefromjpeg($data['img']);
                            break;
                            case 'jpeg':
                                $data['img'] = imagecreatefromjpeg($data['img']);
                                break;
                            case 'png':
                                $data['img']= imagecreatefrompng($data['img']);
                                break;
                            default:
                            $data['img'] = false;
                                break;
                        }

                        $data['sticker']= imageCreateFromPng(str_replace( URLROOT."/public",'.',$data['sticker']));
         
                        imagecopymerge($data['img'],$data['sticker'],600,400,0,0,100,100,100);
                       // imagepng($data['img']);
                        $data['path'] = $upload_dir.time().".png";
                    if (imagepng($data['img'],$data['path'])) {
                        if ($this->postModel->addPost($data)) {
                            flash('post_message','Post Added');
                            redirect('posts');
                        } else {
                            die('Something went wrong');
                        }
                        
                    }else {
                        die('Something went wrong');
                    }
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                    }
                }
            }else {
                $data = [];
    
                $this->view('posts/add',$data);
            }

        }
        public function likes(){
            
            if(isset($_POST['postId']) || isset($_POST['like']) )
            {
                $data = [
                    'user_id'=> trim($_SESSION['user_id']),
                    'postId' => $_POST['postId'],
                    'like'=> $_POST['like']
                ];
                if (!$this->postModel->findLikesByUserId($data['user_id'],$data['postId']) && $data['like'] == "1" ) {
                    $this->postModel->addLike($data);
                }
                if ($this->postModel->findLikesByUserId($data['user_id'],$data['postId']) && $data['like'] == "-1" ) {
                    $this->postModel->removeLike($data);
                }
                    
            }
            

        }
        public function comments(){
            
            if(isset($_POST['post_comment']))
            {
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
                $data = [
                    'user_id'=> trim($_SESSION['user_id']),
                    'postId' => trim($_POST['postId']),
                    'post_username' => '',
                    'message'=> trim($_POST['post_comment'])

                ];
                if (!empty($data['message'])) {
                //var_dump ($this->postModel->isnotify($data['user_id']));
                if (($this->postModel->isnotify($data['user_id'])->notification) == 1) {
                    $vEmail = [
                        'email' => $this->postModel->getEmailPostCreator($data['postId'])->email,
                        'subject' => "Comment notification",
                        'message' => "<a href='".URLROOT."/posts/'>Check posts for your comment</a>",
                        'headers' => "From:youssef.kobi \r\n"."MIME-Version: 1.0 \r\n"."Content-type:text/html;charset=UTF-8 \r\n",
                        ];
                        //die($vEmail['email']);
                       mail($vEmail['email'],$vEmail['subject'],$vEmail['message'],$vEmail['headers']);
                    
                }
                $this->postModel->addMessage($data);
                }   
            }
            

        }
        public function delete(){
            if(isset($_POST['deleteId'])){
                $data = [
                'user_id'=> trim($_SESSION['user_id']),
                'postId' => $_POST['deleteId']
            ];
            $this->postModel->delete_post($data);
            }
            
        }
    }
?>