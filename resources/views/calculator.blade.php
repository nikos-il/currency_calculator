    @include('includes.header')
    <div class="container">

   <div class="alert alert-info">{{ Session::get('value') }}</div>

        <div class="row">
            <h1>Currency Calculator</h1>

            <!-- the form with the data for the calculations -->
            <form action="/calculator/public/calculator" method="post" id="calculator_form">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="base">Base</label>
                    <select name="base">

                       <?php 
                          //putting the base fields in a select dropdown
                          foreach ($bases as $base) {
                            echo '<option value="'. $base->base .'">'. $base->base_name .'</option>';
                          }
                       ?>
  					       </select>
                </div>
                <div class="form-group">
                    <label for="target">Target</label>
                    <select name="target">
                       <?php 
                          //putting the target fields in a select dropdown         
                          foreach ($targets as $target) {
                            echo '<option value="'. $target->target .'">'. $target->target_name .'</option>';
                          }
                       ?>
  					         </select>
                </div>
                <div class="form-group">
                    <label for="value">Value</label>
                    <!-- the input for the value to be converted -->
                    <input type="number" class="form-control" id="value" name="value" placeholder="value" min=0 <?php if (isset($value)){ echo 'value='. $value; } ?>
                        ?>
                    </input>
                </div>

                <?php
                 //on button click ajax call begins
                 echo Form::button('Calculate',['onClick'=>'getResult()']);
                ?>

                <div class="result-box">
                    <!-- div for dispaying the result -->
                    <div>Result:</div> <div id="result"></div>
                </div>
            </form>

        </div>
    </div>
    </body>

    <script>
       //ajax function
       function getResult(){
          //Providing additional header with the request, because we use CSRF
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
          });
          $.ajax({
             type:'POST',
             url:'/calculator/public/getresult',
             data: { _token : '<?php echo csrf_token() ?>', data : $("#calculator_form").serialize() }, //getting data from form
             success:function(data){
                $("#result").html(data.result); //if call successfull, we pass the result in div with id result
             }
          });
       }
    </script>

</html>