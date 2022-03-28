
<div class="left-side-menu">
    <div class="slimscroll-menu">

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li class="menu-title">Navigation</li>
                <li>
                    <a href="{{route('admin.dashboard')}}" class="waves-effect waves-light">
                        <i class="mdi mdi-view-dashboard"></i>Dashboard  
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect waves-light">
                        <i class="mdi mdi-hospital"></i>
                        <span>Caregiver</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{{route('admin.caregiver.list.approved')}}">Approved Caregivers</a></li>
                        <li><a href="{{route('admin.caregiver.request.for.approval')}}">Request For Approval</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect waves-light">
                        <i class="mdi mdi-hospital-building"></i>
                        <span>Agency</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{{route('admin.agency.list.approved')}}">Approved Caregivers</a></li>
                        <li><a href="{{route('admin.agency.request.for.approval')}}">Request For Approval</a></li>
                    </ul>
                </li>
            </ul>

        </div>
        <!-- End Sidebar -->
    </div>
  <!-- Sidebar -left -->
</div>
