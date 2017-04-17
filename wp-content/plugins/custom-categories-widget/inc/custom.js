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
        if(jq(this).next().is(':hidden')){
            jq(this).next().slideDown();
        }else{
            jq(this).next().slideUp();
        }
    });
    jq('.custom-subcat-item .custom-subcat-btn').click(function(){
        childHeading.removeClass('showing');
        childDivs.slideUp();
        if(jq(this).next().is(':hidden')){
            jq(this).next().slideDown();
        }else{
            jq(this).next().slideUp();
        }
    });
});