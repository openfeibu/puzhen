$(function(){
  new WOW().init();
  
  // $(window).scroll(function(){
  //   var t = $(window).scrollTop();
  //   if($(".headerBg").hasClass("fixedActive")){
  //     return false;
  //   }
  //   if(t != 0){
  //     if(!$(".headerBg").hasClass("active")){
  //       $(".headerBg").addClass("active")
  //     }
  //   }else{
  //     $(".headerBg").removeClass("active")
  //   }

  //   if(t > 100){
  //     if(!$(".scrollT").hasClass("active")){
  //       $(".scrollT").addClass("active");
  //     }
  //   }else{
  //     $(".scrollT").removeClass("active");
  //   }
  // })
  //PC导航栏
  $("header ul li").hover(function(){
    $(this).find("dl").stop().slideDown(200)
  },function(){
    $(this).find("dl").stop().slideUp(200)
  })
   //PC语言栏
  $(".lang").hover(function(){
    $(this).find("dl").stop().slideDown(200)
  },function(){
    $(this).find("dl").stop().slideUp(200)
  })
   //H5导航栏
  $(".menu").on("click",function(){
    $("#wap-nav").show();
    setTimeout(function(){
    $(".nav-box").css("right","0");
    },100)
  })
  $("#wap-nav ul li").on("click",function(){
    $("#wap-nav ul li").find("dl").stop().slideUp(200)
    $(this).find("dl").stop().slideToggle(200)
  })
  $(".wapNav-close").on("click",function(){
    
    $(".nav-box").css("right","-4rem");
    setTimeout(function(){
      $("#wap-nav").hide();
    },500)
  })






  //返回顶部
  $(".scrollT").on("click",function(){
    $("body,html").animate({
      scrollTop:0
    },200)
  })
  //显示二维码
  $(".fixed-nav-item-code").hover(function(){
    $(this).find(".code-img").fadeIn(200)
  },function(){
    $(this).find(".code-img").fadeOut(200)
  })
  //显示搜索
  $(".fixed-nav-item-search").on("click",function(){
    $(".fixed-search").fadeIn(200)
  })
  $(".fixed-search-close").on("click",function(){
    $(".fixed-search").fadeOut(200)
  })





  //显示密码
  $(".form-eye").on("click",function(){
    if(!$(this).hasClass("active")){
      $(this).addClass("active");
      $(this).parents(".form-input").find("input").attr("type","text");
    }else{
      $(this).removeClass("active");
      $(this).parents(".form-input").find("input").attr("type","password");
    }
  })




})

  //弹出提示框
  function fb_alert(msg){
    var html = '';
    html +=`<div class="fb-alert-mask">
                <div class="alert-test">`+msg+`</div>
            </div>`;
    $("body").append(html);
    setTimeout(function(){
      $(".fb-alert-mask").fadeOut(200);
    },1000)
  }
//手机号码验证  
jQuery.validator.addMethod("isMobile", function(value, element) {  
 var length = value.length;  
 var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;  
 return this.optional(element) || (length == 11 && mobile.test(value));  
}, "请正确填写手机号码");  

 //显示加载
function showLoading(){
  $(".fb-loading").fadeIn(200);
}
  //隐藏加载
function hideLoading(){
  $(".fb-loading").fadeOut(200);
}
