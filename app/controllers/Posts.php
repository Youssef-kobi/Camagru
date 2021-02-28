<?php
    class Posts extends Controller{

        public function __construct() {
            
            if (!isLoggedIn()) {
                redirect('users/login');
            }
            $this->postModel = $this->model('post');;
        }
        public function index(){
            //Get posts
            $posts = $this->postModel->getPosts();
           // $comments = $this->postModel->getMessages();
            $data = [
                'posts' => $posts
                //'comments' => $comments
            ];
            $this->view('posts/index',$data);
        }
        public function add(){
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
                    
                    $data['img'] = str_replace('data:image/png;base64,', '', $data['img']);
                    $data['img'] = str_replace(' ', '+', $data['img']);
                    // Sanitaze POST ARRAY
                    //$_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
                    // echo $data['img'];
                    $data['img'] = base64_decode($data['img']);
                    $data['img'] = imagecreatefromstring($data['img']);
                    //echo $data['sticker'];
                    $data['sticker'] = imageCreateFromPng($data['sticker']);
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
                        $data['img'] = imageCreateFromPng($data['img']);
                        $data['sticker']= imageCreateFromPng($data['sticker']);
                       // $data['sticker'] = imageCreateFromPng($data['sticker']);
                        //str_replace("..", URLROOT ,$data['img']);
                        //echo $data['img'];
                        imagecopymerge($data['img'],$data['sticker'],300,200,0,0,100,100,100);
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
                        //echo "<img src=".$data['img']." height=200 width=300 />";
                       // $this->view('posts/add',$data);
                        // echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
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
            if(isset($_POST['post_comment'])  )
            {
                echo $_POST['post_comment'];
                $data = [
                    'user_id'=> trim($_SESSION['user_id']),
                    'postId' => trim($_POST['postId']),
                    'message'=> trim($_POST['post_comment'])
                ];
                // if (!$this->postModel->findLikesByUserId($data['user_id'],$data['postId']) && $data['like'] == "1" ) {
                     $this->postModel->addMessage($data);
                     
                // }
                // if ($this->postModel->findLikesByUserId($data['user_id'],$data['postId']) && $data['like'] == "-1" ) {
                //     $this->postModel->removeLike($data);
                // }
                    
            }
            

        }
    }
?>