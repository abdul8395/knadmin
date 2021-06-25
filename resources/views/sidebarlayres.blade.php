
         <!-- Sidebar  -->
         <nav id="sidebar">
            <div class="sidebar-header">
            
                <h3 style="text-align:center;">KN 1 Admin</h3>
                        @guest
                            @if (Route::has('login'))
                            <ul id="login_li">
                                <a href="{{ route('login') }}">Login</a>
                            </ul>   
                            @endif

                            @else
                            <ul id="login_li" style="margin-left:15%;">
                            <i class="fas fa-sign-out-alt" style="font-size:18px; color:#ffc107;"></i>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" style="text-align:center;  font-size:18px; color:#ffc107">Logout</a>
                            </ul>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                        @endguest
            </div>

         

            <ul class="list-unstyled components" id="switchul">
                <div class="row">
                    <div class="col-sm">
                        <p>All Layers</p>    
                    </div>
                    <div class="col-sm">
                            <!-- <form method="POST" action="/shaperead" enctype="multipart/form-data" id="myForm">
                            @csrf
                                <label class="hlb"><i class="fas fa-upload"style="font-size:15px;"></i>&nbsp
                                <span class="small">Shape File</span>
                                    <input id="shp" class="inputfile" name="zipfile" type="file" size="60" accept=".zip" onchange="$('form').submit();">
                                </label> 
                            </form> -->
                            <button id="shpupbtn" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px !important;">
                                <i class="fas fa-upload" style="font-size:15px;"></i>
                                <span class="small">Shape File</span>
                            </button>
                    </div>

                </div>
                
                
                
               
                <li class="{{ Request::is('switch_layre/area_b_demolitions') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_demolitions'}}">Area B Demolitions</a>
                </li>
                <li class="{{ Request::is('switch_layre/Area_AB_Combined') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'Area_AB_Combined'}}">Area A&B Combined</a>
                </li>
                <li class="{{ Request::is('switch_layre/area_b_naturereserve') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_nature_reserve'}}" >Area B Nature Reserve</a>
                </li>
                <li class="{{ Request::is('switch_layre/Area_AB_Naturereserve') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'Area_AB_Naturereserve'}}">Area A&B Naturereserve</a>
                </li>

                <li class="{{ Request::is('switch_layre/area_a_poly') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_a_poly'}}">Area A Poly</a>
                </li>

                <li class="{{ Request::is('switch_layre/area_b_poly') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_poly'}}">Area B Poly</a>
                </li>

                <li class="{{ Request::is('switch_layre/area_b_training') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'area_b_training'}}">Area B Tranining</a>
                </li>

                <li class="{{ Request::is('switch_layre/demolitions_orders') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'demolitions_orders'}}">Demolitions Orders</a>
                </li>

                <li class="{{ Request::is('switch_layre/expropriation_orders') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'expropriation_orders'}}">Expropriation Orders</a>
                </li>

                <li class="{{ Request::is('switch_layre/expropriation_orders_AB') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'expropriation_orders_AB'}}">Expropriation Orders AB</a>
                </li>

                <li class="{{ Request::is('switch_layre/expropriation_orders_not_AB') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'expropriation_orders_not_AB'}}">Expropriation Orders Not AB</a>
                </li>

                <li class="{{ Request::is('switch_layre/security_orders') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'security_orders'}}">Security Orders</a>
                </li>

                <li class="{{ Request::is('switch_layre/Seizure_AB') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'Seizure_AB'}}">Seizure AB</a>
                </li>

                <li class="{{ Request::is('switch_layre/Seizure_All') ? 'active' : '' }}">
                    <a href="/switch_layre/{{'Seizure_All'}}">Seizure All</a>
                </li>
               
            </ul>

           
        </nav>

