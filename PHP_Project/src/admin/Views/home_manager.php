<?php
include_once __DIR__ . '../../../../config.php';
include_once __DIR__ . '/../Public/header.php';
include_once __DIR__ . '/../Public/sidebar.php';

try {

  $query = "SELECT * 
                FROM tbl_images p 
                WHERE image_path in (1,2,3,4,5,6,7,8)";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $urls = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Database error: " . $e->getMessage();
}


try {
  $query = "SELECT * 
                FROM tbl_products p 
                LEFT JOIN tbl_images i ON i.image_id = p.image_id
                LEFT JOIN tbl_categories c ON c.category_id = p.category_id
                LEFT JOIN tbl_suppliers s ON s.supplier_code = p.supplier_code";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Database error: " . $e->getMessage();
}


?>

<main class="main-content container mt-4">
  <h1 class="mb-4">Product Management</h1>

  <form method="GET" action="" class="row g-3 mb-3">
    <div class="col-md-6">
      <input type="text" class="form-control" name="search" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
    </div>
    <div class="col-md-3">
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
    <div class="col-md-3 text-end">
      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEditProductModal" onclick="openAddProductModal()">Add New</button>
    </div>
  </form>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th scope="col">No</th>
        <th scope="col">Product ID</th>
        <th scope="col">Product Name</th>
        <th scope="col">Category</th>
        <th scope="col">Quantity</th>
        <th scope="col">Supplier</th>
        <th scope="col">Image</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $stt = 1;
      $search = isset($_GET['search']) ? strtolower($_GET['search']) : '';
      foreach ($products as $product) {
        echo "<tr>";
        echo "<th scope='row'>{$stt}</th>";
        echo "<td>{$product['product_code']}</td>";
        echo "<td>{$product['product_name']}</td>";
        echo "<td>{$product['category_name']}</td>";
        echo "<td>{$product['stock']}</td>";
        echo "<td>{$product['supplier_name']}</td>";
        echo "<td><img src='" . LOCAL_URL . "{$product['image_path']}' width='50' class='img-thumbnail' /></td>";
        echo "<td>
                    <button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#addEditProductModal' 
                        onclick='openEditProductModal(\"{$product['product_code']}\", \"{$product['product_name']}\", \"{$product['category_name']}\", {$product['stock']}, \"{$product['supplier_name']}\")'>Edit</button>
                    <button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteProductModal' 
                        onclick='openDeleteProductModal(\"{$product['product_guid']}\")'>Delete</button>
                </td>";
        echo "</tr>";
        $stt++;
      }
      ?>
    </tbody>
  </table>
</main>

<div class="modal fade" id="addEditProductModal" tabindex="-1" aria-labelledby="addEditProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEditProductModalLabel">Add/Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addEditProductForm">
          <input type="hidden" id="productIdHidden">
          <div class="mb-3">
            <label for="productCode" class="form-label">Product Code</label>
            <input type="text" class="form-control" id="productCode" name="productCode" required>
          </div>
          <div class="mb-3">
            <label for="productName" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="productName" name="productName" required>
          </div>
          <div class="mb-3">
            <label for="productType" class="form-label">Category</label>
            <input type="text" class="form-control" id="productType" name="productType" required>
          </div>
          <div class="mb-3">
            <label for="productQuantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="productQuantity" name="productQuantity" required>
          </div>
          <div class="mb-3">
            <label for="productSupplier" class="form-label">Supplier</label>
            <input type="text" class="form-control" id="productSupplier" name="productSupplier" required>
          </div>
          <div class="mb-3">
            <label for="productImage" class="form-label">Image</label>
            <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="addEditProductForm">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this product?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="#" id="confirmDeleteButton" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>

<script>
  function openAddProductModal() {
    document.getElementById('addEditProductModalLabel').textContent = 'Add Product';
    document.getElementById('productCode').value = '';
    document.getElementById('productName').value = '';
    document.getElementById('productType').value = '';
    document.getElementById('productQuantity').value = '';
    document.getElementById('productSupplier').value = '';
    document.getElementById('productImage').value = '';
  }


  function openEditProductModal(id, name, type, quantity, supplier) {
    document.getElementById('addEditProductModalLabel').textContent = 'Edit Product';
    document.getElementById('productCode').value = id;
    document.getElementById('productName').value = name;
    document.getElementById('productType').value = type;
    document.getElementById('productQuantity').value = quantity;
    document.getElementById('productSupplier').value = supplier;
  }


  function openDeleteProductModal(id) {
    const deleteButton = document.getElementById('confirmDeleteButton');
    deleteButton.href = `delete_product.php?id=${id}`;
  }
</script>

<?php
include_once __DIR__ . '/../Public/footer.php';
?>