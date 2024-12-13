$(document).ready(function(){
  const myTimeout = setTimeout(timer2, 4000);
  function timer2() {
    // $('.PopUpMessage').css("display","none");
    $('.PopUpMessage').slideUp();
  }

  


  $('.checkShowPassword').click(function(){
    if('password' == $('.test-input').attr('type')){
         $('.test-input').prop('type', 'text');
    }else{
         $('.test-input').prop('type', 'password');
    }
  });
})