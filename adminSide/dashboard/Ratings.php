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
        <div class="bg-yellow-400 p-4 flex justify-between items-center text-white">
          <div><strong>Product ratings</strong></div>
          <img src="https://i.imgur.com/1Q2Z1ZL.png" alt="User" class="h-8 w-8 rounded-full">
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

  
</body>
</html>
