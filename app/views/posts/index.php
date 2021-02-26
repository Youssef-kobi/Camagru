<?php require_once APPROOT . '/views/inc/header.php';?>
<?php flash('post_message');?>
    <div class="row mb-3">
        <div class="col-md-6">
        <div class="d-none" id ='user_name'><?php echo $_SESSION['user_username'];?></div>
          <h1>Posts</h1>
        </div>
        <div class="col-md-6">
            <a href="<?php echo URLROOT;?>/posts/add" class="btn btn-primary float-right">Add Posts</a>
        </div>
    </div>
    <?php foreach ($data['posts'] as $post) : ?>
        <!-- <?php //foreach ($data['likes'] as $like) : ?> -->
    <div class="card card-body text-center mb-3">
        <div class="bg-light p-2 mb-3">
            By <b><?php echo $post->username;?></b> On <?php echo $post->postCreated;?> 
        </div>
        <p class="card-img-top"><?php echo ("<img src=" . str_replace("..",URLROOT,$post->path) ." >"); ?></p>
        <div class="d-flex flex-column comment-section">
            <div class="bg-white">
                <div class="d-flex flex-row fs-12 ">
                <!-- user already likes post  -->
                <div id = "likes">
                    <?php if ($this->postModel->findLikesByUserId($post->userId,$post->postId)): ?>
                        <button class="like-button" value="<?php echo $post->postId?>">UnLike</button>
                        <?php else: ?>
                        <button class="like-button"value="<?php echo $post->postId?>">Like</button>
                        <?php endif ?>
                        </div>
                    <div class="like p-2 " id="<?php echo $post->postId?>"><?php echo ($this->postModel->getLikes($post->postId));?></div>
                    <div class="like p-2 "><span class="ml-1">Comment</span></div>
                </div>                               
            </div>
                                <div class="bg-light p-2">
                                    <div class="d-flex flex-row align-items-start">
                                    <textarea class="form-control ml-1 shadow-none textarea required" id="message" placeholder="write your comment here"></textarea>
                                </div>
                                    <div class="mt-2 text-right">
                                        <button class="btn btn-primary btn-sm shadow-none" id="post_comment" type="button" value="<?php echo $post->postId?>">Post comment</button>
                                    </div>
                                    <div id="commentBox">
                                    <?php foreach ($this->postModel->getMessages($post->postId) as $comment) : ?>
                                        
                                            
                                            <h5 class="h5 text-left"><?php echo $comment->username;?></h5>
                                            <h6 class="h6 text-left" ><?php echo $comment->created_at;?> </h6>  
                                            <div class=" card card-body text-left mb-1"><span><?php  echo $comment->comment?></span></div>
                                    
                                            
                                    <?php endforeach;?> 
                                    </div>
                                </div>
                            </div>

    </div>
    <?php endforeach;?> 
<?php require_once APPROOT . '/views/inc/footer.php';?>