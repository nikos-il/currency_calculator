<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Currency Calculator</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        
        {{ Html::style('css/style.css') }}

      <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>

    </head>

  <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-collapse collapse" id="navbar">
          <ul class="nav navbar-nav">
            <li><a href="/calculator/public">Home</a></li>
            <li><a href="/calculator/public/allcurrencies">View Currencies</a></li>
            <li><a href="{{ url('/addcurrency') }}" class="back">Add Currency</a></li>

            <?php
              if (Auth::check()) { ?>

                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
              <?php }
              else { ?>
                 <li><a href="https://dev.stinpriza.org/calculator/public/login">Login</a></li>
                
              <?php }
            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <body>