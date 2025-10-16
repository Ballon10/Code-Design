<script>
document.getElementById('selectAll').addEventListener('click', function() {
  const checkboxes = document.querySelectorAll('.rowCheckbox');
  checkboxes.forEach(chk => chk.checked = this.checked);
});

function printSelected() {
  const rows = document.querySelectorAll('.rowCheckbox:checked');
  if (rows.length === 0) {
    alert("Veuillez sélectionner au moins une ligne à imprimer !");
    return;
  }

  let printWindow = window.open('', '', 'height=700,width=900');
  printWindow.document.write('<html><head><title>Impression Rebuts</title>');
  printWindow.document.write('<style>');
  printWindow.document.write(`
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      margin: 40px;
      color: #333;
    }
    .header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 30px;
      border-bottom: 2px solid #444;
      padding-bottom: 10px;
    }
    .header img {
      height: 60px;
    }
    .header h2 {
      flex-grow: 1;
      text-align: center;
      margin: 0;
      font-size: 22px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      font-size: 14px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px 10px;
      text-align: left;
    }
    th {
      background-color: #007bff;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    .footer {
      margin-top: 40px;
      text-align: right;
      font-size: 12px;
      color: #666;
    }
  `);
  printWindow.document.write('</style></head><body>');

  // En-tête avec logo + titre
  printWindow.document.write(`
    <div class="header">
      <img src="../img/logo.png" alt="Logo MyAsset">
      <h2>Liste des matériels mis au rebut</h2>
      <div style="width:60px"></div>
    </div>
  `);

  // Tableau
  printWindow.document.write('<table>');
  printWindow.document.write('<thead><tr><th>#</th><th>TypeMateriel</th><th>Fabricant</th><th>Modele</th><th>SerialNumber</th><th>DateDepart</th><th>Observations</th></tr></thead>');
  printWindow.document.write('<tbody>');

  rows.forEach(rowCheckbox => {
    const row = rowCheckbox.closest('tr');
    let rowData = '';
    for (let i = 1; i < row.cells.length - 1; i++) {
      rowData += '<td>' + row.cells[i].innerText + '</td>';
    }
    printWindow.document.write('<tr>' + rowData + '</tr>');
  });

  printWindow.document.write('</tbody></table>');

  // Pied de page avec date
  const today = new Date().toLocaleString();
  printWindow.document.write(`<div class="footer">Imprimé le ${today}</div>`);

  printWindow.document.write('</body></html>');
  printWindow.document.close();
  printWindow.print();
}
</script>
