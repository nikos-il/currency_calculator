    @include('includes.header')

    <div class="container">

        <div class="row">
            <h1>Add Currency</h1>

            {{ HTML::ul($errors->all()) }}

            <!-- the form to pass data for insertion in db -->
            {{ Form::open(array('url' => '/addcurrency', 'id' => 'currency_add_form')) }}
                {{ Form::label('base', 'Base Code') }}
                {{ Form::text('base') }}

                {{ Form::label('base_name', 'Base Name') }}
                {{ Form::text('base_name') }}

                {{ Form::label('target', 'Target Code') }}
                {{ Form::text('target') }}

                {{ Form::label('target', 'Target Name') }}
                {{ Form::text('target_name') }}

                {{ Form::label('currency', 'Currency') }}
                {{ Form::number('currency',null,['step'=>'any', 'min'=>0]) }}

                {{ Form::submit('Add Currency') }} 

                {{ Form::close() }}

                <!-- display success message -->
                @if (Session::has('message'))
                  <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif

                <a href="{{ url('/allcurrencies') }}" class="back">&#8592;Back</a>
        </div>


    </div>
    </body>

</html>