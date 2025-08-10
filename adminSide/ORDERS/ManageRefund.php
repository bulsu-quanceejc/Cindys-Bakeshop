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
      <div class="bg-yellow-400 p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-white uppercase">Refunds</h1>
        <div class="flex gap-4 items-center">
          <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
          </svg>
          <img src="avatar.png" alt="User Avatar" class="h-10 w-10 rounded-full border border-gray-300" />
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

    function exportRefunds() {
      const rows = Array.from(document.querySelectorAll('#refundTable tr')).filter(row => row.style.display !== 'none');
      let csv = "Refund ID,Order ID,Customer,Reason,Date,Status\n";

      rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        csv += [
          cells[1].textContent.trim(),
          cells[2].textContent.trim(),
          cells[3].textContent.trim(),
          cells[4].textContent.trim(),
          cells[5].textContent.trim(),
          cells[6].textContent.trim()
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
</body>
</html>
