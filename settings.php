<?php
session_start();

// Check if session variables are set
if (isset($_SESSION['user'])) {
  $username = $_SESSION['user'];
  $matriculee = $_SESSION['name'];

} else {
  // Handle case where session variables are not set
  header('location:../login.php');
}
?>
<?php require "../assets/function.php" ?>
<?php require '../assets/db.php'; ?>

<?php
//session_start();
$sql = $con->query("SELECT * FROM users WHERE matricule = '$matriculee' AND role = 'admin'");
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
      <?php include '../dist/css/style.css' ?>
	 
    </style>
  <?php 
  
  if(isset($_POST['safeProfile']))  {
    $nomPrenom = $_POST['nomPrenom'];
    $role = $_POST['role'];
    $matricule = $_POST['matricule'];
    $email = $_POST['email'];
	
	$req = $con->query("SELECT * FROM users WHERE matricule='$matricule'");
	if($req->num_rows > 0){
   
  }else{
	$sql = $con -> query("INSERT INTO users (id, nomPrenom, role, matricule, username, email) VALUES ('','$nomPrenom','$role','$matricule','$matricule','$email')");
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
            <a href="../dashboard/dashboard.php" class="nav-link ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="categorie.php" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
              <p>
                Categorie
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="profile.php" class="nav-link ">
            <i class="nav-icon fas fa-handshake"></i>
              <p>
                Profile
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="settings.php" class="nav-link active">
            <i class="nav-icon 	fas fa-cog"></i>
              <p>
              Habilitation
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
        <!-- Content Wrapper. Contains page content C:\wamp\www\forms\dist\css\code.css -->
  <style type="text/css">
    <?php include '../css/code.css' ?>
      
  </style>
    <br>
  <div class="content-wrapper">
    
    <div class="row">
      <div class="col-lg-12">
        
        <button type="button" class="btn btn-primary btn-sm pull right" data-toggle="modal" data-target="#addIn" style="margin-left: 2px;">
        <i class="fa fa-plus fa-fw"></i> Habilitation</button>
       
      </div>
     
    </div>
    <div class="tableBox">
        <table id="dataTable" class="table table-bordered table-striped" style="z-index: -1">
            <thead>
                <th>#</th>
                <th>Nom</th>
                <th>Role</th>
                <th>Matricule</th>
                <th>Email</th>
                <th>Action</th>
            </thead>

            <tbody>
                <?php
                $i=0;
                $stock = $con->query("SELECT * FROM users ORDER BY id DESC");
               
                if($stock->num_rows > 0){

         
                while($row = $stock->fetch_assoc())
                {
                    $i=$i+1;
                    $id=$row['id'];
                
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['nomPrenom']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td><?php echo $row['matricule']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td >
                   
                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toogle dropdown-icon" data-toggle="dropdown">
                            Action
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#approveModal"><span class="fa fa-eye text-primary"></span> voir</a>                         
                          <div class="dropdown-divider"></div>
						  <a class="dropdown-item" href="#" ><span class="fa fa-trash text-danger"></span> Supprimer</a>                         
                          <div class="dropdown-divider"></div>
                          
                        
                        </div>
                        
                    </td>
                    <!-- Fenêtre Approbation Modale -->
                    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="approveModalLabel">Confirmer l'Action</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" method="post">
                                  <div class="modal-body">
                                        <label for="some" class="col-form-label">Nom </label>
                                        <input type="text" name="nomPrenom" class="form-control" id="some" value="<?php echo $row['nomPrenom']; ?>" readonly>
                                  </div>
                                  <div class="modal-body">
                                        <label for="some" class="col-form-label">Matricule</label>
                                        <input type="text" name="matricule" class="form-control" id="some" value="<?php echo $row['matricule']; ?>" readonly>
                                  </div>
                                  <div class="modal-body">
                                        <label for="some" class="col-form-label">Role</label>
                                        <input type="text" name="role" class="form-control" id="some" value="<?php echo $row['role']; ?>" readonly>
                                  </div>
                                  <div class="modal-body">
                                        <label for="some" class="col-form-label">Email</label>
                                        <input type="text" name="email" class="form-control" id="some" value="<?php echo $row['email']; ?>" readonly>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                      <a class="btn btn-primary" href="#">Confirmer</a>
                                  </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    
                  </div>
                </tr>
                <?php
                }
                ?>
                  
                <?php
                }else{
                  ?>
                  <tr>
                    <td colspan="18">No records found</td>
                  </tr>
                  <?php
                }
                ?>
            </tbody>

        </table>

    </div>
    
  </div>
  <div id="addIn" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><h4 class="modal-title">Formulaire d'ajout validateur</h4></button>
                    
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="container">
                            <!-- Bloc 1: Informations Générales -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="validateur">Nom</label>
                                          <input type="text" id="search" class="form-control" name="nomPrenom" placeholder="Tapez pour rechercher..." required>
                                          <div id="suggestions" class="autocomplete-suggestions"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="email">Email Beneficiaire</label>
                                        <input type="text" id="email" class="form-control" name="email" placeholder="L'adresse email apparaîtra ici..." readonly>
                                      </div>
                                </div>
                            </div>

                            <!-- Bloc 2: Détails Article -->
                            <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="matricule">Matricule</label>
                                        <input type="text" id="sAMAccountName" class="form-control" name="matricule" placeholder="Le matricule apparaîtra ici..." readonly>
                                      </div>
                                  </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service">Role</label>
										<select name="role" id="" class="form-control" required>
                                          <option value="" disabled>Selectionner la categorie</option>
                                          <option value="log">LOG</option>
                                          <option value="rh">RH</option>
										  <option value="admin">ADMIN</option>
										  <option value="consultant">CONSULTANT</option>
                                        </select>
                                    </div>
                                </div>
                            </div>            
                <div class="modal-footer">
                    <a href="settings.php"><button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button></a>
                    <button type="submit" class="btn btn-primary" name="safeProfile">Continuer</button>
                </div>
                </form>
                </div>
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    $('#search').on('input', function() {
        var query = $(this).val();

        if (query.length > 2) { // Commencer la recherche après 3 caractères
            $.ajax({
                url: '../assets/ad_search.php',
                type: 'GET',
                data: { term: query },
                dataType: 'json',
                success: function(data) {
                    var suggestions = $('#suggestions');
                    suggestions.empty();

                    if (data.length > 0) {
                        data.forEach(function(item) {
                            suggestions.append(
                                '<div class="autocomplete-suggestion">' +
                                    '<div class="autocomplete-name">' + item.displayName + '</div>' +
                                    '<div class="autocomplete-email">' + item.email + '</div>' +
                                    '<div class="autocomplete-email">' + item.sAMAccountName + '</div>' +
                                '</div>'
                            );
                        });
                        suggestions.show();
                    } else {
                        suggestions.hide();
                    }
                }
            });
        } else {
            $('#suggestions').hide();
        }
    });

    // Gestion des clics sur les suggestions
    $(document).on('click', '.autocomplete-suggestion', function() {
        var selectedText = $(this).find('.autocomplete-name').text();
        $('#search').val(selectedText);
        $('#suggestions').hide();
    });

    // Cacher les suggestions si l'utilisateur clique en dehors
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#search').length) {
            $('#suggestions').hide();
        }
    });
});
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
    window.location.href = '../pages/logout.php';
}

// Start the timer when the page loads
startTimer();

</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('search').addEventListener('input', function() {
        const name = this.value.trim();

        if (name.length > 2) {  // Minimum length to start search
            fetch(`../assets/ad_search.php?term=${encodeURIComponent(name)}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Assurez-vous que 'data' est un tableau et qu'il n'est pas vide
                if (Array.isArray(data) && data.length > 0) {
                    // Utilisez le premier élément du tableau pour obtenir l'email
                    const email = data[0].email;
                    document.getElementById('email').value = email;
                } else {
                    document.getElementById('email').value = 'Aucune adresse trouvée';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('email').value = 'Erreur de recherche';
            });
        } else {
            document.getElementById('email').value = '';
        }
    });
});

</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('search').addEventListener('input', function() {
        const name = this.value.trim();

        if (name.length > 2) {  // Minimum length to start search
            fetch(`../assets/ad_search.php?term=${encodeURIComponent(name)}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Assurez-vous que 'data' est un tableau et qu'il n'est pas vide
                if (Array.isArray(data) && data.length > 0) {
                    // Utilisez le premier élément du tableau pour obtenir l'email
                    const sAMAccountName = data[0].sAMAccountName;
                    document.getElementById('sAMAccountName').value = sAMAccountName;
                } else {
                    document.getElementById('sAMAccountName').value = 'Aucune adresse trouvée';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('sAMAccountName').value = 'Erreur de recherche';
            });
        } else {
            document.getElementById('sAMAccountName').value = '';
        }
    });
});

</script>
