'use strict';
let postUpdate = document.querySelector('.post-update');
let postContent = document.querySelector('.content');
let postTitle = document.querySelector('.post-title');
let postCategory = document.querySelector('.select-category');
let postId = document.querySelector('.post_id');
let btnClear = document.querySelector('.clear-field');
let btnDelete = document.querySelector('.btnDelete');
let btnUpdate = document.querySelector('.btn-post');
let btnComment = document.querySelector('.comment-button');

// console.log(postTitle);

function handleEdit(post){
    console.log('post=>', post);
    postTitle.value = post.post_title;
    postCategory.value = post.post_category;
    postContent.value = post.post_content;
    postId.value = post.post_id;
    // btnUpdate.innerHTML = "Update";
    console.log(postTitle);

    btnClear.removeAttribute('hidden');
}

function clearField(){
    postTitle.value = "";
    postCategory.value = "";
    postContent.value = "";
    postId.value = "";

    btnClear.setAttribute('hidden', true);
}

function toggleComment(commentIcon) {
    let post = commentIcon.closest('.each-post');

    let textarea = post.querySelector('.comment-field');
    let submitButton = post.querySelector('.comment-submit');

    textarea.hidden = !textarea.hidden;
    submitButton.hidden = !submitButton.hidden;
}

$(document).ready(function(){
    var OpenCommentForm = function () {
        var post_id = $(this).attr('data-postId');
        var user_id = $(this).attr('data-user');

        var formNum = $("#comment_form").length;
        var currentEl = $(this);




        if(formNum > 0){
            $("#comment_form").remove();
        }

        $.get('commentHandler.php', function(resp){
            var errors = $("#errors").length;
            if(errors > 0){
                $("#errors").remove();
            }
            if(resp == '200'){
                currentEl.closest('.each-post-post').after(`
                    <div class="comment-form" id="comment_form">
                       <textarea class="comment-field" id="comment_box" name="commentContent" rows="1" cols="50" placeholder="Add a comment..." ></textarea>
                        <button class="comment-submit" name="btnCommentSubmit" id="submit_comment">Submit</button>
                    </div>
                `);

            //  process comment submission
                $("#submit_comment").click(function(){

                    var comment = $("#comment_box").val();
                    $("#submit_comment").html('<i class="fa fa-spin fa-spinner"></i> saving')
                    $.post('saveComment.php', {user_id, comment, post_id}, function(response){
                        if(response == 200){
                            $("#comment_form").html(`<div>Comment saved</div>`);
                        }
                    })
                });
            }else{
                currentEl.closest('.each-post-post').after(`<div class="error" id="errors">Please login to your account to post comment!</div>`)
            }
        })
    }

//    Triggers
    $("button#comment_form_trigger").on('click', OpenCommentForm);
});
