
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Orders</title>
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
        <h1 class="text-xl font-bold text-white uppercase">Orders</h1>
        <div class="flex gap-4 items-center">
          <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
          </svg>
          <img src="avatar.png" alt="User Avatar" class="h-10 w-10 rounded-full border border-gray-300" />
        </div>
      </div>

      <!-- Orders Section -->
      <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">Manage Orders</h2>
        <div class="bg-white p-4 rounded shadow">
          <div class="flex items-center gap-4 mb-4">
            <input type="text" id="searchOrder" placeholder="Search Order ID" class="border rounded px-2 py-1 text-sm">
            <input type="date" class="border rounded px-2 py-1 text-sm">
            <input type="date" class="border rounded px-2 py-1 text-sm">
            <button class="bg-gray-300 px-4 py-1 rounded text-sm">Export Orders</button>
          </div>
          <div class="flex space-x-4 mb-2 text-sm">
            <button onclick="filterOrders('all')" class="tab-active">All</button>
            <button onclick="filterOrders('to process')" class="text-blue-600">To Process</button>
            <button onclick="filterOrders('shipped')" class="text-blue-600">Shipped</button>
            <button onclick="filterOrders('completed')" class="text-blue-600">Completed</button>
          </div>
          <table class="table w-full text-sm text-left">
            <thead class="border-b">
              <tr>
                <th class="py-2">✓</th>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="orderTable">
              <tr data-status="to process">
                <td><input type="checkbox"></td>
                <td>00001</td>
                <td>Mariel Balanac</td>
                <td>Ensaymada Ube</td>
                <td>₱699.00</td>
                <td class="text-yellow-500 font-medium">To Process</td>
                <td class="text-blue-500 cursor-pointer">View</td>
              </tr>
              <tr data-status="shipped">
                <td><input type="checkbox"></td>
                <td>00002</td>
                <td>Juan Dela Cruz</td>
                <td>Pandesal Box</td>
                <td>₱250.00</td>
                <td class="text-blue-500 font-medium">Shipped</td>
                <td class="text-blue-500 cursor-pointer">View</td>
              </tr>
              <tr data-status="completed">
                <td><input type="checkbox"></td>
                <td>00003</td>
                <td>Anna Reyes</td>
                <td>Cheese Roll</td>
                <td>₱320.00</td>
                <td class="text-green-500 font-medium">Completed</td>
                <td class="text-blue-500 cursor-pointer">View</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <!-- Sidebar Script -->
  <script>
    function filterOrders(status) {
      const rows = document.querySelectorAll('#orderTable tr');
      rows.forEach(row => {
        const rowStatus = row.dataset.status;
        if (status === 'all' || rowStatus === status) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }
  </script>
</body>
</html>
