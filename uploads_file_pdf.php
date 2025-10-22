<?php
// Crée le dossier s’il n’existe pas
$upload_dir = "uploads/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (isset($_POST['upload'])) {
    // Vérifie si un fichier a été envoyé
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {

        $file_tmp  = $_FILES['pdf_file']['tmp_name'];
        $file_name = basename($_FILES['pdf_file']['name']);
        $file_size = $_FILES['pdf_file']['size'];
        $file_type = mime_content_type($file_tmp);

        // Vérifie que c'est bien un PDF
        if ($file_type !== 'application/pdf') {
            die("❌ Erreur : le fichier doit être un PDF.");
        }

        // Limite de taille (exemple : 5 Mo)
        if ($file_size > 5 * 1024 * 1024) {
            die("❌ Erreur : le fichier est trop volumineux (max 5 Mo).");
        }

        // Nouveau nom unique pour éviter les conflits
        $new_name = uniqid("document_", true) . ".pdf";
        $upload_path = $upload_dir . $new_name;

        // Déplace le fichier vers le dossier "uploads"
        if (move_uploaded_file($file_tmp, $upload_path)) {
            echo "✅ Fichier téléversé avec succès : <a href='$upload_path'>$file_name</a>";
        } else {
            echo "❌ Erreur lors du téléchargement.";
        }

    } else {
        echo "❌ Aucun fichier reçu ou erreur lors de l’envoi.";
    }
}
?>
