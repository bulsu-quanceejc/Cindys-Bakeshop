<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Products</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="manage-product flex h-screen overflow-hidden">
  <?php
  $activePage = 'products';
  require '../../PHP/db_connect.php';
  require '../../PHP/product_functions.php';
  $products = getAllProducts($pdo);
  include '../sidebar.php';
  ?>

<!-- Main -->
<main class="main flex-1 overflow-y-auto">
  <div class="header-bar"><h1>Manage Products</h1></div>
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
  const products = <?php
    echo json_encode(array_map(function($p) {
        return [
            'id' => $p['Product_ID'],
            'name' => $p['Name'],
            'price' => '₱' . $p['Price'],
            'category' => $p['Category'],
            'image' => $p['Image_Path'] ? 'uploads/' . $p['Image_Path'] : "../images/cindy's logo.png",
            'stock' => $p['Stock_Quantity']
        ];
    }, $products));
  ?>;



  const itemsPerPage = 24
;
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
          <img src="${p.image}" alt="${p.name}" loading="lazy">
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
