<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Inventory Report</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
      display: flex;
      background-color: #f3f3f3;
    }

    .sidebar {
      width: 240px;
      background-color: #ffffff;
      height: 100vh;
      border-right: 1px solid #ddd;
      padding: 1rem;
      overflow-y: auto;
      position: fixed;
      left: 0;
      top: 0;
    }

    .sidebar .logo {
      text-align: center;
      margin-bottom: 1rem;
    }

    .sidebar .logo img {
      height: 48px;
    }

    .sidebar .logo p {
      font-size: 0.85rem;
      color: #dc2626;
      font-weight: bold;
      margin-top: 0.3rem;
    }

    .sidebar nav {
      display: flex;
      flex-direction: column;
      gap: 0.4rem;
      font-size: 0.95rem;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem;
      text-decoration: none;
      color: #000;
      border-radius: 6px;
      transition: 0.2s ease;
    }

    .sidebar a:hover {
      background-color: #f3f4f6;
    }

    .submenu {
      margin-left: 1.5rem;
      display: none;
      flex-direction: column;
    }

    .submenu a {
      padding: 0.3rem 0.5rem;
      border-radius: 4px;
    }

    .submenu a:hover {
      background-color: #e5e7eb;
    }

    .main {
      margin-left: 240px;
      width: calc(100% - 240px);
    }

    .topbar {
      background-color: #ffe600;
      padding: 15px 20px;
      font-weight: bold;
      font-size: 18px;
      border-bottom: 1px solid #ccc;
    }

    .content {
      padding: 20px;
    }

    h2 {
      margin: 30px 0 10px;
    }

    .search-bar {
      margin-bottom: 20px;
    }

    input[type="text"] {
      padding: 8px;
      width: 300px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      padding: 8px 15px;
      background-color: #ffe600;
      border: none;
      cursor: pointer;
      font-weight: bold;
      margin-left: 10px;
      border-radius: 5px;
    }

    table {
      width: 100%;
      background-color: #fff;
      border-collapse: collapse;
      margin-bottom: 40px;
    }

    th, td {
      padding: 10px;
      text-align: left;
      border: 1px solid #ddd;
    }

    th {
      background-color: #ffe600;
    }

    .stock input {
      border: none;
      width: 100%;
      background: transparent;
      outline: none;
      font-weight: bold;
    }

    .stock-low input {
      background-color: #ffe5e5;
      color: red;
    }

    .stock-medium input {
      background-color: #fff9db;
      color: #ff9800;
    }

    .stock-ok input {
      background-color: #e8f5e9;
      color: green;
    }

    .stock-preorder input {
      background-color: #e0f2ff;
      color: blue;
      font-style: italic;
    }
  </style>
</head>
<body class="bg-white flex h-screen overflow-hidden">
  <?php
  $activePage = 'reports';
  include '../sidebar.php';
  ?>

  <!-- Main -->
  <main class="main flex-1 overflow-y-auto">
    <div class="topbar">Inventory Report</div>
    <div class="content">
      <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search product..." onkeyup="filterInventory()">
        <button onclick="exportToPDF()">📄 Export to PDF</button>
      </div>

      <div id="inventoryContainer">
        <!-- Tables inserted here by script -->
      </div>
    </div>
  </main>

  <!-- Script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script>

    const inventoryData = {
      Bread: [
        ["Taisan Soft Cake", 0], ["Ubeng Ube Loaf", 5], ["Pandecoconut", 12],
        ["Pande esapana", 8], ["Mamon Cup", 10], ["Delightful Treats Choco", 7],
        ["Crinkles Cokie", 6], ["Pinoy Tasty", 15], ["Jumbo Sandwich Loaf", 6],
        ["Wheat Bread", 5]
      ],
      Pastry: [
        ["Egg Pie Leche Plan", 0], ["Brownie Bites", 3], ["Custard Surprise", 9],
        ["Cluster Ensaymada Ube with Cheese", 11], ["Mini Cinamon Roll", 5],
        ["Ensaymada Cheese", 10], ["Snap n’ roll", 8], ["Cheesy Ensaymada", 9],
        ["Egg pie caramel", 14], ["Cheesy Butter Softy", 18], ["Mamon", 6],
        ["Choco Bar", 7], ["Ensaymada Ube", 11]
      ],
      Cakes: [
        ["Choco Cherry Cake", 0], ["Creamy Choco Cake", 2], ["Chocolate Cake", 10],
        ["Moist Cake", 14], ["Pastel Delight Round Cake", 9],
        ["Mocha Celebration Cake Round", 8], ["Junior Cake, Ube Temptation", 9],
        ["Choco Celebration On Cake Round", 7], ["Yema Round Celebration On Cake", 9],
        ["Choco Caramel Cake", 7], ["Mocha Celebration On Cake Rectangle", 6],
        ["Ube Macapuno Cake", 6], ["Yema Rectangle Celebration On Cake", 4],
        ["Roll Choco Fudge", 8], ["Roll, Ube Macapuno", 14],
        ["Roll, Nutty Caramel Cake", 18], ["Junior Cake, Mango Cream Deluxe", 12],
        ["Choco Celebration On Cake Rectangle", 13],
        ["Butterfly Sanctuary", null], ["Beauty Cake", null], ["Space Adventure", null],
        ["Glitz’n Glam Cake", null], ["Flamingo Cake", null], ["Enchanted Cake", null],
        ["Candy Drizzle Cake", null], ["Cat Castle Cake", null], ["Peppa Cake", null],
        ["Ice Cream Heaven Cake", null], ["Rainbow Unicorn", null], ["Princess Cake", null],
        ["Blooming Flower Cake", null], ["Elephant Cake", null], ["Racers Cake", null],
        ["Detective Cake", null], ["Nautical Cake", null], ["Sea Adventure Cake", null],
        ["Jungle Explore Cake", null], ["Nursery Cake", null], ["Spider Web Cake", null],
        ["Unicorn Cake", null], ["Sonic Speed Cake", null], ["Minecraft Kindom Cake", null],
        ["Build The Party", null]
      ]
    };

    function buildInventoryTables() {
      const container = document.getElementById("inventoryContainer");
      container.innerHTML = "";
      for (let category in inventoryData) {
        const section = document.createElement("div");
        section.innerHTML = `<h2>${category}</h2><table class="inventory-table"><thead><tr><th>Item Name</th><th>Stock</th></tr></thead><tbody></tbody></table>`;
        const tbody = section.querySelector("tbody");
        inventoryData[category].forEach(([name, stock]) => {
          const tr = document.createElement("tr");
          const tdName = `<td>${name}</td>`;
          const tdStock = `<td class="stock"><input type="text" value="${stock ?? ''}" /></td>`;
          tr.innerHTML = tdName + tdStock;
          tbody.appendChild(tr);
        });
        container.appendChild(section);
      }
    }

    function updateStockColors() {
      document.querySelectorAll('.stock input').forEach(input => {
        const td = input.parentElement;
        td.className = 'stock';
        const value = input.value.trim();

        if (value === "") {
          input.value = "Pre-order";
          td.classList.add('stock-preorder');
        } else {
          const stock = parseInt(value);
          if (stock === 0) td.classList.add('stock-low');
          else if (stock < 10) td.classList.add('stock-medium');
          else td.classList.add('stock-ok');
        }
      });
    }

    function filterInventory() {
      const input = document.getElementById('searchInput').value.toLowerCase();
      const rows = document.querySelectorAll('#inventoryContainer table tbody tr');
      rows.forEach(row => {
        const item = row.cells[0].innerText.toLowerCase();
        row.style.display = item.includes(input) ? '' : 'none';
      });
    }

    async function exportToPDF() {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();
      doc.text("Inventory Report", 20, 20);
      let y = 30;

      document.querySelectorAll("#inventoryContainer h2").forEach(section => {
        doc.setFontSize(14);
        doc.text(section.innerText, 20, y);
        y += 10;

        const rows = section.nextElementSibling.querySelectorAll("tbody tr");
        rows.forEach(row => {
          const name = row.cells[0].innerText;
          const stock = row.cells[1].querySelector("input").value;
          doc.setFontSize(12);
          doc.text(`- ${name}: ${stock}`, 25, y);
          y += 7;
        });
        y += 5;
      });

      doc.save("Inventory_Report.pdf");
    }

    window.onload = () => {
      buildInventoryTables();
      updateStockColors();
      document.querySelectorAll('.stock input').forEach(input => {
        input.addEventListener('input', updateStockColors);
      });
    };
  </script>
</body>
</html>
