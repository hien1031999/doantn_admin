<!-- ========== Left Sidebar Start ========== -->
@php
    if (!isset($pageInfo['page'])) {
        $page = "dashboard";
    } else {
        $page = $pageInfo['page'];
    }
@endphp

<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect @if($page == 'dashboard') mm-active @endif">
                        <i class="fas fa-home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                {{-- @if (Auth::user()->vai_tro_id == 1)
                    <li>
                        <a href="" class="waves-effect @if($page == 'Thống kê') mm-active @endif">
                            <span>Thống kê doanh thu</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="waves-effect @if($page == 'Báo cáo') mm-active @endif">
                            <span>Báo cáo</span>
                        </a>
                    </li>
                @endif --}}

                <li class="menu-title">Quản lý</li>

                @if (Auth::user()->vai_tro_id == 1)
                    <li>
                        <a href="{{ route('nhan-vien.list') }}" class="waves-effect @if($page == 'Nhân viên') mm-active @endif">
                           <i class="fas fa-users-cog"></i> 
                            <span>Nhân viên</span>
                        </a>
                    </li>

                    <li>
                        <a href="" class="waves-effect @if($page == 'customer') mm-active @endif">
                        <i class="fas fa-users "></i> 
                            <span>Khách hàng</span>
                        </a>
                    </li>

                    <li>
                        <a href="" class="waves-effect @if($page == 'role') mm-active @endif">
                            <i class="fas fa-wrench"></i> 
                            <span>Vai trò</span>
                        </a>
                    </li>
                @endif

                {{-- @if (Auth::user()->vai_tro_id == 1)
                    <li>
                        <a href="javascript:void(0);" class="waves-effect @if(in_array($page, ['Lãi suất', 'Trả góp'])) mm-active @endif">
                            <span>Danh mục lãi suất
                                <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span>
                            </span>
                        </a>
                        <ul class="submenu">
                            <li><a href="" class="waves-effect @if($page == 'Lãi suất') mm-active @endif">Lãi suất</a></li>
                            <li><a href="" class="waves-effect @if($page == 'Trả góp') mm-active @endif">Trả góp</a></li>
                        </ul>
                    </li>
                @endif --}}

            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
