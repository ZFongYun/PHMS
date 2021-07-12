<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- LOGO -->
            <div class="topbar-left logo">
                知點
            </div>
            <!-- End Logo container-->

            <div class="navbar-custom navbar-left">
                <div id="navigation">
                    <!-- Navigation Menu-->
                    <ul class="navigation-menu">
                        <li>
                            <a href="{{action('AdminController@index')}}">
                                <span> 首頁 </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{action('AdminHrController@index')}}">
                                <span> 人資管理 </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{action('AdminPmController@index')}}">
                                <span> 專案管理 </span>
                            </a>
                        </li>
                    </ul>
                    <!-- End navigation menu  -->
                </div>
            </div>

            <div class="menu-extras">
                <ul class="nav navbar-right float-right list-inline">
                    <li class="dropdown user-box list-inline-item">
                        <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true">
                            {{auth('admin')->user()->account}} <i class="zmdi zmdi-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{{action('AdminInfoController@index')}}" class="dropdown-item"><i class="fa fa-user m-r-10"></i> 用戶資料</a></li>
                            <li><a href="{{action('AdminController@logout')}}" class="dropdown-item"><i class="fa fa-sign-out m-r-10"></i>登出</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!-- End Navigation Bar-->
