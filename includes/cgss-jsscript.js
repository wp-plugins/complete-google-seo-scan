jQuery(document).ready(function(){
jQuery(".cgss-tip").tooltip();
jQuery("#tabsonelink").click(function(){
 jQuery("#tabsone").show();
 jQuery("#tabstwo, #tabsthree, #tabsfour").hide();
 jQuery("#tabstwolink, #tabsthreelink, #tabsfourlink").css("color","inherit");
 jQuery(this).css("color","#6495ed")
});
jQuery("#tabstwolink").click(function(){
 jQuery("#tabstwo").show();
 jQuery("#tabsone, #tabsthree, #tabsfour").hide();
 jQuery("#tabsonelink, #tabsthreelink, #tabsfourlink").css("color","inherit");
 jQuery(this).css("color","#6495ed");
});
jQuery("#tabsthreelink").click(function(){
 jQuery("#tabsthree").show();
 jQuery("#tabsone, #tabstwo, #tabsfour").hide();
 jQuery("#tabsonelink, #tabstwolink, #tabsfourlink").css("color","inherit");
 jQuery(this).css("color","#6495ed");
});
jQuery("#tabsfourlink").click(function(){
 jQuery("#tabsfour").show();
 jQuery("#tabsone, #tabstwo, #tabsthree").hide();
 jQuery("#tabsonelink, #tabstwolink, #tabsthreelink").css("color","inherit");
 jQuery(this).css("color","#6495ed");
});
jQuery(".hndle-one").click(function(){jQuery(".body-one").slideToggle("slow");});
});
