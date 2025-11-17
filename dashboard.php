<?php
// dashboard.php - version optimisée (AdminLTE v4 + Bootstrap 5 + Chart.js v4)
// -------------------------------------------------------------
// Pré-requis : ../assets/db.php doit créer la variable $con (mysqli)
//              ../assets/function.php facultatif
// -------------------------------------------------------------
session_start();

// redirect if not authenticated
if (!isset($_SESSION['user']) || !isset($_SESSION['name'])) {
    header('Location: ../login.php');
    exit;
}

$username  = $_SESSION['user'];
$matricule = $_SESSION['name'];

require_once '../assets/db.php';     // MUST set $con = new mysqli(...)
require_once '../assets/function.php'; // optional helper functions

// ---------- utility helpers ----------
function e($v) {
    return htmlspecialchars($v ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * fetch_count:
 * - $con : mysqli connection
 * - $sql  : SQL string; if contains ? placeholders, provide $types and $params
 */
function fetch_count($con, $sql, $types = null, $params = []) {
    if ($types === null) {
        $res = $con->query($sql);
        if (!$res) return 0;
        $r = $res->fetch_row();
        return isset($r[0]) ? (int)$r[0] : 0;
    } else {
        $stmt = $con->prepare($sql);
        if (!$stmt) return 0;
        if ($types) $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $res = $stmt->get_result();
        $r = $res->fetch_row();
        $stmt->close();
        return isset($r[0]) ? (int)$r[0] : 0;
    }
}

// ---------- ensure user is admin ----------
$stmt = $con->prepare("SELECT role FROM users WHERE matricule = ? LIMIT 1");
$stmt->bind_param('s', $matricule);
$stmt->execute();
$res = $stmt->get_result();
$userRow = $res->fetch_assoc();
$stmt->close();

if (!$userRow || ($userRow['role'] ?? '') !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// ---------- OPTIONAL: Visit tracking (creates table if not exists) ----------
/*
  This block logs page visits. It's optional — remove if you prefer external analytics.
  It also creates the 'visits' table automatically if it doesn't exist.
*/
$enableVisits = true;
if ($enableVisits) {
    $createVisitsSQL = "CREATE TABLE IF NOT EXISTS visits (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ip_address VARCHAR(50),
        user_agent TEXT,
        user VARCHAR(100),
        visited_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $con->query($createVisitsSQL);

    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    $u = $username;
    $stmt = $con->prepare("INSERT INTO visits (ip_address, user_agent, user) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param('sss', $ip, $ua, $u);
        $stmt->execute();
        $stmt->close();
    }
}

// ---------- KPI queries (optimized) ----------
$totalMateriels = fetch_count($con, "SELECT COUNT(*) FROM attribution");
$totalStock     = fetch_count($con, "SELECT COUNT(*) FROM livraison WHERE statut = 'Approved by SIOP'");
$totalRebuts    = fetch_count($con, "SELECT COUNT(*) FROM rebus");
$totalMouvements= $totalMateriels; // same as attribution count here

// visitors KPIs
$totalVisits     = fetch_count($con, "SELECT COUNT(*) FROM visits");
$uniqueVisitors  = fetch_count($con, "SELECT COUNT(DISTINCT ip_address) FROM visits");

// ---------- distribution by type (top 10) ----------
$typeData = [];
$sql = "SELECT UPPER(type) AS type_label, COUNT(*) AS cnt FROM attribution GROUP BY type_label ORDER BY cnt DESC LIMIT 10";
$res = $con->query($sql);
if ($res) {
    while ($r = $res->fetch_assoc()) {
        $typeData[] = [$r['type_label'], (int)$r['cnt']];
    }
}

// ---------- top technicians ----------
$techData = [];
$sql = "SELECT technician, COUNT(*) AS cnt FROM attribution GROUP BY technician ORDER BY cnt DESC LIMIT 8";
$res = $con->query($sql);
if ($res) {
    while ($r = $res->fetch_assoc()) {
        $techData[] = [$r['technician'], (int)$r['cnt']];
    }
}

// ---------- series: attributions per month (YYYY-MM) ----------
$months = [];
$values = [];
$sql = "SELECT DATE_FORMAT(dateAttribution, '%Y-%m') AS ym, COUNT(*) AS cnt
        FROM attribution
        GROUP BY ym
        ORDER BY ym ASC";
$res = $con->query($sql);
if ($res) {
    while ($r = $res->fetch_assoc()) {
        $months[] = $r['ym'];
        $values[] = (int)$r['cnt'];
    }
}

// ---------- last 10 attributions ----------
$lastAttr = [];
$sql = "SELECT matricule, type, interventionType, serialNumber, dateAttribution FROM attribution ORDER BY id DESC LIMIT 10";
$res = $con->query($sql);
if ($res) {
    while ($r = $res->fetch_assoc()) {
        $lastAttr[] = $r;
    }
}

// ---------- Quick top types for product list (optional) ----------
$productList = [];
$sql = "SELECT UPPER(type) AS t, COUNT(*) AS c FROM attribution GROUP BY t ORDER BY c DESC LIMIT 6";
$res = $con->query($sql);
if ($res) {
    while ($r = $res->fetch_assoc()) {
        $productList[] = [$r['t'], (int)$r['c']];
    }
}

// -------------------- HTML output --------------------
?><!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>MyASSET — Dashboard</title>
  <link rel="icon" href="../img/logo.png">

  <!-- Bootstrap 5, FontAwesome, AdminLTE v4 (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.7/dist/css/adminlte.min.css" rel="stylesheet">

  <style>
    .kpi-box { min-height: 100px; }
    .chart-card { min-height: 260px; }
    .small-num { font-size: 1.6rem; font-weight:700 }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- NAVBAR -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
      <li class="nav-item d-none d-sm-inline-block"><a href="dashboard.php" class="nav-link">Accueil</a></li>
    </ul>

    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="../pages/logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
    </ul>
  </nav>

  <!-- SIDEBAR -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="dashboard.php" class="brand-link">
      <img src="../img/logo.png" alt="Logo" class="brand-image img-square">
      <span class="brand-text fw-light">MyASSET</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image"><img src="../img/user.png" class="img-circle" alt="User"></div>
        <div class="info"><a href="#" class="d-block"><?= e(ucfirst($username)) ?></a></div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <li class="nav-item"><a href="dashboard.php" class="nav-link active"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
          <li class="nav-item"><a href="../pages/attribution.php" class="nav-link"><i class="nav-icon fas fa-laptop"></i><p>Attribution</p></a></li>
          <li class="nav-item"><a href="../pages/stocks.php" class="nav-link"><i class="nav-icon fas fa-warehouse"></i><p>Stocks</p></a></li>
          <li class="nav-item"><a href="../pages/rebuts.php" class="nav-link"><i class="nav-icon fas fa-archive"></i><p>Rebuts</p></a></li>
          <li class="nav-item"><a href="../users/users.php" class="nav-link"><i class="nav-icon fas fa-user"></i><p>Mon compte</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- CONTENT WRAPPER -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1 class="m-0">Tableau de bord</h1></div>
          <div class="col-sm-6"><ol class="breadcrumb float-sm-end"><li class="breadcrumb-item active">Dashboard</li></ol></div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">

        <!-- KPIs -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info kpi-box">
              <div class="inner"><p class="small-num"><?= e(number_format($totalMateriels)) ?></p><p>Matériels</p></div>
              <div class="icon"><i class="fas fa-box-open"></i></div>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-success kpi-box">
              <div class="inner"><p class="small-num"><?= e(number_format($totalStock)) ?></p><p>Stock SIOP</p></div>
              <div class="icon"><i class="fas fa-warehouse"></i></div>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning kpi-box">
              <div class="inner"><p class="small-num"><?= e(number_format($totalMouvements)) ?></p><p>Mouvements</p></div>
              <div class="icon"><i class="fas fa-exchange-alt"></i></div>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger kpi-box">
              <div class="inner"><p class="small-num"><?= e(number_format($totalRebuts)) ?></p><p>Rebuts</p></div>
              <div class="icon"><i class="fas fa-trash"></i></div>
            </div>
          </div>
        </div>

        <!-- Visitors KPI row -->
        <div class="row mb-3">
          <div class="col-lg-3 col-6">
            <div class="info-box">
              <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Visites totales</span>
                <span class="info-box-number"><?= e(number_format($totalVisits)) ?></span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="info-box">
              <span class="info-box-icon bg-teal"><i class="fas fa-user-check"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Visiteurs uniques</span>
                <span class="info-box-number"><?= e(number_format($uniqueVisitors)) ?></span>
              </div>
            </div>
          </div>
        </div>

        <!-- Charts -->
        <div class="row">
          <div class="col-lg-7">
            <div class="card chart-card">
              <div class="card-header"><h3 class="card-title">Attributions par mois</h3></div>
              <div class="card-body"><canvas id="lineChart" style="height:250px"></canvas></div>
            </div>
          </div>

          <div class="col-lg-5">
            <div class="card">
              <div class="card-header"><h3 class="card-title">Répartition par type</h3></div>
              <div class="card-body"><canvas id="typePie" style="height:200px"></canvas></div>
            </div>

            <div class="card mt-3">
              <div class="card-header"><h3 class="card-title">Top techniciens</h3></div>
              <div class="card-body"><canvas id="techBar" style="height:200px"></canvas></div>
            </div>
          </div>
        </div>

        <!-- Latest Attributions -->
        <div class="card mt-3">
          <div class="card-header"><h3 class="card-title">Dernières attributions</h3></div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped m-0">
                <thead><tr><th>Matricule</th><th>Type</th><th>Intervention</th><th>Serial</th><th>Date</th></tr></thead>
                <tbody>
                  <?php foreach ($lastAttr as $r): ?>
                  <tr>
                    <td><?= e($r['matricule']) ?></td>
                    <td><?= e($r['type']) ?></td>
                    <td><span class="badge bg-success"><?= e($r['interventionType']) ?></span></td>
                    <td><?= e($r['serialNumber']) ?></td>
                    <td><?= e($r['dateAttribution']) ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>

  <footer class="main-footer">
    <div class="float-end d-none d-sm-inline">Version 1.1</div>
    <strong>&copy; <?= date('Y') ?> MyASSET</strong>
  </footer>

</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.7/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>

<script>
/* Data from PHP */
const months = <?= json_encode($months, JSON_UNESCAPED_UNICODE) ?>;
const monthValues = <?= json_encode($values) ?>;
const typeData = <?= json_encode($typeData, JSON_UNESCAPED_UNICODE) ?>; // [ [label, value], ... ]
const techData = <?= json_encode($techData, JSON_UNESCAPED_UNICODE) ?>; // [ [tech, value], ... ]

// Line chart: attributions per month
const ctxLine = document.getElementById('lineChart');
if (ctxLine) {
  new Chart(ctxLine, {
    type: 'line',
    data: {
      labels: months,
      datasets: [{
        label: 'Attributions',
        data: monthValues,
        borderWidth: 2,
        tension: 0.3,
        pointRadius: 3
      }]
    },
    options: { responsive: true, maintainAspectRatio: false }
  });
}

// Doughnut: type distribution
const ctxPie = document.getElementById('typePie');
if (ctxPie) {
  new Chart(ctxPie, {
    type: 'doughnut',
    data: {
      labels: typeData.map(i => i[0]),
      datasets: [{ data: typeData.map(i => i[1]) }]
    },
    options: { responsive: true, maintainAspectRatio: false }
  });
}

// Bar: top technicians
const ctxBar = document.getElementById('techBar');
if (ctxBar) {
  new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: techData.map(i => i[0]),
      datasets: [{ data: techData.map(i => i[1]) }]
    },
    options: { responsive: true, maintainAspectRatio: false }
  });
}
</script>
</body>
</html>
