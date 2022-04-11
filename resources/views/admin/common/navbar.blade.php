
<div class="navbar-custom">
  <ul class="list-unstyled topnav-menu float-right mb-0">

      <li class="dropdown notification-list">
          <a class="nav-link dropdown-toggle  waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
              <i class="mdi mdi-bell noti-icon"></i>
              <span class="badge badge-success rounded-circle noti-icon-badge">4</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-lg">

              <!-- item-->
              <div class="dropdown-item noti-title">
                  <h5 class="font-16 m-0">
                      <span class="float-right">
                          <a href="#" class="text-dark">
                              <small>Clear All</small>
                          </a>
                      </span>Notification
                  </h5>
              </div>

              <div class="slimscroll noti-scroll">

                  <!-- item-->
                  <a href="javascript:void(0);" class="dropdown-item notify-item">
                      <div class="notify-icon bg-success">
                          <i class="mdi mdi-settings-outline"></i>
                      </div>
                      <p class="notify-details">New settings
                          <small class="text-muted">There are new settings available</small>
                      </p>
                  </a>
          
                  <!-- item-->
                  <a href="javascript:void(0);" class="dropdown-item notify-item">
                      <div class="notify-icon bg-info">
                          <i class="mdi mdi-bell-outline"></i>
                      </div>
                      <p class="notify-details">Updates
                          <small class="text-muted">There are 2 new updates available</small>
                      </p>
                  </a>

                  <!-- item-->
                  <a href="javascript:void(0);" class="dropdown-item notify-item">
                      <div class="notify-icon bg-danger">
                          <i class="mdi mdi-account-plus"></i>
                      </div>
                      <p class="notify-details">New user
                          <small class="text-muted">You have 10 unread messages</small>
                      </p>
                  </a>

                  <!-- item-->
                  <a href="javascript:void(0);" class="dropdown-item notify-item">
                      <div class="notify-icon bg-info">
                          <i class="mdi mdi-comment-account-outline"></i>
                      </div>
                      <p class="notify-details">Caleb Flakelar commented on Admin
                          <small class="text-muted">4 days ago</small>
                      </p>
                  </a>

                  <!-- item-->
                  <a href="javascript:void(0);" class="dropdown-item notify-item">
                      <div class="notify-icon bg-secondary">
                          <i class="mdi mdi-heart"></i>
                      </div>
                      <p class="notify-details">Carlos Crouch liked
                          <b>Admin</b>
                          <small class="text-muted">13 days ago</small>
                      </p>
                  </a>
              </div>

              <!-- All-->
              <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                  See all Notification
                  <i class="fi-arrow-right"></i>
              </a>

          </div>
      </li>

      {{-- <li class="dropdown notification-list">
          <a class="nav-link dropdown-toggle  waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
              <i class="mdi mdi-email noti-icon"></i>
              <span class="badge badge-danger rounded-circle noti-icon-badge">8</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-lg">

              <!-- item-->
              <div class="dropdown-item noti-title">
                  <h5 class="font-16 m-0">
                      <span class="float-right">
                          <a href="#" class="text-dark">
                              <small>Clear All</small>
                          </a>
                      </span>Messages
                  </h5>
              </div>

              <div class="slimscroll noti-scroll">

                  <div class="inbox-widget">
                      <a href="#">
                          <div class="inbox-item">
                              <div class="inbox-item-img"><img src="assets/images/users/avatar-1.jpg" class="rounded-circle" alt=""></div>
                              <p class="inbox-item-author">Chadengle</p>
                              <p class="inbox-item-text text-truncate">Hey! there I'm available...</p>
                          </div>
                      </a>
                      <a href="#">
                          <div class="inbox-item">
                              <div class="inbox-item-img"><img src="assets/images/users/avatar-2.jpg" class="rounded-circle" alt=""></div>
                              <p class="inbox-item-author">Tomaslau</p>
                              <p class="inbox-item-text text-truncate">I've finished it! See you so...</p>
                          </div>
                      </a>
                      <a href="#">
                          <div class="inbox-item">
                              <div class="inbox-item-img"><img src="assets/images/users/avatar-3.jpg" class="rounded-circle" alt=""></div>
                              <p class="inbox-item-author">Stillnotdavid</p>
                              <p class="inbox-item-text text-truncate">This theme is awesome!</p>
                          </div>
                      </a>
                      <a href="#">
                          <div class="inbox-item">
                              <div class="inbox-item-img"><img src="assets/images/users/avatar-4.jpg" class="rounded-circle" alt=""></div>
                              <p class="inbox-item-author">Kurafire</p>
                              <p class="inbox-item-text text-truncate">Nice to meet you</p>
                          </div>
                      </a>
                      <a href="#">
                          <div class="inbox-item">
                              <div class="inbox-item-img"><img src="assets/images/users/avatar-5.jpg" class="rounded-circle" alt=""></div>
                              <p class="inbox-item-author">Shahedk</p>
                              <p class="inbox-item-text text-truncate">Hey! there I'm available...</p>

                          </div>
                      </a>
                  </div> <!-- end inbox-widget -->

              </div>
              <!-- All-->
              <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                  See all Messages
                  <i class="fi-arrow-right"></i>
              </a>

          </div>
      </li> --}}

      <li class="dropdown notification-list mr-3">
          <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
              <img src="{{asset('admin/assets/images/users/avatar-1.jpg')}}" alt="user-image" class="rounded-circle">
              <span class="d-none d-sm-inline-block ml-1">{{substr(Auth::user()->firstname, 0, 1)}} . {{Auth::user()->lastname}}</span>
              <span class="d-none d-sm-inline-block ml-1"><i class="mdi mdi-chevron-down"></i> </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
              <!-- item-->
              <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome !</h6>
              </div>

              <!-- item-->
              <a href="javascript:void(0);" class="dropdown-item notify-item">
                  <i class="mdi mdi-account-outline"></i>
                  <span>Profile</span>
              </a>

              <!-- item-->
              <a href="{{route('admin.setting.get.change.password')}}" class="dropdown-item notify-item">
                  <i class="mdi mdi-settings-outline"></i>
                  <span>Settings</span>
              </a>

              <div class="dropdown-divider"></div>

              <!-- item-->
              <a href="{{route('auth.logout')}}" class="dropdown-item notify-item">
                  <i class="mdi mdi-logout-variant"></i>
                  <span>Logout</span>
              </a>

          </div>
      </li>

  </ul>

  <!-- LOGO -->
  <div class="logo-box">
      <a href="{{route('admin.dashboard')}}" class="logo text-center">
          <span class="logo-lg">
              <img src="{{asset('admin/assets/images/logo-main.png')}}" alt="" width="180">
              <!-- <span class="logo-lg-text-light">Zircos</span> -->
          </span>
          <span class="logo-sm">
              <!-- <span class="logo-sm-text-dark">Z</span> -->
              <img src="{{asset('admin/assets/images/favicon-icon.png')}}" alt="" height="30">
          </span>
      </a>
  </div>

  <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
      <li>
          <button class="button-menu-mobile waves-effect">
              <i class="mdi mdi-menu"></i>
          </button>
      </li>

      <li class="d-none d-sm-block">
          <form class="app-search">
              <div class="app-search-box">
                  <div class="input-group" >
                      <input type="text" class="form-control" placeholder="Search...">
                      <div class="input-group-append" style="height: 37.5px;">
                          <button class="btn" type="submit">
                              <i class="fas fa-search"></i>
                          </button>
                      </div>
                  </div>
              </div>
          </form>
      </li>
  </ul>
</div>
