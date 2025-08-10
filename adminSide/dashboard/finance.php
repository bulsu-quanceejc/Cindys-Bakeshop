<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Finance Dashboard - Cindy's Bakeshop</title>
      <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
      <link rel="stylesheet" href="../css/admin.css">
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
      <body class="finance-page">
      <div class="flex h-screen overflow-hidden">
        <?php
        $activePage = 'finance';
        include '../sidebar.php';
        ?>
        <main class="flex-1 overflow-y-auto">
          <div class="header-bar">
            <h1>Finance Transaction Records</h1>
              <div class="flex gap-4 items-center">
                <div class="relative">
                  <button onclick="toggleDropdown()" class="relative focus:outline-none">
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-0 right-0 block h-2 w-2 bg-red-600 rounded-full"></span>
                  </button>
                  <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded shadow-lg z-50">
                    <div class="p-3 border-b font-semibold text-gray-700">Notifications</div>
                    <ul class="max-h-60 overflow-y-auto text-sm" id="notifList"></ul>
                  </div>
                </div>
                <img src="https://i.imgur.com/1Q2Z1ZL.png" alt="User Avatar" class="h-10 w-10 rounded-full border border-gray-300" />
              </div>
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
    <script>
      function toggleDropdown() {
        document.getElementById('notificationDropdown').classList.toggle('hidden');
      }

      window.addEventListener('click', function (e) {
        const bell = document.querySelector('button[onclick="toggleDropdown()"]');
        const dropdown = document.getElementById('notificationDropdown');
        if (!bell.contains(e.target) && !dropdown.contains(e.target)) {
          dropdown.classList.add('hidden');
        }
      });

      const notifications = [
        "⚠️ Low Stock: Chocolate Cake (2 left)",
        "🛒 New Order #1245 from Bulacan",
        "💬 New customer feedback received"
      ];

      const notifList = document.getElementById("notifList");
      notifications.forEach(note => {
        const li = document.createElement("li");
        li.className = "px-4 py-2 hover:bg-gray-100 cursor-pointer";
        li.textContent = note;
        notifList.appendChild(li);
      });
    </script>
  </body>
</html>
