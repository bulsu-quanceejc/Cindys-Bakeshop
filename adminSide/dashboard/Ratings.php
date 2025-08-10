<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product Ratings - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
    }

    .topbar {
      background: #ffe600;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 70px;
    }

    .topbar img {
      width: 35px;
      height: 35px;
      border-radius: 50%;
    }

    .content {
      padding: 2rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 12px 15px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    th {
      background: #f9f9f9;
    }

    .stars {
      color: #facc15;
      font-size: 1rem;
    }

    .btn-delete {
      padding: 5px 10px;
      background-color: #fca5a5;
      border: none;
      color: #911;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn-delete:hover {
      background-color: #f87171;
    }
  </style>
</head>
  <body class="bg-white">
    <div class="flex h-screen overflow-hidden">
      <?php
      $activePage = 'ratings';
      include '../sidebar.php';
      ?>
      <main class="flex-1 overflow-y-auto">
      <div class="topbar flex justify-between items-center bg-yellow-400 p-4 text-white">
        <div><strong>Product ratings</strong></div>
        <img src="https://i.imgur.com/1Q2Z1ZL.png" alt="User" class="h-8 w-8 rounded-full">
      </div>

      <div class="content p-6">
        <table class="w-full text-sm text-left bg-white rounded shadow">
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
