    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-car-side"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Car Rental</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Nav Item - Manage Cars -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCars"
          aria-expanded="true" aria-controls="collapseCars">
          <i class="fas fa-fw fa-car"></i>
          <span>Manage Cars</span>
        </a>
        <div id="collapseCars" class="collapse" aria-labelledby="headingCars" data-parent="#accordionSidebar">
          <div class="bg-collapse py-2 collapse-inner rounded">
            <a class="collapse-item" href="add_vehical.php"><i class="fas fa-plus-circle mr-2"></i>Add Vehicle</a>
            <a class="collapse-item" href="view_vehical.php"><i class="fas fa-list mr-2"></i>View Vehicles</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Bookings -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBookings"
          aria-expanded="true" aria-controls="collapseBookings">
          <i class="fas fa-fw fa-calendar-check"></i>
          <span>Bookings</span>
        </a>
        <div id="collapseBookings" class="collapse" aria-labelledby="headingBookings" data-parent="#accordionSidebar">
          <div class="bg-collapse py-2 collapse-inner rounded">
            <a class="collapse-item" href="reservations.php"><i class="fas fa-calendar-plus mr-2"></i>Reservations</a>
            <a class="collapse-item" href="payments.php"><i class="fas fa-credit-card mr-2"></i>Payments</a>
            <a class="collapse-item" href="customers.php"><i class="fas fa-users mr-2"></i>Customers</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>