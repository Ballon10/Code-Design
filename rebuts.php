<?php
session_start();

// Check if session variables are set
if (isset($_SESSION['user'])) {
  $username = $_SESSION['user'];
  $display_name = $_SESSION['name'];
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MyASSET</title>
  <link rel="icon" href="../img/logo.png" />
  <?php require "../assets/autoloader.php" ?>
    <style type="text/css">
      <?php include '../css/customStyle.css' ?>
    </style>
  <?php 
    $notice="";
    if(isset($_GET['item']))
    {
      $item = $_GET['item'];
      $req = $con->query("SELECT * FROM attribution WHERE id = $item");
      $reb = $req -> fetch_assoc();

      $reference = $reb['reference'];
      $nomPrenom = $reb['name'];
      $matricule = $reb['matricule'];
      $statut = $reb['statut'];
      $direction = $reb['direction'];
      $typeMateriel = $reb['type'];
      $fabricant = $reb['fabricant'];
      $model = $reb['model'];
      $dateAchat = $reb['purchaseDate'];
      $serialNumber = $reb['serialNumber'];
      $numeroCommande = $reb['commandNumber'];
      $typeIntervention = "Mis au rebut";
      $dateDepart = date('Y-m-d h:s:i:sa');
      $observations = "Obsolescence Materielle";
	  
      // Filtre pour verifier si l'element existe deja
        $req1 = $con -> prepare("SELECT * FROM rebus WHERE serialNumber = ? ");
		$req1->bind_param("s",$serialNumber);
		$req1->execute();
		
      if ($req1 -> num_rows > 0) {
        $show = "<div class='alert alert-danger'><center>This item is already exist".$con->error."</center></div>";
        echo $show;
      }
     
        else{ 
			$req1->close();
        $req2 = $con->prepare("UPDATE attribution SET interventionType = '".$typeIntervention."' WHERE serialNumber = ? and id = '$_GET[item]'");
        $req2->bind_param("s",$serialNumber);
		$req2->execute();
		$req2->close();
		
		$stmt = $con->prepare("INSERT INTO rebus (nomPrenom,matricule,statut,direction,typeMateriel,serialNumber,fabricant,model,dateAchat,dateDepart,observations,reference) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
        
		if($stmt === false){
			die("Erreur de preparation : " . $con->error);
		}
		
		$stmt->bind_param("ssssssssssss", $nomPrenom,$matricule,$statut,$direction,$typeMateriel,$serialNumber,$fabricant,$model,$dateAchat,$dateDepart,$observations,$reference);
        
		if($stmt->execute()){
			$notice = "<div class='alert alert-success'><center>Successfully Saved</center></div>";  
			echo $notice;
		}else{
			echo "Erreur d'execution : " . $stmt->error;
		}
		
		$stmt->close();
      }
    
      }
	  
     
    ?>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../img/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo ucfirst($_SESSION['user'])?></a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="../dashboard/dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
            
          </li>
          <li class="nav-item">
            <a href="attribution.php" class="nav-link">
              <i class="nav-icon fas fa-laptop"></i>
              <p>
              <?php 
                  $count = $con -> query("SELECT count(*) FROM attribution WHERE interventionType='Reaffectation' OR interventionType='Remplacement' OR interventionType='Nouvelle Attribution'");
                  $rowAtt = $count -> fetch_assoc(); 
              ?>
                Attribution <?php echo $rowAtt['count(*)'];?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="stocks_siop.php" class="nav-link">
            <i class="nav-icon fas fa-warehouse"></i>
              <p>
                Materiels
                
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="reaffectable.php" class="nav-link"><i class="far fa-circle nav-icon"></i>
                  <p>
                  <?php 
                      $count = $con -> query("SELECT count(*) FROM attribution WHERE interventionType='Recycle'");
                      $rowReaff = $count -> fetch_assoc(); 
                  ?>  
                  Reacffectable <?php echo $rowReaff['count(*)'];?></p></a>
                </li>
                <li class="nav-item">
                  <a href="stocks_siop.php" class="nav-link"><i class="far fa-circle nav-icon"></i>
                  <p>
                  <?php 
                      $count = $con -> query("SELECT count(*) FROM livraison WHERE statut = 'Approved by SIOP'");
                      $row_Stock_ = $count -> fetch_assoc(); 
                  ?> 
                  A affecter <?php echo $row_Stock_['count(*)'];?></p></a>
                </li>
                <li class="nav-item">
                  <a href="stocks.php" class="nav-link"><i class="far fa-circle nav-icon"></i>
                  <p>
                  <?php 
                      $count = $con -> query("SELECT count(*) FROM livraison WHERE statut = 'Envoyé SIOP'");
                      $row_Entree = $count -> fetch_assoc(); 
                  ?>   
                  Sortie Economat <?php echo $row_Entree['count(*)'];?></p></a>
                </li>
              </ul>
          </li>
          <li class="nav-item">
            <a href="../admin/livraison.php" class="nav-link">
            <i class="nav-icon fas fa-dolly"></i>
              <p>
                Livraison
              </p>
            </a>
          </li>        
          <li class="nav-item">
            <a href="rebus/rebuts.php" class="nav-link active">
            <i class="nav-icon 	fas fa-archive"></i>
              <p>
              Rebuts
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
            <a href="logout.php" class="nav-link">
              <i class="fa fa-power-off fa-fw"></i>
              <p>
                Deconnexion
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <style type="text/css">
    <?php include '../css/code.css' ?>
      
  </style>
		<br>
  <div class="content-wrapper">
    <div class="row">
	    <div class="col-lg-12">
            <a href="export_rebus.php"><button type="button" class="btn btn-success btn-sm pull right" data-toggle="modal" data-target="" style="margin-right: 2px;">
				<i class="fa fa-download"></i>Exporter</button></a>
		</div>
    </div>
	   <br>
    <div class="tableBox">
        <table id="dataTable" class="table table-bordered table-striped" style="z-index: -1">
            <thead>
                <th>#</th>
                <th>TypeMateriel</th>
                <th>Fabricant</th>
                <th>Modele</th>
                <th>SerialNumber</th>
                <th>DateDepart</th>
				<th>observations</th>
                <th>Action</th>
            </thead>

            <tbody>
                <?php
                $i=0;
                $ArrayAttr = $con->query("SELECT * FROM rebus ORDER BY id DESC");
                while($row = $ArrayAttr->fetch_assoc())
                {
                    $i=$i+1;
                    $id=$row['id'];
                
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    
                    <td><?php echo $row['typeMateriel']; ?></td>
                    <td><?php echo $row['fabricant']; ?></td>
                    <td><?php echo $row['model']; ?></td>
                    <td><?php echo $row['serialNumber']; ?></td>
                    <td><?php echo $row['dateDepart']; ?></td>
					<td><?php echo $row['observations']; ?></td>
                    <td align="center">
                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toogle dropdown-icon" data-toggle="dropdown">
                            Action
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                          <a class="dropdown-item" href="edit.php?item=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span>Transferer</a>
                          <div class="dropdown-divider"></div>
                          
                        </div>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>

        </table>

    </div>
  </div>
  <?php
      $CatAttr = "All Attributions";
      $ArrayAttr = $con->query("SELECT * FROM attribution ORDER BY id DESC");

  ?>
    <div id="addIn" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" close="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Formulaire d'attribution</h4>
          </div>
          <div class="modal-title">
            <form action="" method="post" enctype="multipart/form-data">
              <div class="" style="width: 77%;margin: auto;"> 
                <div class="form-group">
                  <label for="some" class="col-form-label">Localisation depart</label>
                  <input type="text" name="localisationDep" class="form-control" id="some" required>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Localisation arrivee</label>
                  <input type="text" name="localisationArr" class="form-control" id="some" required>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Quantite</label>
                  <input type="numeric" name="quantite" class="form-control" id="some" required>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Responsable Depart</label>
                  <input type="text" name="responsableDep" class="form-control" id="some" required>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Responsable Arrivee</label>
                  <input type="text" name="responsableArr" class="form-control" id="some" required>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Date arrivee</label>
                  <input type="date" name="date" class="form-control" id="some" required>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Observations</label>
                  <input type="text" name="observation" class="form-control" id="some" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary" name="safeIn">Continuer</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
    
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2024-2025 <a href="#"></a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.js"></script>
</body>
</html>
<script>
  function formToggle(ID){
    var element = document.getElementById(ID);
    if(element.style.display === "none"){
      element.style.display = "block";

    }else{
      element.style.display = "none";
    }
  }
</script>
<script>
  var timeoutInMinutes = 5;
var timeoutId;

function startTimer() {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(logoutUser, timeoutInMinutes * 60 * 1000); // Convert to milliseconds
}

function resetTimer() {
    clearTimeout(timeoutId);
    startTimer();
}

// Start the timer when the user interacts with the page
document.addEventListener('mousemove', resetTimer);
document.addEventListener('keypress', resetTimer);

function logoutUser() {
    // Redirect to logout script or clear session
    window.location.href = 'logout.php';
}

// Start the timer when the page loads
startTimer();

</script>