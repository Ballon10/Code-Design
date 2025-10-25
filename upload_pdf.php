<?php
if (isset($_POST['safeIn'])) {
    $name = $_POST['inName'];
    $file = $_FILES['inFile'];

    // Vérification du type de fichier
    $allowed = ['application/pdf'];
    if (in_array($file['type'], $allowed)) {

        // Créer un dossier pour stocker les PDF s’il n’existe pas
        $uploadDir = 'uploads/pdf/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Générer un nom unique
        $fileName = uniqid() . '_' . basename($file['name']);
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            echo "<p style='color:green;'>Fichier PDF uploadé avec succès : $fileName</p>";
        } else {
            echo "<p style='color:red;'>Erreur lors du téléchargement du fichier.</p>";
        }
    } else {
        echo "<p style='color:red;'>Seuls les fichiers PDF sont autorisés.</p>";
    }
}
?>
