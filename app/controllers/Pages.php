<?php
class Pages extends Controller{
    public function __construct(){
    }
    public function index(){
            redirect('posts');

    }
    public function about(){
        $data = [
            'title' => 'About Us'
        ];
        $this->view('pages/about',$data);
    }
}

?>