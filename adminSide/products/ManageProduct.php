<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Products</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      background-color: #f5f5f5;
    }
    .sidebar {
      width: 240px;
      background-color: #ffffff;
      height: 100vh;
      border-right: 1px solid #ddd;
      padding: 1rem;
      overflow-y: auto;
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
    .submenu a.active {
      background-color: #d1fae5;
      font-weight: bold;
    }
    .main {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .topbar {
      background-color: #ffe600;
      padding: 1rem 2rem;
      font-weight: bold;
      font-size: 18px;
      border-bottom: 1px solid #ccc;
    }
    .content {
      padding: 20px;
    }
    .toolbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 20px;
    }
    .toolbar input,
    .toolbar select {
      padding: 8px 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .toolbar .btn-add {
      padding: 8px 15px;
      background-color: #f08080;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
    }
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
      gap: 20px;
    }
    .product-card {
      background: #fff;
      border: 2px solid #f08080;
      border-radius: 16px;
      padding: 10px;
      text-align: center;
    }
    .product-card img {
      width: 50%;
      height: 100px;
      object-fit: cover;
      border-radius: 10px;
    }
    .stock {
      margin: 8px 0;
      font-weight: bold;
    }
    .price {
      color: #dc2626;
      font-weight: bold;
      margin-top: 8px;
    }
    .product-card button {
      padding: 5px 10px;
      margin: 3px;
      border: 1px solid black;
      background: #fefefe;
      cursor: pointer;
      border-radius: 4px;
    }
    .pagination {
      text-align: center;
      margin-top: 20px;
    }
    .pagination button {
      margin: 0 5px;
      padding: 8px 12px;
      background: #f08080;
      border: none;
      border-radius: 6px;
      color: white;
      cursor: pointer;
    }
  </style>
</head>
<body class="bg-white flex h-screen overflow-hidden">
<?php
$activePage = 'products';
include '../sidebar.php';
?>

<!-- Main -->
<main class="main flex-1 overflow-y-auto">
  <div class="topbar">Manage Products</div>
  <div class="content">
    <div class="toolbar">
      <input type="text" id="search" placeholder="Search product name...">
      <select id="category">
        <option value="">All Categories</option>
        <option value="Cake">Cake</option>
        <option value="Bread">Bread</option>
        <option value="Pastry">Pastry</option>
      </select>
      <a href="AddNewProduct.php" class="btn-add">➕ Add New Product</a>
    </div>

    <div class="product-grid" id="productGrid"></div>
    <div class="pagination" id="paginationControls"></div>
  </div>
</main>

<script>
const products = [
  // 🧁 CAKE (45)
  { id: 1, name: "Choco Caramel Cake", price: "₱400", category: "Cake", image: "cake1.png", stock: 20 },
  { id: 2, name: "Moist Cake", price: "₱330", category: "Cake", image: "cake7.png", stock: 20 },
  { id: 3, name: "Pastel Delight Cake", price: "₱395", category: "Cake", image: "cake4.png", stock: 20 },
  { id: 4, name: "Mango Cream Delux JR.", price: "₱130", category: "Cake", image: "cake10.png", stock: 20 },
  { id: 5, name: "Choco Celebration Cake Round", price: "₱750", category: "Cake", image: "cake13.png", stock: 20 },
  { id: 6, name: "Nutty Caramel Cake Roll", price: "₱350", category: "Cake", image: "cake19.png", stock: 20 },
  { id: 7, name: "Glitz'n Glam Cake", price: "₱1500", category: "Cake", image: "cake22.png", stock: 20 },
  { id: 8, name: "Cat Castle Cake", price: "₱1900", category: "Cake", image: "cake25.png", stock: 20 },
  { id: 9, name: "Rainbow Unicorn Cake", price: "₱2300", category: "Cake", image: "cake28.png", stock: 20 },
  { id: 10, name: "Princess Cake", price: "₱3500", category: "Cake", image: "cake31.png", stock: 20 },
  { id: 11, name: "Elephant Cake", price: "₱1500", category: "Cake", image: "cake34.png", stock: 20 },
  { id: 67, name: "Creamy Choco Cake", price: "₱450", category: "Cake", image: "cake2.png", stock: 20 },
  { id: 34, name: "Choco Cherry Cake", price: "₱555", category: "Cake", image: "cake3.png", stock: 20 },
  { id: 35, name: "Dulce De Leche Cake", price: "₱395", category: "Cake", image: "cake5.png", stock: 20 },
  { id: 36, name: "Ube Macapuno Cake", price: "₱465", category: "Cake", image: "cake6.png", stock: 20 },
  { id: 37, name: "Chocolate Cake", price: "₱600", category: "Cake", image: "cake8.png", stock: 20 },
  { id: 38, name: "Ube Temptation Cake Jr.", price: "₱200", category: "Cake", image: "cake9.png", stock: 20 },
  { id: 39, name: "Mocha Celebration Cake Round", price: "₱545", category: "Cake", image: "cake11.png", stock: 20 },
  { id: 40, name: "Yema Round Celebration Cake", price: "₱750", category: "Cake", image: "cake12.png", stock: 20 },
  { id: 41, name: "Yema Rectangle Celebration Cake", price: "₱550", category: "Cake", image: "cake14.png", stock: 20 },
  { id: 42, name: "Mocha Celebration Cake Rectangle", price: "₱545", category: "Cake", image: "cake15.png", stock: 20 },
  { id: 43, name: "Choco Fudge Roll", price: "₱395", category: "Cake", image: "cake17.png", stock: 20 },
  { id: 44, name: "Ube Macapuno Roll", price: "₱365", category: "Cake", image: "cake18.png", stock: 20 },
  { id: 45, name: "Butterfly Sanctuary", price: "₱1400", category: "Cake", image: "cake20.png", stock: 20 },
  { id: 46, name: "Beauty Cake", price: "₱1400", category: "Cake", image: "cake21.png", stock: 20 },
  { id: 47, name: "Encganted Cake", price: "₱1600", category: "Cake", image: "cake23.png", stock: 20 },
  { id: 48, name: "Flamingo Cake", price: "₱1700", category: "Cake", image: "cake24.png", stock: 20 },
  { id: 49, name: "Unicorn Cake", price: "₱2000", category: "Cake", image: "cake26.png", stock: 20 },
  { id: 50, name: "Candy Drizzle Cake", price: "₱2200", category: "Cake", image: "cake27.png", stock: 20 },
  { id: 51, name: "Peppa Cake", price: "₱2500", category: "Cake", image: "cake29.png", stock: 20 },
  { id: 52, name: "Ice Cream Heaven Cake", price: "₱3400", category: "Cake", image: "cake30.png", stock: 20 },
  { id: 53, name: "Blooming Flower Cake", price: "₱5500", category: "Cake", image: "cake32.png", stock: 20 },
  { id: 54, name: "Racer's Delight", price: "₱1500", category: "Cake", image: "cake33.png", stock: 20 },
  { id: 55, name: "Blazing Motorcycle", price: "₱1600", category: "Cake", image: "cake35.png", stock: 20 },
  { id: 56, name: "Space Adventure", price: "₱1600", category: "Cake", image: "cake36.png", stock: 20 },
  { id: 57, name: "Nautical Cake", price: "₱1600", category: "Cake", image: "cake37.png", stock: 20 },
  { id: 58, name: "Detective Cake", price: "₱1900", category: "Cake", image: "cake38.png", stock: 20 },
  { id: 59, name: "Racers Cake", price: "₱1600", category: "Cake", image: "cake39.png", stock: 20 },
  { id: 60, name: "Sea Adventure Cake", price: "₱1900", category: "Cake", image: "cake40.png", stock: 20 },
  { id: 61, name: "Mincraft Kindom", price: "₱2000", category: "Cake", image: "cake41.png", stock: 20 },
  { id: 62, name: "Sonic Speed", price: "₱2500", category: "Cake", image: "cake42.png", stock: 20 },
  { id: 63, name: "Jungle Explore Cake", price: "₱2800", category: "Cake", image: "cake43.png", stock: 20 },
  { id: 64, name: "Nursery Cake", price: "₱3500", category: "Cake", image: "cake44.png", stock: 20 },
  { id: 65, name: "Peach Cream Cake", price: "₱530", category: "Cake", image: "cake45.png", stock: 20 },
  { id: 66, name: "Spider Web Cake", price: "₱3900", category: "Cake", image: "cake46.png", stock: 20 },
  
  // 🍞 BREAD (11)
  { id: 12, name: "Ubeng Ube Loaf", price: "₱35", category: "Bread", image: "bread2.png", stock: 20 },
  { id: 13, name: "Pandecoconut", price: "₱100", category: "Bread", image: "bread3.png", stock: 20 },
  { id: 14, name: "Pande Espana", price: "₱100", category: "Bread", image: "bread4.png", stock: 20 },
  { id: 15, name: "Ube Cheese Pandesal", price: "₱120", category: "Bread", image: "bread5.png", stock: 20 },
  { id: 16, name: "Mamon Cup", price: "₱35", category: "Bread", image: "bread6.png", stock: 20 },
  { id: 17, name: "Delightful Treats Choco Cringles", price: "₱75", category: "Bread", image: "bread7.png", stock: 20 },
  { id: 18, name: "Pinoy Tasty", price: "₱45", category: "Bread", image: "bread8.png", stock: 20 },
  { id: 19, name: "Jumbo Sandwich Loaf", price: "₱95", category: "Bread", image: "bread9.png", stock: 20 },
  { id: 20, name: "Wheat Bread", price: "₱70", category: "Bread", image: "bread10.png", stock: 20 },
  { id: 21, name: "Pinoy Pandesal", price: "₱40", category: "Bread", image: "bread11.png", stock: 20 },

  // 🥐 PASTRY (11)
  { id: 23, name: "Cheesy Butter Softy Mamon", price: "₱35", category: "Pastry", image: "pastry1.png", stock: 20 },
  { id: 24, name: "Bar Brownies", price: "₱35", category: "Pastry", image: "pastry2.png", stock: 20 },
  { id: 25, name: "Custard Surprise", price: "₱35", category: "Pastry", image: "pastry3.png", stock: 20 },
  { id: 26, name: "Egg Pie Caramel", price: "₱36", category: "Pastry", image: "pastry4.png", stock: 20 },
  { id: 27, name: "Egg Pie Leche Flan", price: "₱75", category: "Pastry", image: "pastry5.png", stock: 20 },
  { id: 28, name: "Brownie Bites", price: "₱68", category: "Pastry", image: "pastry6.png", stock: 20 },
  { id: 29, name: "Cluster Ensaymada Ube with Cheese", price: "₱140", category: "Pastry", image: "pastry7.png", stock: 20 },
  { id: 30, name: "Cheesy Ensaymada", price: "₱145", category: "Pastry", image: "pastry8.png", stock: 20 },
  { id: 31, name: "Mini Cinamon Roll", price: "₱150", category: "Pastry", image: "pastry9.png", stock: 20 },
  { id: 32, name: "Snap n' Roll", price: "₱150", category: "Pastry", image: "pastry10.png", stock: 20 },
  { id: 33, name: "Ensaymada Ube", price: "₱120", category: "Pastry", image: "pastry11.png", stock: 20 }
];



  const itemsPerPage = 27;
  let currentPage = 1;

  function displayProducts() {
    const grid = document.getElementById("productGrid");
    grid.innerHTML = "";
    const search = document.getElementById("search").value.toLowerCase();
    const category = document.getElementById("category").value;

    const filtered = products.filter(p =>
      p.name.toLowerCase().includes(search) &&
      (category === "" || p.category === category)
    );

    const start = (currentPage - 1) * itemsPerPage;
    const paginated = filtered.slice(start, start + itemsPerPage);

    paginated.forEach(p => {
      const stockClass =
        p.stock === 0 ? 'low' :
        p.stock < 10 ? 'medium' : 'high';

      grid.innerHTML += `
        <div class="product-card">
          <img src="${p.image}" alt="${p.name}">
          <div class="price">${p.price}</div>
          <div class="stock ${stockClass}">Stock: ${p.stock}</div>
          <div style="font-weight: bold;">${p.name}</div>
          <button onclick="editProduct(${p.id})">Edit</button>
          <button onclick="deleteProduct(${p.id})">Delete</button>
        </div>
      `;
    });

    setupPagination(filtered.length);
  }

  function setupPagination(totalItems) {
    const controls = document.getElementById("paginationControls");
    controls.innerHTML = "";
    const totalPages = Math.ceil(totalItems / itemsPerPage);

    for (let i = 1; i <= totalPages; i++) {
      controls.innerHTML += `<button onclick="goToPage(${i})">${i}</button>`;
    }
  }

  function goToPage(page) {
    currentPage = page;
    displayProducts();
  }

  function editProduct(id) {
    alert("Edit Product #" + id);
  }

  function deleteProduct(id) {
    const confirmDelete = confirm("Are you sure you want to delete product #" + id + "?");
    if (confirmDelete) {
      alert("Deleted Product #" + id);
    }
}

  document.getElementById("search").addEventListener("input", () => {
    currentPage = 1;
    displayProducts();
  });

  document.getElementById("category").addEventListener("change", () => {
    currentPage = 1;
    displayProducts();
  });

  displayProducts();
</script>
</body>
</html>
