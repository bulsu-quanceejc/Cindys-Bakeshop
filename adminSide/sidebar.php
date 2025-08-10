<?php
$activePage = $activePage ?? '';
?>
<aside class="w-64 bg-white border-r border-gray-200 p-4 overflow-y-auto">
  <div class="text-center mb-6">
    <img src="../images/cindy's logo.png" alt="CINDY'S" class="mx-auto">
    <p class="text-sm text-red-600 font-semibold mt-2">Give your sweet tooth a treat</p>
  </div>
  <nav class="space-y-2 text-sm font-medium">
    <a href="../dashboard/admin_dash.php" class="flex items-center gap-2 p-2 rounded <?php echo $activePage === 'dashboard' ? 'bg-gray-200 font-semibold' : 'sidebar-link'; ?>">🏠 Dashboard</a>

    <!-- Orders -->
    <div class="menu">
      <a href="javascript:void(0)" onclick="toggleMenu(this)" class="flex items-center gap-2 p-2 rounded sidebar-link">📦 Orders</a>
      <div class="submenu hidden ml-6 space-y-1">
        <a href="../ORDERS/ManageOrders.php" class="block p-2 hover:bg-gray-100 rounded">Manage Orders</a>
        <a href="../ORDERS/ManageCancel.php" class="block p-2 hover:bg-gray-100 rounded">Manage Cancellations</a>
        <a href="../ORDERS/ManageRefund.php" class="block p-2 hover:bg-gray-100 rounded">Manage Refunds</a>
      </div>
    </div>

    <!-- Products -->
    <div class="menu">
      <a href="javascript:void(0)" onclick="toggleMenu(this)" class="flex items-center gap-2 p-2 rounded sidebar-link">🛒 Products</a>
      <div class="submenu hidden ml-6 space-y-1">
        <a href="../products/ManageProduct.php" class="block p-2 hover:bg-gray-100 rounded">Manage Products</a>
        <a href="../dashboard/Ratings.php" class="block p-2 hover:bg-gray-100 rounded">Product Ratings</a>
      </div>
    </div>

    <a href="../dashboard/user.php" class="flex items-center gap-2 p-2 rounded sidebar-link">👥 Users</a>

    <!-- Reports -->
    <div class="menu">
      <a href="javascript:void(0)" onclick="toggleMenu(this)" class="flex items-center gap-2 p-2 rounded sidebar-link">📈 Reports</a>
      <div class="submenu hidden ml-6 space-y-1">
        <a href="../Reports/SalesReport.php" class="block p-2 hover:bg-gray-100 rounded">Sales Report</a>
        <a href="../Reports/InventoryReport.php" class="block p-2 hover:bg-gray-100 rounded">Inventory Report</a>
      </div>
    </div>

    <a href="../dashboard/finance.php" class="flex items-center gap-2 p-2 rounded sidebar-link">💰 Finance</a>
  </nav>
</aside>

<script>
  function toggleMenu(element) {
    const parent = element.parentElement;
    const submenu = parent.querySelector('.submenu');
    submenu.classList.toggle('hidden');
    if (submenu.classList.contains('hidden')) {
      submenu.style.display = 'none';
    } else {
      submenu.style.display = 'block';
    }
  }
</script>
