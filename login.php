<?php
session_start();
require "assets/function.php";
//Set The New Timezone
date_default_timezone_set('Africa/Douala');
$date = date('Y-m-d h:i:sa');
$_SESSION["date"]=$date;
// Configuration de l'authentification Active Directory
$ldapServer = 'ldap://193.53.75.3'; // Remplacez par l'adresse de votre serveur LDAP
$ldapDomain = 'SGBC.SOCGEN'; // Remplacez par votre domaine Active Directory
$ldapPort = 389;    //numéro de port ldap

error_reporting(0);//Desactivation de toutes les lignes d'erreur

if(isset($_POST['submit']))
    {

$ldap_password ='Enideruon@237+MacgS/';
$ldap_user ='sgbc\BC000025';

// Connexion au serveur LDAP
    $ldapConn = ldap_connect($ldapServer, $ldapPort);
    ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);

// Récupération des données du formulaire
    if (ldap_bind($ldapConn,$ldap_user,$ldap_password)) {
        //echo "1";

    if ($ldapConn) {
      $password =$_POST["password"];//ce qui vient du formulaire 
      $username =$_POST["username"];//ce qui vient du formulaire
        // Authentification de l'utilisateur
        $ldapBind = ldap_bind($ldapConn, $username . '@' . $ldapDomain, $password);

        if ($ldapBind) {
            // L'authentification a réussi
            echo "Authentification réussie !";
        // Requête LDAP pour récupérer les informations de l'utilisateur
        $ldap_base_dn = "OU=NDG,OU=Private,DC=sgbc,DC=socgen"; // Distinguished Name (DN) de l'unité organisationnelle à partir de laquelle rechercher
        $ldap_filter = "(sAMAccountName=$username)";
        $ldap_attributes = array("displayName", "mail"); // Liste des attributs à récupérer

        $ldap_search = ldap_search($ldapConn, $ldap_base_dn, $ldap_filter, $ldap_attributes);
        $ldap_entries = ldap_get_entries($ldapConn, $ldap_search);
          // Utilisateur trouvé, affichage des informations
          $display_name = $ldap_entries[0]["displayname"][0];
          $email = $ldap_entries[0]["mail"][0];
          echo "Nom complet : $display_name<br>";
          echo "Adresse e-mail : $email<br>";
          echo "Matricule : $username<br>";
          print "<pre>";
          print_r ($ldap_entries);
          print "</pre>";
        
        
       /* for ($i=0; $i<$ldap_entries["count"]; $i++){
        if($ldap_entries['count'] > 1)
        break;
            $_SESSION['user']=$ldap_entries[$i]["givenname"][0];
            #echo $_SESSION['user'];
            header("Location: users/users.php");        }   */

        $con = new mysqli('localhost','root','','ITAM');
         // $username = 'BC000025';
         $result = $con->query("SELECT * FROM users WHERE email = '$email'");
         $data = $result->fetch_assoc();
          
         $role = $data['role'];
         
        // Vous pouvez effectuer d'autres actions ici, par exemple récupérer des informations sur l'utilisateur depuis Active Directory 
		  $_SESSION['role']=$role;
          $role = 'user';   
          $_SESSION['user']=$display_name; //le nom de l'admin
          $_SESSION['name']=$username; //le matricule de l'admin
          $_SESSION['email']=$email; //le matricule de l'admin
		  $_SESSION['auth'] = [$_SESSION['user'],$_SESSION['name'],$_SESSION['email'],$_SESSION['role']];
          //$con->query("UPDATE LOGIN SET loginTime='$date' and status='online' WHERE userId='$_SESSION[user]'")
          header('location: users/users.php');
   
            // header('location: dashboard/dashboard.php'); 
            // Fermeture de la connexion LDAP
            ldap_unbind($ldapConn);
        } else {
            // L'authentification a échoué
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        // Erreur lors de la connexion au serveur LDAP
        echo "Impossible de se connecter au serveur LDAP.";
      }
  
    }
  }
    ?>

<head>
<title><?php echo "MyASSET";?></title>
<link rel="icon" href="img/logo.png" />
</head>
<style>
<?php include 'dist/css/code.css'; ?>
</style>
<div class="login-box">
	<div class="card">
		<div class="card-header bg-black">
				<div class="login-logo">
					<img width="100%;" src="img/app_header_logo.png" />
				</div>
				<div style="height: 2rem;"></div>
			</div>
			<div class="card-body login-card-body">
				<h2> </h2>
				  <form action="#" method="POST">
						<div class="user-box">
						  <input type="text" name="username" required="">
						  <label>Username</label>
						</div>
						<div class="user-box">
						  <input type="password" name="password" required="">
						  <label>Password</label>
						</div>
						
						  <!-- Option pour changer de rôle -->
						  <!-- Content Wrapper. Contains page content <a href="pages/attribution.php">Submit</a>  -->
						
						<div class="row">
							 <div class="col-12"> 
								<input type="submit" name="submit" value="Connexion" class="btn bg-red w-100 btn-block">
							 </div>
						</div>
						
				  </form>
		</div> 
	</div>
</div>

