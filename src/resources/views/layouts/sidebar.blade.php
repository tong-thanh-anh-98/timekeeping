<!--**********************************
            Sidebar start
        ***********************************-->
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Home</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('home') }}">Timesheets</a></li>
                </ul>
            </li>
            <!-- khi role là admin (role = 0) -->
            @if(auth()->user()->role === 0)
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fas fa-user-check"></i>
                    <span class="nav-text">User</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('user.list') }}">List</a></li>
                    <li><a href="{{ route('user.create') }}">Create</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span class="nav-text">Holidays</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="#">List</a></li>
                    <li><a href="#">Create</a></li>
                </ul>
            </li>
            @endif
        </ul>

    </div>
</div>
<!--**********************************
            Sidebar end
        ***********************************-->
