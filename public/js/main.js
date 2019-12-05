var url = 'http://localhost:8080/Proyectos/AprendiendoLaravel/public/';

window.addEventListener("load", function(){

    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');

   // Boton Like
   function like(){
        $('.btn-like').unbind('click').click(function(){
            console.log('like');
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', url+'img/heart-red.png');
            dislike();

            $.ajax({
                url: url+'/like/'+$(this).data('id'),
                type: 'GET',
                success:  function(response){
                    if(response.like){
                        console.log('Has dado like a la publicacion')
                    }else{
                        console.log('Error al dar like')
                    }
                }
            });
        })
   }
   like();

   //Boton Dislike
   function dislike(){
        $('.btn-dislike').unbind('click').click(function(){
            console.log('dislike');
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', url+'img/heart-black.png');
            like();

            $.ajax({
                url: url+'/dislike/'+$(this).data('id'),
                type: 'GET',
                success:  function(response){
                    if(response.like){
                        console.log('Has dado dislike a la publicacion')
                    }else{
                        console.log('Error al dar dislike')
                    }
                }
            });
        })
   }
   dislike();

});