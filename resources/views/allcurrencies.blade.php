    @include('includes.header')

    <div class="container">

        <div class="row">
            <h1>All Currencies</h1>

            <?php
            //dispaying all the data from currencies table
            foreach ($data as $table_data){

                echo '<div class="currency-row">';
                echo '<p>'. $table_data->base_name .'</p>';
                echo '<p>'. $table_data->target_name .'</p>';
                echo '<p>'. $table_data->currency .'</p>';
                echo '<p><a href="'. url('/currencies/'.$table_data->cid) .'">Update</a></p>';                
                echo '</div>';
            }

            ?>

            <!-- link to get user to the add currency page -->
            <a href="{{ url('/addcurrency') }}" class="back">Add Currency</a>

        </div>
    </div>
    </body>
</html>