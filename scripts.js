/**
 * Created by Admin on 22.03.2018.
 */
function sendPost(selector) {
    $(selector).on('submit',function(){

        var data = $(this).serialize();
        var url =$(this).attr('action');
        var post =$(this).attr('method');

        $.ajax({
            type:post,
            url:url,
            data:data,
            dataType:'json',
            success:function(data){
                
            }
        })
    });
}
  
sendPost("#register");
sendPost("#login");



