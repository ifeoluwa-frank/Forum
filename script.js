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
