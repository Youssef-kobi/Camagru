<?php require_once APPROOT . '/views/inc/header.php';?>
<?php flash('post_message');?>
    <div class="row mb-3">
        <div class="col-md-6">
        <div class="d-none" id ='user_name'><?php echo $_SESSION['user_username'];?></div>
          <h1>Posts</h1>
        </div>
        <?php if (isLoggedIn()): ?>
        <div class="col-md-6">
            <a href="<?php echo URLROOT;?>/posts/add" class="btn btn-primary float-right">Add Posts</a>
        </div>
        <?php endif ?>
    </div>
    <?php foreach ($data['posts'] as $post) : ?>
        <!-- <?php //foreach ($data['likes'] as $like) : ?> -->
    <div class="card card-body text-center mb-3" id="Full_Post=<?php echo $post->postId?>">
        <div class="bg-light p-2 mb-3">
            By <b><?php echo $post->username;?></b> On <?php echo $post->postCreated;?> 
            <?php if ($post->username == (isset($_SESSION['user_username']) ? $_SESSION['user_username'] : NULL)): ?>
                <button class="button btn-danger deletePost" value="<?php echo $post->postId?>">delete</button>
            <?php endif ?>
        </div>
        <?php echo ("<img class="."card"." src=" . str_replace("..",URLROOT,$post->path) ." >"); ?>
        <div class="d-flex flex-column comment-section">
            <div class="bg-white">
                <div class="d-flex flex-row fs-12 ">
                <!-- user already likes post  -->
                <div id = "likes">
                <?php if (isLoggedIn()): ?>
                    <?php if (  $this->postModel->findLikesByUserId($_SESSION['user_id'],$post->postId)): ?>
                        <button class="like-button" value="<?php echo $post->postId?>">Dislike</button>
                        <?php else: ?>
                        <button class="like-button"value="<?php echo $post->postId?>">Like</button>
                        <?php endif ?>
                        <?php endif ?>
                        </div>
                        <p class="mb-0 text-center">Liked :</p>
                    <div class="like p-2 " id="<?php echo $post->postId?>"><?php echo($this->postModel->getLikes($post->postId));?></div>
                </div>                               
            </div>
            <?php if (isLoggedIn()): ?>
                                <div class="bg-light p-2">
                                    <div class="d-flex flex-row align-items-start">
                                    <textarea class="form-control ml-1 shadow-none textarea required" id="message=<?php echo $post->postId?>" placeholder="write your comment here"></textarea>
                                </div>
                                    <div class="mt-2 text-right">
                                        <button class="btn btn-primary btn-sm shadow-none post_comment" type="button" value="<?php echo $post->postId?>">Post comment</button>
                                    </div>
                    <?php endif ?>
                                    <div id="commentBox=<?php echo $post->postId?>">
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
    <nav class="">
    <ul class="pagination">
        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
        <li class="page-item <?php echo ($data['currentPage'] == 1) ? "disabled" : "" ?>">
            <a href=".<?php echo URLROOT;?>/posts/?page=<?= $data['currentPage'] - 1 ?>" class="page-link">Précédente</a>
        </li>
        <?php for($page = 1; $page <= $data['pages']; $page++): ?>
            <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
            <li class="page-item <?php echo ($data['currentPage'] == $page) ? "active" : "" ?>">
                <a href="<?php echo URLROOT;?>/posts/?page=<?php echo $page ?>" class="page-link"><?= $page ?></a>
            </li>
        <?php endfor ?>
            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
            <li class="page-item <?php ($data['currentPage'] == $data['pages']) ? "disabled" : "" ?>">
            <a href="<?php echo URLROOT;?>/posts/?page=<?php echo ($data['currentPage'] + 1) ?>" class="page-link">Suivante</a>
        </li>
    </ul>
</nav>
<?php require_once APPROOT . '/views/inc/footer.php';?>