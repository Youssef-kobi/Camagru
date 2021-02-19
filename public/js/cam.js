// Global vars
let width = 720,
    height = 0,
    filter = 'none',
    streaming = false;
    var id = 0;

//DOM Elements
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photos = document.getElementById('photos');
const photoButton = document.getElementById('photo-button');
const clearButton = document.getElementById('clear-button');
const photoFilter = document.getElementById('photo-filter');
const uploadsFilter = document.getElementById('uploads-filter');
const stickers = document.getElementById('stickers');
const videosSticker = document.getElementById('videos_sticker');
const shareThisPicture = document.getElementById('submit');
const uploads = document.getElementsByName('file');
const stickers_uploads = document.getElementById('stickers_uploads');
const img = document.getElementById('upload_preview');
const sticker_preview = document.getElementById('sticker_preview');
//const uploadButton = document.getElementByName('submit_uploads');
// checkedImg_id = document.querySelector('input[name="radio_name"]:checked').id;
// checkedImg_src = document.querySelector(`img[id='${checkedImg_id}']`).src;
// Get media stream 
navigator.mediaDevices.getUserMedia({video: true, audio: false})
    .then(function (stream) {
        // link to the video source
        video.srcObject = stream;
        //Play video
        video.play();

        
    })
    .catch(function(err){
        console.log(`Error: ${err}`);
    });
    // Play when ready
    video.addEventListener('canplay', function (e){
        if (!streaming) {
            // Set video //canvas height
            height= video.videoHeight / (video.videoWidth / width);

            video.setAttribute('width',width);
            video.setAttribute('height',height);
            canvas.setAttribute('width',width);
            canvas.setAttribute('height',height);
            streaming = true;
            photoButton.disabled = true;
            shareThisPicture.disabled = true;
        }

    },false)
    // photo button event
    photoButton.addEventListener('click', function (e) {
        takePicture();
        e.preventDefault();
    },)
    shareThisPicture.addEventListener('click', function (e) {

        savePicture();

        //e.preventDefault();
    },)
    // Filter event
    photoFilter.addEventListener('change',function(e){
        // Set filter to chosen option
        filter = e.target.value;
        // set filter to video
        video.style.filter = filter;
        img.style.filter = filter; 
        e.preventDefault();
    });
    uploadsFilter.addEventListener('change',function(e){
        // Set filter to chosen option
        filter = e.target.value;
        // set filter to video
        img.style.filter = filter; 
        e.preventDefault();
    });
    stickers_uploads.addEventListener('change',function(e){
        
        uploadSticker_id = document.querySelector('input[name="sticker_radio_uploads"]:checked').id;
        uploadSticker_src = document.querySelector(`img[id='${uploadSticker_id}']`).src;

     // Set filter to chosen option
        // if (checkedSticker_src) {
        //     uploadButton.disabled = false;
        // }
        sticker_preview.src = uploadSticker_src;
        sticker_preview.style.position = "absolute";
        sticker_preview.style.bottom = "3vh";
        sticker_preview.style.right = "3vh";
        sticker_preview.style.width = "5vh";
        e.preventDefault();
        document.getElementById('sticker_uploads').value = uploadSticker_src;
        document.getElementById('filter_uploads').value = filter;
    })
    window.addEventListener('load', function() {
        //uploadButton.disabled = true;
        document.querySelector('input[type="file"]').addEventListener('change', function() {
            if (this.files && this.files[0]) {    
                img.onload = () => {
                    URL.revokeObjectURL(img.src);  // no longer needed, free memory
                }
                img.style.width = "100vh";
                img.style.marginLeft= "auto";
                img.style.marginRight= "auto";
                img.style.display= "block";

                img.src = URL.createObjectURL(this.files[0]); // set src to blob url


            }
        });
      });
    // Sticker event
    stickers.addEventListener('change',function(e){
        checkedSticker_id = document.querySelector('input[name="sticker_radio"]:checked').id;
        checkedSticker_src = document.querySelector(`img[id='${checkedSticker_id}']`).src;
     // Set filter to chosen option
        if (checkedSticker_src) {
            photoButton.disabled = false;
        }
        videosSticker.style.position = "absolute";
        videosSticker.setAttribute('src',checkedSticker_src);
        videosSticker.style.bottom = "10vh";
        videosSticker.style.right = "30vh";
        videosSticker.style.width = "10vh";
        video.style.filter = filter;
        e.preventDefault();
    })
    photos.addEventListener('change',function(e){
    checkedImg_id = document.querySelector('input[name="radio_name"]:checked').id;
    checkedImg_src = document.querySelector(`img[id='${checkedImg_id}']`).src;
            // Set filter to chosen option
        
        if (checkedImg_src) {
            shareThisPicture.disabled = false;
        }
        e.preventDefault();
    })
    //Clear event
    clearButton.addEventListener('click', function(e){
        //Clear Photos
        photos.innerHTML = '';
        shareThisPicture.disabled = true;
        // Change filter to default normal
        filter = 'none';
        //set video filter  
        video.style.filter = filter;
        //reset select list 
        photoFilter.selectIndex = 0;
    })
    //take picture from canvas
    function takePicture() {
        //Create canvas
        const context = canvas.getContext('2d');
        if (width && height) {
            // set canvas props
            canvas.width = width;
            canvas.height = height;

            //Draw an image of the video on the canvas
            context.drawImage(video, 0, 0,width,height);

            // Create image from the canvas 
            const imgUrl = canvas.toDataURL("image/png");
            // Create img elements
            const input = document.createElement('input');
            const label = document.createElement('label');
            const img = document.createElement('img');
            const sticker = document.createElement('img');

           
            //Set img src

           
            input.setAttribute('type','radio');
            input.setAttribute('id',id);
            input.setAttribute('name','radio_name');
            img.setAttribute('src',imgUrl);
            sticker.setAttribute('src',checkedSticker_src);
            img.setAttribute('id',id);
            
            label.setAttribute('for',id);
            id++;
            // position sticker 
           // img.style.position = "relative";
            sticker.style.position = "absolute";
            sticker.style.bottom = "3vh";
            sticker.style.right = "3vh";
            sticker.style.width = "5vh";

            // Set img filter
            img.style.filter = filter;
            //add image to photos
            
            label.appendChild(img);
            label.appendChild(sticker);
            photos.appendChild(input);
            photos.appendChild(label);
        }

    }
    function savePicture() {
        if (checkedImg_id) {
            document.getElementById('imageData').value = checkedImg_src;
            document.getElementById('sticker').value = checkedSticker_src;
            document.getElementById('filter').value = filter;
        }
      
    }
