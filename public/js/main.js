const URLROOT = 'http://192.168.99.116';

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
        xhr.onreadystatechange = function () {
          if(xhr.readyState == 4 && xhr.status == 200) {
            var result = xhr.responseText;
            console.log('Result: ' + result);
          }
        };
        var like_count=document.getElementById(this.value);
        var counter = parseInt(like_count.innerText); 
        var like;
        if (this.innerText === "UnLike") {
            this.innerText="Like";
            like_count.innerText = counter -=1;
            like="-1";
        }else{
            this.innerText="UnLike";
            like_count.innerText = counter +=1;
            like="1";
        }
           
        xhr.send("like="+like+"&&postId="+this.value);

    }
    var post_comment = document.getElementById('post_comment').addEventListener('click', function(e){
        var xhr = new XMLHttpRequest();
        xhr.open('POST', URLROOT+'/posts/comments', true);
        // form data is sent appropriately as a POST request
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function () {
          if(xhr.readyState == 4 && xhr.status == 200) {
            var result = xhr.responseText;
            console.log('Result: ' + result);
          }
        };
        //empty comment box
        var message = document.getElementById('message').value;
       // var counter = parseInt(like_count.innerText); 
       document.getElementById('message').value = "";
       var commentBox = document.getElementById('commentBox');
       var user_Id = document.getElementById('user_name').innerText;
       var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date+' '+time;
       console.log(user_Id);
       console.log(dateTime);
       var html = '<h5 class="h5 text-left">'+user_Id+'</h5><h6 class="h6 g-color-gray-dark-v1 mb-0 text-left">'+ dateTime + '</h6><div class=" card card-body text-left mb-3"><span>'+message+'</span></div>';
       var comments =commentBox.innerHTML;
       commentBox.innerHTML = html + comments;
        xhr.send("post_comment="+message+"&&postId="+this.value);
    })
    // .addEventListener("click", postcomment);
    // function postcomment() {
        // var like = 0;
        //  var xhr = new XMLHttpRequest();
        //  xhr.open('POST', 'http://localhost/camagru/posts/comments', true);
        //  // form data is sent appropriately as a POST request
        //  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        //  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        //  xhr.onreadystatechange = function () {
        //    if(xhr.readyState == 4 && xhr.status == 200) {
        //      var result = xhr.responseText;
        //      console.log('Result: ' + result);
        //    }
        //  };
        //  var message = document.getElementById("message").innerText;
        // // var counter = parseInt(like_count.innerText); 
        //     console.log(message);
        //  xhr.send("post_comment="+message+"&&postId="+this.value);

   //  }