die();
document.addEventListener('DOMContentLoaded', function(){
  $.ajax({
    type: 'GET',
    url: 'chat.php',
    data:{
    },
    dataType: 'html',
    cache: false,
    success: function(result) {
      $('#chatbox').html(result);
    }
  }); 

});


function chatMensajes() {
  $.post( "assets/php/chatmensajes.php", function(data) {
    var datas = jQuery.parseJSON(data);
                    // console.log(datas);
                    for (var i = 0; i < datas.length; i++) {

                      switch(datas[i].tipomensaje){
                        case "1" :
                        document.querySelector('.RH').style.width = "220px"
                        document.querySelector('.RH').innerHTML = datas[i].mensaje;
                        break;
                        case "2" :
                        document.querySelector('.CORD').style.width = "220px"
                        document.querySelector('.CORD').innerHTML = datas[i].mensaje;
                        break;
                        case "3" :
                        document.querySelector('.BO').style.width = "220px"
                        document.querySelector('.BO').innerHTML = datas[i].mensaje;
                        break;
                        case "4" :
                        document.querySelector('.GENE').style.width = "220px"
                        document.querySelector('.GENE').innerHTML = datas[i].mensaje;
                        break;
                        default:
                        
                      }

                        // console.log(datas[i]);
                      }
                    });
}


setInterval(function(){
  chatMensajes();
}, 1000);



