<?php require_once APPROOT . '/views/inc/header.php';?>
<a href="<?php echo URLROOT;?>/posts" class="btn btn-primary">Back</a>
<div class="full">
    <ul id="menuTabs" class="nav nav-pills flex-column flex-sm-row justify-content-center">
        <li class="active btn btn-success" ><a class="flex-sm-fill text-sm-center nav-link nav-pills" id="tab_1" href="#tab_1">Menu 1</a></li>
        <li><a class="flex-sm-fill text-sm-center nav-link nav-pills" id="tab_2" href="#tab_2">Menu 2</a></li>
    </ul>
    <div class="tab-content">
        <div id= "tab_1" class="card card-body bg-light tab-pane active">
            <h2>ADD POST</h2>
            <p>Create a post with this form</p>
            <div class="row">
                <div class="main card col-8" >
                    <div style="position:relative" >
                        <video class="" id="video" >Stream Not Available</video>
                        <img src=""style="position:absolute;bottom:50px ;right:50px; width:15%" id ="videos_sticker" >
                    </div>
                        <div  class="buttons">
                            <form action="<?php echo URLROOT;?>/posts/add" method="post">
                                <input type="hidden" name="form" value="A">
                                <input type="hidden" name="imgData" id ="imageData" value = "">
                                <input type="hidden" name="sticker" id ="sticker" value = "">
                                <input type="hidden" name="filter" id ="filter" value = "">
                                <input type="submit" value ="SUBMIT" id="submit" class="btn btn-success btn-block">
                            </form>
                            <button id= "photo-button" class="btn btn-primary btn-block "> Take picture </button>
                            <select id="photo-filter" class="btn btn-success btn-block  " >
                                <option value="none">Normal</option>
                                <option value="grayscale(100%)">Grayscale</option>
                                <option value="invert(100%)">Invert</option>
                            </select>
                            <button id="clear-button" class="btn btn-danger btn-block ">Clear</button>
                        </div>
                        <canvas id="canvas" class="d-none"></canvas>
                        <br>
                        <div id= "stickers" class="card-body bg-dark row sticker_css m-auto">
                            <input type="radio" name="sticker_radio" id="sticker_0" />
                            <label for="sticker_0" class="col-2 m-auto"><img id="sticker_0" src="<?php echo URLROOT;?>/public/img/stickers/boss.png" /></label>
                            <input type="radio"  name="sticker_radio" id="sticker_1" />
                            <label for="sticker_1" class="col-2 m-auto"><img id="sticker_1" src="<?php echo URLROOT;?>/public/img/stickers/inkonnu.png" /></label>
                            <input type="radio"  name="sticker_radio" id="sticker_2" />
                            <label for="sticker_2" class="col-2 m-auto"><img id="sticker_2" src="<?php echo URLROOT;?>/public/img/stickers/GoOutside.png" /></label>
                            <input type="radio"  name="sticker_radio" id="sticker_3" />
                            <label for="sticker_3" class="col-2 m-auto"><img id="sticker_3" src="<?php echo URLROOT;?>/public/img/stickers/rick&morty.png" /></label>
                        </div>  
                    </div>
                    <div id="sidebar" class="img-fluid card-body bg-dark col-4">
                            <div id="photos" class="watermark"></div>
                    </div>
                </div>

            </div>
         <div id= "tab_2" class="card card-body bg-light tab-pane ">
            <h2>Upload image</h2>
            <p>And choose your sticker</p>
            <div class="row">
                <div class="main card col-8">
                    <div style="position : relative;width: 100vh; margin-left: auto; margin-right: auto; display: block;" >
                        <img id ="upload_preview" src="" alt="">
                        <img id ="sticker_preview" src="" alt="">
                    </div>
                    <div class="buttons">
                        <select id="uploads-filter" class="btn btn-success btn-block  " >
                            <option value="none">Normal</option>
                            <option value="grayscale(100%)">Grayscale</option>
                            <option value="invert(100%)">Invert</option>
                        </select>
                    </div>
                    <canvas id="canvas" class="d-none"></canvas>
                    <br>
                    <div id= "stickers_uploads" class="card-body bg-dark row sticker_css m-auto">
                        <input type="radio" name="sticker_radio_uploads" id="sticker_uploads_0" />
                        <label for="sticker_uploads_0"><img id="sticker_uploads_0" src="<?php echo URLROOT;?>/public/img/stickers/boss.png" /></label>
                        <input type="radio" name="sticker_radio_uploads" id="sticker_uploads_1" />
                        <label for="sticker_uploads_1"><img id="sticker_uploads_1" src="<?php echo URLROOT;?>/public/img/stickers/inkonnu.png" /></label>
                        <input type="radio" name="sticker_radio_uploads" id="sticker_uploads_2" />
                        <label for="sticker_uploads_2"><img id="sticker_uploads_2" src="<?php echo URLROOT;?>/public/img/stickers/GoOutside.png" /></label>
                        <input type="radio" name="sticker_radio_uploads" id="sticker_uploads_3" />
                        <label for="sticker_uploads_3"><img id="sticker_uploads_3" src="<?php echo URLROOT;?>/public/img/stickers/rick&morty.png" /></label>
                            
                    </div>
                </div>
                <div id="sidebar" class="img-fluid card-body bg-dark col-4">
                <form action="<?php echo URLROOT;?>/posts/add" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="form" value="B">
                    <!-- <input type="hidden" name="imgData" id ="imageData" value = ""> -->
                    <input type="hidden" name="sticker_uploads" id ="sticker_uploads" value = "">
                    <input type="hidden" name="filter_uploads" id ="filter_uploads" value = "">
                    <label class="form-label" for="customFile">Default file input example</label>
                    <input type="file" name="file" class="form-control " id="customFile" />
                    <input type="submit" value="Upload Image" name="submit_uploads">
                </form>
                </div>
            </div>
        </div> 
    </div>
</div>


<script src = "<?php echo URLROOT;?>/js/cam.js"></script>
<?php require_once APPROOT . '/views/inc/footer.php';?>