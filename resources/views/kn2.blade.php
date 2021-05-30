@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1 style="text-align:center; color:#9db034">KN2 Coming Soon......</h1>
<br/>
<br/>
                        @guest
                            @if (Route::has('login'))
                            <ul id="login_li">
                                <a href="{{ route('login') }}">Login</a>
                            </ul>   
                            @endif

                            @else
                            <ul id="login_li">
                            <h3>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
                                                     </h3>
                            </ul>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                        @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
