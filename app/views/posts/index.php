<?php require_once APPROOT . '/views/inc/header.php';?>
<?php flash('post_message');?>
    <div class="row mb-3">
        <div class="col-md-6">
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
                        <div class="">
                    <div class="d-flex justify-content-center row">
                        <div class="col-md-8">
                            <div class="d-flex flex-column comment-section">
                                <div class="bg-white">
                                    <div class="d-flex flex-row fs-12 ">
                                    <!-- user already likes post  -->
                                    <div id = "likes">
                                        <?php if ($this->postModel->findLikesByUserId($post->userId,$post->postId)): ?>
                                            <a class="btn-like" href="">kiffe</a>
                                            <?php else: ?>
                                            <a class="btn-like" href="">kiffe</a>
                                            <?php endif ?>
                                            </div>
                                        <div class="like p-2 "><?php echo ($this->postModel->getLikes($post->postId));?></i><span class="ml-1">Like</span></div>
                                        <div class="like p-2 "><span class="ml-1">Comment</span></div>
                                    </div>                               
                                </div>
                                <div class="bg-light p-2">
                                    <div class="d-flex flex-row align-items-start">
                                    <textarea class="form-control ml-1 shadow-none textarea"></textarea>
                                </div>
                                    <div class="mt-2 text-right"><button class="btn btn-primary btn-sm shadow-none" type="button">Post comment</button><button class="btn btn-outline-primary btn-sm ml-1 shadow-none" type="button">Cancel</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
 <!-- <?php// endforeach;?>  -->
    <?php endforeach;?> 
<?php require_once APPROOT . '/views/inc/footer.php';?>