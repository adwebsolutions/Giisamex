jQuery(document).ready(function (jq) {
    "use strict";
    var parentHeadings = jq('.custom-cat-item');
    var parentDivs = jq('.custom-cat-item ul');

    var childHeading = jq('.custom-subcat-item');
    var childDivs = jq('.custom-subcat-item ul');

    var target = window.location.hash;
    jq('.custom-cat-item .custom-cat-btn').click(function(){
        parentDivs.slideUp();
        childDivs.slideUp();
        parentHeadings.children('.custom-cat-btn').removeClass('active');
        if(jq(this).next().is(':hidden')){
            jq(this).next().slideDown();
            jq(this).addClass('active');
        }else{
            jq(this).next().slideUp();
            jq(this).removeClass('active');
        }
    });
    jq('.custom-subcat-item .custom-subcat-btn.has-post').click(function(){
        childHeading.children('.has-post').removeClass('active');
        childDivs.slideUp();
        if(jq(this).next().is(':hidden')){
            jq(this).next().slideDown();
            jq(this).addClass('active');
        }else{
            jq(this).next().slideUp();
            jq(this).removeClass('active');
        }
    });
});