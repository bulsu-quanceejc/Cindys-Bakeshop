<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Finance Dashboard - Cindy's Bakeshop</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
      body {
        font-family: "Segoe UI", sans-serif;
        margin: 0;
        background: #f5f5f5;
      }

      .sidebar {
        width: 100px;
        background: #fff;
        height: 100vh;
        position: fixed;
        border-right: 1px solid #ccc;
        padding: 20px;
      }

      .sidebar h2 {
        color: red;
      }

      .sidebar ul {
        list-style: none;
        padding: 0;
      }

      .sidebar ul li {
        margin: 20px 0;
      }

      .sidebar ul li a {
        text-decoration: none;
        color: #333;
        display: block;
        padding: 10px;
        border-radius: 6px;
        transition: background 0.2s;
      }

      .sidebar ul li a:hover {
        background: #ffe600;
        color: #000;
        font-weight: bold;
      }

      .sidebar ul li a.active {
        background: #d6f5d6;
        color: green;
        font-weight: bold;
      }

      .main {
        margin-left: 150px;
        padding: 20px;
      }

      .header {
        background: #ffe600;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .card {
        display: flex;
        justify-content: flex-start;
        gap: 20px;
        margin: 20px 0;
        align-items: flex-start;
      }

      canvas {
        background: #fff;
        border: 1px solid #ccc;
        padding: 10px;
      }

      .controls {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
      }

      th,
      td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: center;
      }

      select,
      input[type="date"],
      input[type="text"] {
        padding: 6px;
        border: 1px solid #aaa;
        border-radius: 4px;
      }

      .export-btn {
        background: #007bff;
        color: white;
        padding: 6px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }

      .filter-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 5px 0;
      }
      .chart-section {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
        text-align: center;
      }

      .chart-wrapper {
        background: transparent;
        border: none;
        padding: 10px;
        flex: 1 1 300px;
        min-width: 250px;
        max-width: 400px;
      }
    </style>
  </head>
    <body class="bg-white">
      <div class="flex h-screen overflow-hidden">
        <?php
        $activePage = 'finance';
        include '../sidebar.php';
        ?>
        <main class="flex-1 overflow-y-auto">
        <div class="header">
          <h3>Finance Transaction Records</h3>
          <div>🔔 👤</div>
        </div>

        <div class="chart-section">
        <div class="chart-wrapper">
          <canvas id="barChart"></canvas>
        </div>
        <div class="chart-wrapper">
          <canvas id="pieChart"></canvas>
        </div>
      </div>

      <div class="filter-row">
        <input type="text" placeholder="Search Order ID" />
        <select>
          <option>All Status</option>
          <option>Paid</option>
          <option>Pending</option>
          <option>Refunded</option>
          <option>Failed</option>
        </select>
        <select id="paymentFilter">
          <option value="All">All Payment Methods</option>
          <option value="GCash">GCash</option>
          <option value="COD">COD</option>
        </select>

        <input type="date" /> to <input type="date" />
        <button class="export-btn">Export CSV</button>
      </div>

      <table>
        <thead>
          <tr>
            <th>Transaction ID</th>
            <th>Order ID</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Payment Date</th>
            <th>Amount Paid</th>
            <th>Reference Number</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>TXN-0001</td>
            <td>ORD-1025</td>
            <td>COD</td>
            <td>Paid</td>
            <td>2025-06-23</td>
            <td>₱250.00</td>
            <td>--</td>
          </tr>
          <tr>
            <td>TXN-0002</td>
            <td>ORD-1026</td>
            <td>GCash</td>
            <td>Refunded</td>
            <td>2025-06-23</td>
            <td>₱900.00</td>
            <td>GC123456789</td>
          </tr>
          <tr>
            <td>TXN-0003</td>
            <td>ORD-1027</td>
            <td>GCash</td>
            <td>Pending</td>
            <td>2025-06-23</td>
            <td>₱800.00</td>
            <td>GC987654321</td>
          </tr>
        </tbody>
      </table>
        </main>
      </div>

    <script>
      const barCtx = document.getElementById("barChart").getContext("2d");
      new Chart(barCtx, {
        type: "bar",
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
          datasets: [
            {
              label: "Monthly Total Sales (₱)",
              data: [1200, 1900, 3000, 2500, 3200, 2800],
              backgroundColor: "#007bff",
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false },
          },
        },
      });

      const pieCtx = document.getElementById("pieChart").getContext("2d");
      new Chart(pieCtx, {
        type: "pie",
        data: {
          labels: ["COD", "GCash"],
          datasets: [
            {
              label: "Payment Method Breakdown",
              data: [1, 2],
              backgroundColor: ["#ffce56", "#36a2eb"],
            },
          ],
        },
        options: {
          responsive: true,
        },
      });
    </script>
  </body>
</html>
