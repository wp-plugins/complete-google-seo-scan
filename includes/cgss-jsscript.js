jQuery(document).ready(function(){ jQuery(".hndle-one").click(function(){jQuery(".body-one").slideToggle("slow");});jQuery(".hndle-two").click(function(){jQuery(".body-two").slideToggle("slow");});jQuery("#pagecontent").click(function(){jQuery("html, body, .content").animate({scrollTop: jQuery("#pagecontentBODY").position().top}, "slow");});jQuery("#directlinkSELL").click(function(){jQuery("html, body, .content").animate({scrollTop: jQuery("#directbodySELL").position().top}, "slow");});jQuery(".hndle-content").click(function(){jQuery(".body-content").slideToggle("slow");}); });
