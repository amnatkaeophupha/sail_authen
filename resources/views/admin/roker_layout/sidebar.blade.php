<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{url('rocker');}}/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Web Admin</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
     </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ url('admin/profile'); }}">
                <div class="parent-icon"><i class="bx bx-user-circle"></i>
                </div>
                <div class="menu-title">User Profile</div>
            </a>
        </li>
        <li>
            <a href="{{ url('admin'); }}" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
            <ul>
                <li> <a href="index.html"><i class='bx bx-radio-circle'></i>Carousels</a>
                </li>
                <li> <a href="index2.html"><i class='bx bx-radio-circle'></i>Aru News</a>
                </li>
                <li> <a href="index3.html"><i class='bx bx-radio-circle'></i>Aru Job</a>
                </li>
            </ul>
        </li>
    </ul>
    <!--end navigation-->
</div>
