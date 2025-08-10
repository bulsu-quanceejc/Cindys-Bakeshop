<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Refunds</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
  <div class="flex h-screen overflow-hidden">

    <?php
    $activePage = 'orders';
    include '../sidebar.php';
    ?>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
      <div class="header-bar">
        <h1>Refunds</h1>
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

      <!-- Refunds Section -->
      <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">Manage Refunds</h2>
        <div class="bg-white p-4 rounded shadow">
          <div class="flex flex-wrap items-center gap-3 mb-4">
            <input type="text" id="searchRefund" placeholder="Search Order ID" class="border rounded px-2 py-1 text-sm">
            <button class="btn-filter" onclick="filterRefunds('all', this)">All</button>
            <button class="btn-filter" onclick="filterRefunds('pending', this)">Pending</button>
            <button class="btn-filter" onclick="filterRefunds('approved', this)">Approved</button>
            <button class="btn-filter" onclick="filterRefunds('rejected', this)">Rejected</button>
            <button onclick="exportRefunds()" class="ml-auto bg-gray-300 px-4 py-1 rounded text-sm font-semibold">Export CSV</button>
          </div>
          <table class="table w-full text-sm text-left">
            <thead class="border-b">
              <tr>
                <th>✓</th>
                <th>Refund ID</th>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Reason</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="refundTable">
              <tr data-status="pending">
                <td><input type="checkbox"></td>
                <td>RF001</td>
                <td>00005</td>
                <td>Maria Clara</td>
                <td>Product damaged</td>
                <td>2025-07-03</td>
                <td class="text-yellow-500 font-medium">Pending</td>
                <td>
                  <button onclick="approveRefund(this)" class="text-green-600 text-xs">Approve</button>
                  <button onclick="rejectRefund(this)" class="text-red-600 text-xs ml-2">Reject</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <script>
    function approveRefund(btn) {
      const row = btn.closest('tr');
      row.dataset.status = 'approved';
      const statusCell = row.querySelector('td:nth-child(7)');
      statusCell.innerHTML = `<span class="text-green-500 font-medium">✔ Approved</span>`;
      const actionCell = row.querySelector('td:nth-child(8)');
      actionCell.innerHTML = `<span class="text-gray-500 italic text-xs">Completed</span>`;
    }

    function rejectRefund(btn) {
      const row = btn.closest('tr');
      row.dataset.status = 'rejected';
      const statusCell = row.querySelector('td:nth-child(7)');
      statusCell.innerHTML = `<span class="text-red-500 font-medium">✖ Rejected</span>`;
      const actionCell = row.querySelector('td:nth-child(8)');
      actionCell.innerHTML = `<span class="text-gray-500 italic text-xs">Completed</span>`;
    }

    function filterRefunds(status, clickedBtn) {
      const rows = document.querySelectorAll('#refundTable tr');
      rows.forEach(row => {
        row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
      });

      const buttons = document.querySelectorAll('.btn-filter');
      buttons.forEach(btn => btn.classList.remove('btn-active'));
      clickedBtn.classList.add('btn-active');
    }

    function sanitizeCSVCell(value) {
      value = value.replace(/"/g, '""');
      if (/^[=+\-@]/.test(value)) {
        value = "'" + value;
      }
      return `"${value}"`;
    }

    function exportRefunds() {
      const rows = Array.from(document.querySelectorAll('#refundTable tr')).filter(row => row.style.display !== 'none');
      const headers = ['Refund ID','Order ID','Customer','Reason','Date','Status'].map(sanitizeCSVCell).join(',');
      let csv = headers + "\n";

      rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        csv += [
          sanitizeCSVCell(cells[1].textContent.trim()),
          sanitizeCSVCell(cells[2].textContent.trim()),
          sanitizeCSVCell(cells[3].textContent.trim()),
          sanitizeCSVCell(cells[4].textContent.trim()),
          sanitizeCSVCell(cells[5].textContent.trim()),
          sanitizeCSVCell(cells[6].textContent.trim())
        ].join(",") + "\n";
      });

      const blob = new Blob([csv], { type: 'text/csv' });
      const url = URL.createObjectURL(blob);
      const link = document.createElement('a');
      link.href = url;
      link.download = 'refunds.csv';
      link.click();
      URL.revokeObjectURL(url);
    }
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
