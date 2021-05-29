<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

      <link rel="stylesheet" href="{{URL::asset('/css/tab_style.css')}}">

        <!-- Styles -->
        <style>

        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            
<!-- 
            <h1 id="hed1">
            Welcome To KN Admin
            </h1>

            <div class="tabs">
            <div class="tab-2">
                <label for="tab2-1">KN1 Admin Login</label>
                <input id="tab2-1" name="tabs-two" type="radio" checked="checked">
                <div>
                @yield('content')
                </div>
            </div>
            <div class="tab-2">
                <label for="tab2-2">KN2 Admin Login</label>
                <input id="tab2-2" name="tabs-two" type="radio">
                <div>
                @yield('content')
                </div>
            </div>
            </div> -->


           
<div class="tabset">
  <!-- Tab 1 -->
  <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
  <label for="tab1">KN1</label>
  <!-- Tab 2 -->
  <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
  <label for="tab2">KN2</label>

  
  <div class="tab-panels">
    <section id="marzen" class="tab-panel">
      <h2>Kn1 Login</h2>
      @include('auth.login')

     </section>
    <section id="rauchbier" class="tab-panel">
      <h2>kn2 Login</h2>
      @include('auth.login')
      </section>
    
  </div>
  
</div>




        <!-- </div> -->
    </body>
</html>
