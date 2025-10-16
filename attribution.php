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
	$sql = $con->query("SELECT * FROM users WHERE matricule = '$matricule' AND (role = 'admin' OR role = 'rh')");
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
     
    </style>
  <?php 
    $notice="";
    if(isset($_POST['safeIn']))
    {
      $user= $_POST['utilisateur'];
      $nomPrenom = $_POST['nomPrenom'];
      $matricule = $_POST['matricule'];
      $statut = $_POST['statut'];
      $direction = $_POST['direction'];
      $typeMateriel = $_POST['materiel'];
      $fabricant = $_POST['fabricant'];
      $model = $_POST['model'];
      $dateAchat = $_POST['dateAchat'];
      $serialNumber = $_POST['serialNumber'];
      $numeroCommande = $_POST['numeroCommande'];
      $typeIntervention = $_POST['typeIntervention'];
      $dateIntervention = $_POST['date'];
      $historique = $_POST['historique'];;//revoir cette partie du code
      $technician = "HELPDESK";//revoir cette partie du code
      $userValidation = "NON";

      
// Filtre pour verifier si l'element existe deja
      $req = mysqli_query($con, "SELECT * FROM attribution WHERE serialNumber = '$serialNumber' and (interventionType='Nouvelle Attribution' OR interventionType='Reaffectation' OR interventionType='Mis au rebut')");
    //  $line = $req -> fetch_assoc();
      //$note = $line['matricule'];
      
      if ($req -> num_rows > 0) {
        $notify = "<div class='alert alert-danger'><center>This attribution is already done:".$con->error."</center></div>";
        //echo $notify;
        mysqli_query($con, "UPDATE attribution SET name = '".$nomPrenom."', statut = '".$statut."', matricule = '".$matricule."', type = '".$typeMateriel."', direction = '".$direction."', model = '".$model."', purchaseDate = '".$dateIntervention."', interventionType = '".$typeIntervention."',
          installationDate = '".$dateIntervention."', historique = '".$historique."' WHERE serialNumber = '".$serialNumber."' ");
          $notice = "<div class='alert alert-success'><center>Successfully Modified</center></div>";
          echo $notice;
      }else{  
       mysqli_query($con, "INSERT INTO attribution (name,matricule,statut,direction,type,fabricant,model,serialNumber,purchaseDate,commandNumber,installationDate,interventionType,utilisateur,historique,technician)
      VALUES ('$nomPrenom','$matricule','$statut','$direction','$typeMateriel','$fabricant','$model','$serialNumber','$dateAchat','$numeroCommande','$dateIntervention','$typeIntervention','$user','$historique','$technician')");
        $notice = "<div class='alert alert-success'><center>Successfully Saved</center></div>";
        echo $notice;
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
  <!-- Bootstrap CSS -->
  
  
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        .form-inline {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Ensures elements are spaced out */
        }
        .form-control {
            margin-right: 10px; /* Adjust spacing as needed */
        }
        .form-group {
            margin-bottom: 0; /* Remove bottom margin for alignment */
        }
		

    </style>
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
    <a href="#" class="brand-link">
      
      <!-- Nom de l'application a definir ici -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../img/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $username; ?></a>
        </div>
      </div>

    <!-- Sidebar -->
    <div class="sidebar">

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
            <a href="attribution.php" class="nav-link active">
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
                  <a href="site.php" class="nav-link"><i class="far fa-circle nav-icon"></i>
                  <p>
                  <?php 
                      $count = $con -> query("SELECT count(*) FROM livraison WHERE statut = 'Approved by SIOP' AND (typeMateriel='Routeur' OR typeMateriel='Telephone' OR typeMateriel='Switch')");
                      $row_Stock_ = $count -> fetch_assoc(); 
                  ?> 
                  Réseau <?php echo $row_Stock_['count(*)'];?></p></a>
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
            <a href="rebuts.php" class="nav-link">
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
  <div class="card card-outline card-primary">
		<div class="container mt-4">
		  <div class="row align-items-center">
			  <!-- Export Button -->
			  <div class="col-md-2">
				  <a href="export.php">
					  <button type="button" class="btn btn-success btn-sm">
						  <i class="fa fa-download"></i> Exporter
					  </button>
				  </a>
			  </div>

			  <!-- Filter Form -->
			  <div class="col-md-6">
				  <form id="filterForm" action="" method="get" class="form-inline">
					  <input type="date" name="date" value="<?= isset($_GET['date']) == true ? $_GET['date']: ''  ?>" class="form-control mr-2" placeholder="Date" required>
					  <select name="status" class="form-control" required>
						  <option value="">Select Status</option>
						  <option value="Nouvelle Attribution"<?= isset($_GET['interventionType']) == true ? $_GET['interventionType'] == 'Nouvelle Attribution': '' ?>>Nouvelle Attribution</option>
						  <option value="Reaffectation"<?= isset($_GET['interventionType']) == true ? $_GET['interventionType'] == 'Reaffectation': '' ?>>Réaffectation</option>
					  </select>
					  <button type="submit" class="btn btn-primary">Filter</button>
					  <button type="button" class="btn btn-danger" onclick="resetForm()">Reset</button>
				  </form>
			  </div>

			  <!-- Search Filter Form -->
			  <div class="col-md-4">
				  <form action="" method="get" class="form-inline float-right">
					  <input type="search" name="keywords" placeholder="Filtrer un No de série ici..." class="form-control" style="font-size: 11pt;">
					  <input type="submit" name="valider" value="Rechercher" class="btn btn-primary" style="font-size: 11pt;">
				  </form>
			  </div>
		  </div>
		</div>

	<br>
	
		
			<div class="content-wrapper">
			<div class="tableBox">
				<table id="dataTable" class="table table-bordered table-striped" style="z-index: -1">
				
					<colgroup>
						<col width="5%">
						<col width="15%">
						<col width="20%">
						<col width="30%">
						<col width="20%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr class="">
							<th>#</th>
							<th>Name</th>
							<th>Matricule</th>
							<th>Statut</th>
							<th>Direction</th>
							<th>Materiel</th>
							<th>Fabricant</th>
							<th>Modele</th>
							<th>SerialNumber</th>
							<th>CommandNumber</th>
							<th>DateAttribution</th>
							<th>Intervention</th>
							<th>Historique</th>
							<th>Decharge</th>
							<th>Technician</th>
							<th>Action</th>
						</tr>
					</thead>
			  <?php
			  //  !empty(trim($_GET['keywords']))
			  if(isset($_GET['valider'])){
				$valider = $_GET['valider'];
				$keywords = $_GET['keywords'];
				$words = explode(" ",trim($keywords));
				for($i=0;$i<count($words);$i++)
				$kw[$i]="serialNumber like'%".$words[$i]."%'";
				$res=$con->query("SELECT * FROM attribution WHERE ".implode(" or ",$kw));

				$i=0;
			   
				while($row = $res->fetch_assoc())
				{
					$i=$i+1;
					$id=$row['id'];
			  ?>
					<tbody>
						
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $row['name']; ?></td>
							<td><?php echo $row['matricule']; ?></td>
							<td><?php echo $row['statut']; ?></td>
							<td><?php echo $row['direction']; ?></td>
							<td><?php echo $row['type']; ?></td>
							<td><?php echo $row['fabricant']; ?></td>
							<td><?php echo $row['model']; ?></td>
							<td><?php echo $row['serialNumber']; ?></td>
							<td><?php echo $row['commandNumber']; ?></td>
							<td><?php echo $row['installationDate']; ?></td>
							<td><?php echo $row['interventionType']; ?></td>
							<td><?php echo $row['historique']; ?></td>
							<td><span class="badge badge-success"><?php echo $row['userValidation']; ?></span></td>
							<td><?php echo $row['technician']; ?></td>
							<td align="center">
								<button type="button" class="btn btn-success btn-sm dropdown-toogle dropdown-icon" data-toggle="dropdown">
									Action
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu" role="menu">
								  <a class="dropdown-item" href="view.php?item=<?php echo $row['id'] ?>"><span class="fa fa-eye text-primary"></span> Voir plus</a>
									<div class="dropdown-divider"></div>
								  <a class="dropdown-item" href="envoi_au_rebut.php?item=<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Mettre au rebut</a>
								  <div class="dropdown-divider"></div>
								</div>
							</td>
						</tr>
						<?php
						}
						
						}else{
						  $i=0;
						  $array = $con->query("SELECT * FROM attribution WHERE (userValidation ='Approved' OR userValidation ='') 
						  AND (interventionType ='Nouvelle Attribution' OR interventionType='Reaffectation' OR interventionType='Remplacement') ORDER BY id DESC");
						  
						  while($row=$array->fetch_assoc()){
							$i=$i+1;
							$id = $row['id'];
						  
						?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $row['name']; ?></td>
							<td><?php echo $row['matricule']; ?></td>
							<td><?php echo $row['statut']; ?></td>
							<td><?php echo $row['direction']; ?></td>
							<td><?php echo $row['type']; ?></td>
							<td><?php echo $row['fabricant']; ?></td>
							<td><?php echo $row['model']; ?></td>
							<td><?php echo $row['serialNumber']; ?></td>
							<td><?php echo $row['commandNumber']; ?></td>
							<td><?php echo $row['installationDate']; ?></td>
							<td><?php echo $row['interventionType']; ?></td>
							<td><?php echo $row['historique']; ?></td>
							<td><span class="badge badge-success"><?php echo $row['userValidation']; ?></span></td>
							<td><?php echo $row['technician']; ?></td>
							<td align="center">
								<button type="button" class="btn btn-success btn-sm dropdown-toogle dropdown-icon" data-toggle="dropdown">
									Action
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu" role="menu">
								  <a class="dropdown-item" href="view.php?item=<?php echo $row['id'] ?>"><span class="fa fa-eye text-primary"></span> Voir plus</a>
									<div class="dropdown-divider"></div>
									  <a class="dropdown-item" href="recycler.php?item=<?php echo $row['id'] ?>" data-id=""><span class="fa fa-recycle text-success"></span> Recycler</a>
									  <div class="dropdown-divider"></div>
									  
									</div>
								</div>
							</td>
						</tr>

						<?php
						}
				
					  }
					?>
					</tbody>

				</table>
			</div>
		</div>
		</div>
		</div>
	</div>
  </div>
  
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
                  <label for="some" class="col-form-label">Nom et Prenom</label>
                  <input type="text" name="nomPrenom" class="form-control" id="some" required>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Matricule</label>
                  <input type="text" name="matricule" class="form-control" id="some" required>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Statut</label>
                  <select class="form-control" name="statut" required>
                    <option value="permanent">Permanent</option>
                    <option value="interimaire">Interimaire</option>
                    <option value="stagiaire">Stagiaire</option>
                  </select>
                </div>
                <?php
                  $tableau = $con->query("SELECT * FROM direction");
                  $row_tableau = mysqli_fetch_array($tableau);
                  ?>
                <div class="form-group">
                  <label for="some" class="col-form-label">Direction</label>
                  <select class="form-control" name="direction" required>
                    <option selected disabled>Selection ta Direction</option>
                    <?php 
                    while($row_tableau = mysqli_fetch_array($tableau)){?>
                    <option value="<?php echo $row_tableau[0];?>"><?php echo $row_tableau[1]?></option>
                    <?php };?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Type de materiel</label>
                  <input type="text" name="materiel" class="form-control" id="some" required>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Fabricant</label>
                  <select class="form-control" name="fabricant" required>
                    <option value="HP">HP</option>
                    <option value="Dell">Dell</option>
                    <option value="Cisco">Cisco</option>
                    <option value="Microsoft">Microsoft</option>
                    <option value="Huawei">Huawei</option>
                    <option value="Samsung">Samsung</option>
                    <option value="Iphone">Iphone</option>
                    <option value="Jabra">Jabra</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Model</label>
                  <input type="text" name="model" class="form-control" id="some" required>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Date Achat</label>
                  <input type="date" name="dateAchat" class="form-control" id="some" required>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Numero de serie</label>
                  <input type="text" name="serialNumber" class="form-control" id="some" required>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Numéro de commande</label>
                  <input type="text" name="numeroCommande" class="form-control" id="some" required>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Date intervention</label>
                  <input type="date" name="date" class="form-control" id="some" required>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Type intervention</label>
                  <select class="form-control" name="typeIntervention" required>
                    <option value="Nouvelle Attribution">Nouvelle Attribution</option>
                    <option value="Reaffectation">Reaffectation</option>
                    <option value="Recycle">recycle</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Utilisateur</label>
                  <input type="number" name="utilisateur" class="form-control" id="some" value="1" required>
                </div>
                <div class="form-group">
                  <label for="some" class="col-form-label">Historique</label>
                  <input type="text" name="historique" class="form-control" id="some" required>
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
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

<script type="text/javascript">
  $(document).ready(function(){
    $("#fetchval").on('change', function(){
      var value = $(this).val();
      //alert(value);
      $.ajax({
        url:"fetch.php",
        type:"POST",
        data:'request=' + value;
        beforeSend:function(){
          $(".container").html("<span>Working...</span>");
        },
        success:function(data){
          $(".container").html*(data)
        }
      });
    });
  });
</script>
<script>
function resetForm() {
    document.getElementById('filterForm').reset();
}
</script>
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