<?php
session_start();
require "assets/function.php";
date_default_timezone_set('Africa/Douala');
$date = date('Y-m-d h:i:sa');
$_SESSION["date"] = $date;

$ldapServer = 'ldap://xxxxxxxxxxxxx';
$ldapDomain = 'xxxxxxxxxxx';
$ldapPort = 389;

error_reporting(0);

$error_message = ""; // ✅ variable pour stocker les messages d’erreur

if (isset($_POST['submit'])) {
    $ldap_password = 'xxxxx';
    $ldap_user = 'xxxxx';

    $ldapConn = ldap_connect($ldapServer, $ldapPort);
    ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);

    if (ldap_bind($ldapConn, $ldap_user, $ldap_password)) {
        $password = $_POST["password"];
        $username = $_POST["username"];
        $ldapBind = ldap_bind($ldapConn, $username . '@' . $ldapDomain, $password);

        if ($ldapBind) {
            // ✅ Authentification réussie
            $ldap_base_dn = "OU=NDG,OU=Private,DC=sgbc,DC=socgen";
            $ldap_filter = "(sAMAccountName=$username)";
            $ldap_attributes = array("displayName", "mail");
            $ldap_search = ldap_search($ldapConn, $ldap_base_dn, $ldap_filter, $ldap_attributes);
            $ldap_entries = ldap_get_entries($ldapConn, $ldap_search);

            $display_name = $ldap_entries[0]["displayname"][0];
            $email = $ldap_entries[0]["mail"][0];

            $con = new mysqli('localhost', 'root', '', 'ITAM');
            $result = $con->query("SELECT * FROM users WHERE email = '$email'");
            $data = $result->fetch_assoc();

            $role = $data['role'];

            $_SESSION['role'] = $role;
            $_SESSION['user'] = $display_name;
            $_SESSION['name'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['auth'] = [$_SESSION['user'], $_SESSION['name'], $_SESSION['email'], $_SESSION['role']];

            ldap_unbind($ldapConn);
            header('location: users/users.php');
            exit();
        } else {
            // ❌ Authentification échouée
            $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        $error_message = "Impossible de se connecter au serveur LDAP.";
    }
}
?>

<head>
    <title>MyASSET</title>
    <link rel="icon" href="img/logo.png" />
    <style>
        <?php include 'dist/css/code.css'; ?>
        .error-message {
            color: #fff;
            background-color: #c0392b;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-weight: bold;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.4);
        }
    </style>
</head>

<div class="login-box">
    <div class="card">
        <div class="card-header bg-black">
            <div class="login-logo">
                <img width="100%;" src="img/app_header_logo.png" />
            </div>
            <div style="height: 2rem;"></div>
        </div>
        <div class="card-body login-card-body">

            <!-- ✅ Affichage clair du message d’erreur -->
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?= $error_message ?></div>
            <?php endif; ?>

            <form action="#" method="POST">
                <div class="user-box">
                    <input type="text" name="username" required="">
                    <label>Username</label>
                </div>
                <div class="user-box">
                    <input type="password" name="password" required="">
                    <label>Password</label>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input type="submit" name="submit" value="Connexion" class="btn bg-red w-100 btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
