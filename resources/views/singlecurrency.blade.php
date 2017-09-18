    @include('includes.header')

    <div class="container">

        <div class="row">
            <h1>Update Currency</h1>

            <!-- the form to update the currency -->
            {{ Form::open(array('url' => '/currencies/$currency->cid', 'id' => 'currency_update_form')) }}
                {{ Form::label('base', 'Base') }}
                {{ Form::text('base', $currency->base, ['readonly']) }}
                {{ Form::label('target', 'Target') }}
                {{ Form::text('target', $currency->target, ['readonly']) }}
                {{ Form::label('currency', 'Currency') }}
                {{ Form::number('currency', $currency->currency, array('id' => 'currency_field','min'=>0)) }}
                <?php
                  //on button click ajax call begins
                  echo Form::button('Update',['onClick'=>'getUpdatedCurrency()']);
                ?>  

                <!-- div for dispaying the result -->
                <div id="message"></div>
                {{ Form::close() }}

                <a href="{{ url('/allcurrencies') }}" class="back">&#8592;Back</a>
        </div>


    </div>
    </body>

          <script>
         function getUpdatedCurrency(){
            //Providing additional header with the request, because we use CSRF
            $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });
            $.ajax({
               type:'POST',
               url:'/calculator/public/getcurrency',
               data: { _token : '<?php echo csrf_token() ?>', data : $("#currency_update_form").serialize() },
               success:function(data){
                  $("#currency_field").html(data.currency);
                  $("#message").html(data.message);
               }
            });
         }
      </script>
</html>