
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

    // $(document).ready(function(){
	// 	// when the user clicks on like
	// 	$('.like').on('click', function(){
	// 		var postid = $(this).data('id');
	// 		    $post = $(this);

	// 		$.ajax({
	// 			url: '../views/posts/index.php',
	// 			type: 'post',
	// 			data: {
	// 				'liked': 1,
	// 				'postid': postid
	// 			},
	// 			success: function(response){
	// 				$post.parent().find('span.likes_count').text(response + " likes");
	// 				$post.addClass('hide');
	// 				$post.siblings().removeClass('hide');
	// 			}
	// 		});
	// 	});

	// 	// when the user clicks on unlike
	// 	$('.unlike').on('click', function(){
	// 		var postid = $(this).data('id');
	// 	    $post = $(this);

	// 		$.ajax({
	// 			url: '../views/posts/index.php',
	// 			type: 'post',
	// 			data: {
	// 				'unliked': 1,
	// 				'postid': postid
	// 			},
	// 			success: function(response){
	// 				$post.parent().find('span.likes_count').text(response + " likes");
	// 				$post.addClass('hide');
	// 				$post.siblings().removeClass('hide');
	// 			}
	// 		});
	// 	});
    // });
        
    // $(document).ready(function(){

    //     // if the user clicks on the like button ...
    //     $('.like-btn').on('click', function(){
    //       var post_id = $(this).data('id');
    //       $clicked_btn = $(this);
    //       if ($clicked_btn.hasClass('fa-thumbs-o-up')) {
    //           action = 'like';
    //       } else if($clicked_btn.hasClass('fa-thumbs-up')){
    //           action = 'unlike';
    //       }
    //       $.ajax({
    //           url: 'index.php',
    //           type: 'post',
    //           data: {
    //               'action': action,
    //               'post_id': post_id
    //           },
    //           success: function(data){
    //               res = JSON.parse(data);
    //               if (action == "like") {
    //                   $clicked_btn.removeClass('fa-thumbs-o-up');
    //                   $clicked_btn.addClass('fa-thumbs-up');
    //               } else if(action == "unlike") {
    //                   $clicked_btn.removeClass('fa-thumbs-up');
    //                   $clicked_btn.addClass('fa-thumbs-o-up');
    //               }
    //               // display the number of likes and dislikes
    //               $clicked_btn.siblings('span.likes').text(res.likes);
    //               $clicked_btn.siblings('span.dislikes').text(res.dislikes);
        
    //               // change button styling of the other button if user is reacting the second time to post
    //               $clicked_btn.siblings('i.fa-thumbs-down').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
    //           }
    //       });		
        
    //     });
        
    //     // if the user clicks on the dislike button ...
    //     $('.dislike-btn').on('click', function(){
    //       var post_id = $(this).data('id');
    //       $clicked_btn = $(this);
    //       if ($clicked_btn.hasClass('fa-thumbs-o-down')) {
    //           action = 'dislike';
    //       } else if($clicked_btn.hasClass('fa-thumbs-down')){
    //           action = 'undislike';
    //       }
    //       $.ajax({
    //           url: 'index.php',
    //           type: 'post',
    //           data: {
    //               'action': action,
    //               'post_id': post_id
    //           },
    //           success: function(data){
    //               res = JSON.parse(data);
    //               if (action == "dislike") {
    //                   $clicked_btn.removeClass('fa-thumbs-o-down');
    //                   $clicked_btn.addClass('fa-thumbs-down');
    //               } else if(action == "undislike") {
    //                   $clicked_btn.removeClass('fa-thumbs-down');
    //                   $clicked_btn.addClass('fa-thumbs-o-down');
    //               }
    //               // display the number of likes and dislikes
    //               $clicked_btn.siblings('span.likes').text(res.likes);
    //               $clicked_btn.siblings('span.dislikes').text(res.dislikes);
                  
    //               // change button styling of the other button if user is reacting the second time to post
    //               $clicked_btn.siblings('i.fa-thumbs-up').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
    //           }
    //       });	
        
    //     });
        
    //     });
    const Likebtn = document.getElementsByClassName('likes');

    window.addEventListener('load',function(e){
        document.querySelector('like-btn').addEventListener('click', function() {

            console.log("clicked");
            e.preventDefault();

        
    })
})