
         <!-- Sidebar  -->
         <nav id="sidebar">
            <div class="sidebar-header">
                <h3>KN 1 Admin</h3>
                @guest
                            @if (Route::has('login'))
                            <li id="login_li">
                                <a href="{{ route('login') }}">Login</a>
                            </li>   
                            @endif

                            @else
                            <li id="login_li">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                        @endguest
            </div>

            <ul class="list-unstyled components" id="switchul">
                <p>All Layers</p>
                
                <li class="{{ Request::is('switch_layre/area_b_naturereserve') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_naturereserve'}}" >Area B Naturereserve</a>
                </li>
               
                <li class="{{ Request::is('switch_layre/area_b_demolitions') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_demolitions'}}">Area B Demolitions</a>
                </li>

                <li class="{{ Request::is('switch_layre/area_b_demolitions') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_demolitions'}}">Area A&B Combined</a>
                </li>

                <li class="{{ Request::is('switch_layre/area_b_demolitions') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_demolitions'}}">A Area B Naturereserve</a>
                </li>

                <li class="{{ Request::is('switch_layre/area_b_demolitions') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_demolitions'}}">Area A Poly</a>
                </li>

                <li class="{{ Request::is('switch_layre/area_b_demolitions') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_demolitions'}}">Area B Poly</a>
                </li>

                <li class="{{ Request::is('switch_layre/area_b_demolitions') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_demolitions'}}">Area B Tranining</a>
                </li>

                <li class="{{ Request::is('switch_layre/area_b_demolitions') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_demolitions'}}">Demolitions Orders</a>
                </li>

                <li class="{{ Request::is('switch_layre/area_b_demolitions') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_demolitions'}}">Expropriation Orders</a>
                </li>

                <li class="{{ Request::is('switch_layre/area_b_demolitions') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_demolitions'}}">Expropriation Orders AB</a>
                </li>

                <li class="{{ Request::is('switch_layre/area_b_demolitions') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_demolitions'}}">Expropriation Orders Not AB</a>
                </li>

                <li class="{{ Request::is('switch_layre/area_b_demolitions') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_demolitions'}}">Security Orders</a>
                </li>

                <li class="{{ Request::is('switch_layre/area_b_demolitions') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_demolitions'}}">Seizure AB</a>
                </li>

                <li class="{{ Request::is('switch_layre/area_b_demolitions') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_demolitions'}}">Seizure All</a>
                </li>
               
            </ul>

           
        </nav>

