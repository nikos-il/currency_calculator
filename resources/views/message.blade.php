<html>
   <head>
      <title>Ajax Example</title>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>
      
      <script>
         function getMessage(){
            //Providing additional header with the request, because we use CSRF
            $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });
            $.ajax({
               type:'POST',
               url:'/calculator/public/getmsg',
               data:'_token = <?php echo csrf_token() ?>',
               success:function(data){
                  $("#msg").html(data.msg);
               }
            });
         }
      </script>
   </head>
   
   <body>
      <div id = 'msg'>This message will be replaced using Ajax. 
         Click the button to replace the message.</div>
      <?php
         echo Form::button('Replace Message',['onClick'=>'getMessage()']);
      ?>
   </body>

</html>