<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product Ratings - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/admin.css">
</head>
  <body>
    <div class="flex h-screen overflow-hidden">
      <?php
      $activePage = 'ratings';
      include '../sidebar.php';
      ?>
      <main class="flex-1 overflow-y-auto">
          <div class="header-bar">
          <h1>Product Ratings</h1>
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

        <div class="p-6">
          <table class="table w-full text-sm text-left bg-white rounded shadow">
        <thead>
          <tr>
            <th>Product</th>
            <th>Average Rating</th>
            <th>Total Review</th>
            <th>Comments</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>EGG PIE CARAMEL</td>
            <td>
              <div class="stars">★★★★☆</div>
              <small>4.2 / 5</small>
            </td>
            <td>15</td>
            <td>Yummy</td>
            <td><button class="btn-delete">Delete</button></td>
          </tr>
          <tr>
            <td>PASTEL DELIGHT ROUND CAKE</td>
            <td>
              <div class="stars">★★★½☆</div>
              <small>3.4 / 5</small>
            </td>
            <td>9</td>
            <td>wow yummy</td>
            <td><button class="btn-delete">Delete</button></td>
          </tr>
        </tbody>
      </table>
    </div>
      </main>
    </div>
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
