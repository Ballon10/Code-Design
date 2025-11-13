<?php
session_start();
  
// Check if session variables are set
if (isset($_SESSION['user'])) {
  $username = $_SESSION['user'];
  $matricule = $_SESSION['name'];

} else {
  // Handle case where session variables are not set
  header('location:../login.php');
}
?>
<?php require "../assets/function.php" ?>
<?php require '../assets/db.php'; ?>

<?php
	//session_start();
	$sql = $con->query("SELECT * FROM users WHERE matricule = '$matricule' AND role = 'admin'");
	if($sql->num_rows > 0){

	}else{
	header('location:../login.php');
	}
?>
<?php 
	//Technicien 1
    $Technicien1 = $con -> query("SELECT count(*) FROM attribution WHERE technician='Souwina Basile'");
    $row_Technicien1 = $Technicien1 -> fetch_assoc(); 

	//Technicien 2
    $Technicien2 = $con -> query("SELECT count(*) FROM attribution WHERE technician='Christian Mekoundi'");
    $row_Technicien2 = $Technicien2 -> fetch_assoc(); 
	
	//Technicien 3
    $Technicien3 = $con -> query("SELECT count(*) FROM attribution WHERE technician='Nouredine Ahmadou'");
    $row_Technicien3 = $Technicien3 -> fetch_assoc(); 

	//Technicien 4
    $Technicien4 = $con -> query("SELECT count(*) FROM attribution WHERE technician='Radjil Leila'");
    $row_Technicien4 = $Technicien4 -> fetch_assoc(); 
	
	//Technicien 5
    $Technicien5 = $con -> query("SELECT count(*) FROM attribution WHERE technician='Jordan Louocdom'");
    $row_Technicien5 = $Technicien5 -> fetch_assoc(); 
	
	//Technicien 6
    $Technicien6 = $con -> query("SELECT count(*) FROM attribution WHERE technician='Bouhari Aboubakar'");
    $row_Technicien6 = $Technicien6 -> fetch_assoc(); 
	
	//Technicien 7
    $Technicien7 = $con -> query("SELECT count(*) FROM attribution WHERE technician='Aliou Djibo'");
    $row_Technicien7 = $Technicien7 -> fetch_assoc(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MyASSET | Dashboard</title>
  <link rel="icon" href="../img/logo.png" />

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/img.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Christian Mekoundi
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/img.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nouredine Ahmadou
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/img.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Radjil Leila
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
      <img src="../img/logo.png" alt="AdminLTE Logo" class="brand-image img-square elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SOCIETE GENERALE</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../img/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo ucfirst($_SESSION['user'])?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
            <a href="dashboard.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
            
          </li>
          <li class="nav-item">
            <a href="../pages/attribution.php" class="nav-link">
              <i class="nav-icon fas fa-laptop"></i>
              <p>
                Attribution
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../pages/stocks.php" class="nav-link">
            <i class="nav-icon fas fa-warehouse"></i>
              <p>
                Stocks
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../admin/livraison.php" class="nav-link">
            <i class="nav-icon 	fas fa-dolly"></i>
              <p>
              Livraison
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../pages/rebuts.php" class="nav-link">
            <i class="nav-icon 	fas fa-archive"></i>
              <p>
              Rebuts
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../admin/categorie.php" class="nav-link">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                Profiles
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../users/users.php" class="nav-link">
            <i class="nav-icon 	fas fa-user"></i>
              <p>
                Mon compte
              </p>
            </a>
          </li> 
          <li class="nav-item">
            <a href="../pages/logout.php" class="nav-link">
              <i class="fa fa-power-off fa-fw"></i>
              <p>
                Deconnexion
              </p>
            </a>
          </li>

        </ul>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-server"></i></span>
              <?php 
                  $reqStock = $con -> query("SELECT count(*) FROM livraison WHERE statut = 'Approved by SIOP'");
                  $rowStock = $reqStock -> fetch_assoc(); 

              ?>
              <div class="info-box-content">
                <span class="info-box-text">Stock SIOP</span>
                <span class="info-box-number"><?php echo $rowStock['count(*)'];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-warehouse"></i></span>
              <?php 
                  $reqIncident = $con -> query("SELECT count(*) FROM livraison WHERE etapeValidation = 'approuvé' AND statut = ''");
                  $rowIncident = $reqIncident -> fetch_assoc(); 

              ?>
              <div class="info-box-content">
                <span class="info-box-text">Stock Economat</span>
                <span class="info-box-number"><?php echo $rowIncident['count(*)'];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-laptop"></i></span>
              <?php 
                  $req = $con -> query("SELECT count(*) FROM attribution");
                    //("SELECT * FROM attribution WHERE matricule = '$matricule' AND serialNumber = '$serialNumber' AND statut = '$statut' AND direction = '$direction' AND fabricant = '$fabricant' AND type = '$typeMateriel' AND name = '$nomPrenom' AND model = '$model' AND interventionType = '$typeIntervention' AND commandNumber = '$numeroCommande' AND purchaseDate = '$dateAchat' AND historique = '$historique'")
                   $row = $req -> fetch_assoc(); 

              ?>
              <div class="info-box-content">
                <span class="info-box-text">Mouvements</span>
                <span class="info-box-number"><?php echo $row['count(*)'];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-trash-alt"></i></span>
              <?php 
                  $req1 = $con -> query("SELECT count(*) FROM rebus");
                  $row1 = $req1 -> fetch_assoc(); 

              ?>
              <div class="info-box-content">
                <span class="info-box-text">Rebuts</span>
                <span class="info-box-number"><?php echo $row1['count(*)'];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Monthly Recap Report</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="#" class="dropdown-item">Action</a>
                      <a href="#" class="dropdown-item">Another action</a>
                      <a href="#" class="dropdown-item">Something else here</a>
                      <a class="dropdown-divider"></a>
                      <a href="#" class="dropdown-item">Separated link</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <p class="text-center">
                      <strong>Attributions: 1 Jan, 2024 - 30 Jul, 2024</strong>
                    </p>

                    <div class="chart">
                      <!-- Sales Chart Canvas -->
                      <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <p class="text-center">
                      <strong>Attribution by Team members</strong>
                    </p>

                    <div class="progress-group">
                      Souwina Basile
                      <span class="float-right"><b>160</b>/200</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width: 80%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->

                    <div class="progress-group">
                      Christian Mekoundi
                      <span class="float-right"><b>310</b>/400</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" style="width: 75%"></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      <span class="progress-text">
					  Nouredine Ahmadou</span>
                      <span class="float-right"><b>480</b>/800</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: 60%"></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      Radjil Leila
                      <span class="float-right"><b>250</b>/500</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: 50%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->
                    <div class="progress-group">
                      Jordan Louocdom
                      <span class="float-right"><b>250</b>/500</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: 50%"></div>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <?php 
                  $reqLaptop = $con -> query("SELECT count(*) FROM attribution WHERE type='Laptop' OR type='LAPTOP'");
                  $rowLaptop = $reqLaptop -> fetch_assoc(); 

              ?>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                      <h5 class="description-header"><?php echo $rowLaptop['count(*)'];?></h5>
                      <span class="description-text">TOTAL LAPTOPS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <?php 
                        $reqDesktop = $con -> query("SELECT count(*) FROM attribution WHERE type='Desktop' OR type='DESKTOP' OR type='Unite Centrale' OR type='UNITE CENTRALE'");
                        $rowDesktop = $reqDesktop -> fetch_assoc(); 

                    ?>
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                      <h5 class="description-header"><?php echo $rowDesktop['count(*)'];?></h5>
                      <span class="description-text">TOTAL DESKTOPS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                      <h5 class="description-header">0</h5>
                      <span class="description-text">TOTAL IMPRIMANTES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block">
                    <?php 
                        $reqScanner = $con -> query("SELECT count(*) FROM attribution WHERE type='Scanner' OR type='SCANNER'");
                        $rowScanner = $reqScanner -> fetch_assoc(); 

                    ?>
                      <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                      <h5 class="description-header"><?php echo $rowScanner['count(*)'];?></h5>
                      <span class="description-text">TOTAL SCANNER</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-8">
            <!-- MAP & BOX PANE -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Visitors Report</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden">
                    <!-- Map will be created here -->
                    <div id="world-map-markers" style="height: 325px; overflow: hidden">
                      <div class="map"></div>
                    </div>
                  </div>
                  <div class="card-pane-right bg-success pt-2 pb-2 pl-4 pr-4">
                    <div class="description-block mb-4">
                      <div class="sparkbar pad" data-color="#fff">90,70,90,70,75,80,70</div>
                      <h5 class="description-header">8390</h5>
                      <span class="description-text">Visits</span>
                    </div>
                    <!-- /.description-block -->
                    <div class="description-block mb-4">
                      <div class="sparkbar pad" data-color="#fff">90,50,90,70,61,83,63</div>
                      <h5 class="description-header">30%</h5>
                      <span class="description-text">Referrals</span>
                    </div>
                    <!-- /.description-block -->
                    <div class="description-block">
                      <div class="sparkbar pad" data-color="#fff">90,50,90,70,61,83,63</div>
                      <h5 class="description-header">70%</h5>
                      <span class="description-text">Organic</span>
                    </div>
                    <!-- /.description-block -->
                  </div><!-- /.card-pane-right -->
                </div><!-- /.d-md-flex -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            

            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Attributions</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Matricule</th>
                      <th>Materiel</th>
                      <th>Status</th>
                      <th>SrNumber</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                $i=0;
                $ArrayAttr = $con->query("SELECT matricule, type, interventionType, serialNumber FROM attribution WHERE interventionType = 'Nouvelle Attribution' ORDER BY id DESC LIMIT 1");
                while($row = $ArrayAttr->fetch_assoc())
                {
                  
                
                ?>
                    <tr>
                      <td><a href="../pages/attribution.php"><?php echo $row['matricule']; ?></a></td>
                      <td><?php echo $row['type']; ?></td>
                      <td><span class="badge badge-success"><?php echo $row['interventionType']; ?></span></td>
                      <td>
                        <div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $row['serialNumber']; ?></div>
                      </td>
                    </tr>
                    <?php
                }
                ?>
                    <tr>
                    <?php
            
                $ArrayAttr = $con->query("SELECT matricule, type, interventionType, serialNumber FROM attribution WHERE interventionType = 'Reaffectation' ORDER BY id DESC LIMIT 1");
                while($row = $ArrayAttr->fetch_assoc())
                {
                ?>
                      <td><a href="../pages/attribution.php"><?php echo $row['matricule']; ?></a></td>
                      <td><?php echo $row['type']; ?></td>
                      <td><span class="badge badge-warning"><?php echo $row['interventionType']; ?></span></td>
                      <td>
                        <div class="sparkbar" data-color="#f39c12" data-height="20"><?php echo $row['serialNumber']; ?></div>
                      </td>
                    </tr>
                    <?php
                }
                ?>
                    <tr>
                    <?php
            
                $ArrayAttr = $con->query("SELECT matricule, type, interventionType, serialNumber FROM attribution WHERE interventionType = 'Mis au rebut' ORDER BY id DESC LIMIT 1");
                while($row = $ArrayAttr->fetch_assoc())
                {
                ?>
                      <td><a href="../pages/attribution.php"><?php echo $row['matricule']; ?></a></td>
                      <td><?php echo $row['type']; ?></td>
                      <td><span class="badge badge-danger"><?php echo $row['interventionType']; ?></span></td>
                      <td>
                        <div class="sparkbar" data-color="#f56954" data-height="20"><?php echo $row['serialNumber']; ?></div>
                      </td>
                    </tr>
                    <?php
                }
                ?>
                    <tr>
                    <?php
            
                    $ArrayAttr = $con->query("SELECT matricule, type, interventionType, serialNumber FROM attribution WHERE interventionType = 'Recycle' ORDER BY id DESC LIMIT 1");
                    while($row = $ArrayAttr->fetch_assoc())
                    {
				?>
                      <td><a href="../pages/attribution.php"><?php echo $row['matricule']; ?></a></td>
                      <td><?php echo $row['type']; ?></td>
                      <td><span class="badge badge-info"><?php echo $row['interventionType']; ?></span></td>
                      <td>
                        <div class="sparkbar" data-color="#00c0ef" data-height="20"><?php echo $row['serialNumber']; ?></div>
                      </td>
                    </tr>
                    
                    <?php
               }
                ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="../pages/attribution.php" class="btn btn-sm btn-info float-left">Add New</a>
                <a href="../pages/attribution.php" class="btn btn-sm btn-secondary float-right">View All</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-laptop"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Demande Laptop</span>
                <span class="info-box-number">5,200</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="fas fa-mobile-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Demande Telephone</span>
                <span class="info-box-number">92,050</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-briefcase"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Quantité Commandée</span>
                <span class="info-box-number">114,381</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="fas fa-archive"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Quantité Stockée</span>
                <span class="info-box-number">163,921</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->

            
            <!-- /.card -->

            <!-- PRODUCT LIST -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Details Attribution</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                    <?php 
                        $reqLaptop = $con -> query("SELECT count(*) FROM attribution WHERE type='Laptop' OR type='LAPTOP'");
                        $rowLaptop = $reqLaptop -> fetch_assoc(); 

                    ?>
                      <a href="javascript:void(0)" class="product-title">Laptop
                        <span class="badge badge-warning float-right"><?php echo $rowLaptop['count(*)'];?></span></a>
                      <span class="product-description">
                        Ordinateur Portable.
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                    <?php 
                        $reqDesktop = $con -> query("SELECT count(*) FROM attribution WHERE type='Desktop' OR type='DESKTOP' OR type='Unité Centrale' OR type='UNITE CENTRALE'");
                        $rowDesktop = $reqDesktop -> fetch_assoc(); 

                    ?>
                      <a href="javascript:void(0)" class="product-title">Unite Centrale
                        <span class="badge badge-info float-right"><?php echo $rowDesktop['count(*)'];?></span></a>
                      <span class="product-description">
                        Ordinateur de bureau.
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                    <?php 
                        $reqTelephone = $con -> query("SELECT count(*) FROM attribution WHERE type='Telephone' OR type='TELEPHONE' ");
                        $rowTelephone = $reqTelephone -> fetch_assoc(); 

                    ?>
                      <a href="javascript:void(0)" class="product-title">
                        Telephones<span class="badge badge-danger float-right">
                        <?php echo $rowTelephone['count(*)'];?>
                      </span>
                      </a>
                      <span class="product-description">
                        Equipement de télécommunication.
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                    <?php 
                        $reqCasque = $con -> query("SELECT count(*) FROM attribution WHERE type='Casque' OR type='CASQUE'");
                        $rowCasque = $reqCasque -> fetch_assoc(); 

                    ?>
                      <a href="javascript:void(0)" class="product-title">Casques
                        <span class="badge badge-success float-right"><?php echo $rowCasque['count(*)'];?></span></a>
                      <span class="product-description">
                        Casque - Outil de communication.
                      </span>
                    </div>
                  </li>
                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                    <?php 
                        $reqEcran = $con -> query("SELECT count(*) FROM attribution WHERE type='ECRAN' OR type='Ecran'");
                        $rowEcran = $reqEcran -> fetch_assoc(); 

                    ?>
                      <a href="javascript:void(0)" class="product-title">Ecran
                        <span class="badge badge-success float-right"><?php echo $rowEcran['count(*)'];?></span></a>
                      <span class="product-description">
                        Ordinateur de Bureau.
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                </ul>
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
                <a href="javascript:void(0)" class="uppercase">View All Attributions</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2024-2025 <a href="http://172.16.254.21:8080/forms/dashboard/dashboard.php">MyASSET</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
</body>
</html>
