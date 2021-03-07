const URLROOT = 'http://localhost';

    function displayMenu(event) {
        if (document.getElementById("navbar-list").classList.contains("show")) {
            document.getElementById("navbar-list").classList.remove("show")
        }
        else {
            document.getElementById("navbar-list").classList.add("show")
        }
    }
    window.onload = function() {
        var activeTab = window.location.hash;
        
        var menuItens = document.querySelectorAll('#menuTabs>li');
        if (activeTab == "#tab_2") {
            var tabs = document.querySelectorAll('.tab-content>.tab-pane');
                for (var k = 0; k < tabs.length; k++) {
                     tabs[k].classList.remove("active");
                 }
                // removing .active from menu itens
                for (var j = 0; j < menuItens.length; j++) {
                    menuItens[j].classList.remove("active");
                    menuItens[j].classList.remove("btn");
                    menuItens[j].classList.remove("btn-success");
                }
                    // setting .active in clicked item
                    menuItens[1].classList.add("active");
                    menuItens[1].classList.add("btn");
                    menuItens[1].classList.add("btn-success");
            //     // getting target id
                var linkTab = menuItens[1].getElementsByTagName("a")[0].id;
                //console.log(linkTab);
                // showing the selected tab div
                var tab = document.querySelectorAll('.tab-content>#'+linkTab)[0];
                tab.classList.add("tab-pane");
                tab.classList.add("active");
        }
        for (var i = 0; i < menuItens.length; i++) {
            menuItens[i].addEventListener("click", function(){
                // occulting divs - removing .active class
                var tabs = document.querySelectorAll('.tab-content>.tab-pane');
                for (var k = 0; k < tabs.length; k++) {
                     tabs[k].classList.remove("active");
                 }
                // removing .active from menu itens
                for (var j = 0; j < menuItens.length; j++) {
                    menuItens[j].classList.remove("active");
                    menuItens[j].classList.remove("btn");
                    menuItens[j].classList.remove("btn-success");
                }
                // setting .active in clicked item
                this.classList.add("active");
                this.classList.add("btn");
                this.classList.add("btn-success");
                // getting target id
                var linkTab = this.getElementsByTagName("A")[0].id;
                //console.log(linkTab);
                // showing the selected tab div
                var tab = document.querySelectorAll('.tab-content>#'+linkTab)[0];
                tab.classList.add("tab-pane");
                tab.classList.add("active");
            });
        }
    };
    var like_button = document.getElementsByClassName('like-button');
    var i = like_button.length;
     while (i--)
        like_button[i].addEventListener("click", likeButton);
    function likeButton() {
       // var like = 0;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', URLROOT+'/posts/likes', true);
        // form data is sent appropriately as a POST request
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        var like_count=document.getElementById(this.value);
        var counter = parseInt(like_count.innerText); 
        var like;
        if (this.innerText === "Dislike") {
            this.innerText="Like";
            like_count.innerText = counter -=1;
            like="-1";
        }else{
            this.innerText="Dislike";
            like_count.innerText = counter +=1;
            like="1";
        }
           
        xhr.send("like="+like+"&&postId="+this.value);

    }
var post_comment = document.getElementsByClassName('post_comment');
    var k = post_comment.length;
    while (k--)
        post_comment[k].addEventListener('click', function(e){
        var xhr = new XMLHttpRequest();
        xhr.open('POST', URLROOT+'/posts/comments', true);
        // form data is sent appropriately as a POST request
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        //empty comment box
        var message = document.getElementById('message='+this.value).value;
       // var counter = parseInt(like_count.innerText); 
       document.getElementById('message='+this.value).value = "";
       var commentBox = document.getElementById('commentBox='+this.value);
       var user_Id = document.getElementById('user_name').innerText;
       var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date+' '+time;
       var html = '<h5 class="h5 text-left">'+user_Id+'</h5><h6 class="h6 g-color-gray-dark-v1 mb-0 text-left">'+ dateTime + '</h6><div class=" card card-body text-left mb-3"><span>'+message+'</span></div>';
       var comments =commentBox.innerHTML;
       commentBox.innerHTML = html + comments;
        xhr.send("post_comment="+message+"&&postId="+this.value);
    });
   var delete_Post = document.getElementsByClassName('deletePost');
    var j = delete_Post.length;
     while (j--)
     delete_Post[j].addEventListener("click", deletepost);
        function deletepost() {
            // var like = 0;
             var xhr = new XMLHttpRequest();
             xhr.open('POST', URLROOT+'/posts/delete', true);
             // form data is sent appropriately as a POST request
             xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
             xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
             var deleted = document.getElementById('Full_Post='+this.value);
             deleted.remove();
                
             xhr.send("deleteId="+this.value);
             console.log('Full_Post='+this.value);
         }