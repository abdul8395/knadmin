<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>KnAdmin</title>

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
                background: #191828;
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">


           
<div class="tabset" style="
  margin-right: 20%;
  margin-left: 20%; ">
  <!-- Tab 1 -->
  <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
  <label for="tab1" style="color:#fff">Login</label>
  <!-- Tab 2 -->
  <!-- <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
  <label for="tab2" style="color:#fff">Login As KN2</label> -->
    <!-- Tab 3 -->
    <input type="radio" name="tabset" id="tab3" aria-controls="t3">

    <label for="tab3" style="color:#fff">Register Admin</label>
   <!-- Tab 4 -->
   
  


  <div class="tab-panels">
    <section id="marzen" class="tab-panel">
    <h1 style="text-align:center; color:#9db034">Welcome To KN Admin</h1>
      <p style="text-align:center; color:#fff">Login As Admin <b style="color:#9db034">KN1</b> </p>
      
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('Login') }}</div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Login') }}
                                            </button>

                                        
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




     </section>
    
    <section id="t3" class="tab-panel">
    <h1 style="text-align:center; color:#9db034">Welcome To KN Admin</h1>
    <p style="text-align:center; color:#fff">Register A New <b style="color:#9db034">Admin</b></p>
        @include('auth.register')
    </section>
    
  </div>
  
</div>




        <!-- </div> -->
    </body>
</html>


