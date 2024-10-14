<?php 
include_once __DIR__ . '../../../../config.php';
include_once __DIR__ . '/../Public/header.php';
include_once __DIR__ . '/../Public/sidebar.php';

function getListProducts($currentPage,$perPage) 
{
  global $pdo;
  $offset = ($currentPage - 1) * $perPage;
    try {
      // Lấy danh sách sản phẩm từ database
      $query = "SELECT * 
                  FROM tbl_products p 
                  LEFT JOIN tbl_images i ON i.image_id = p.image_id
                  LEFT JOIN tbl_categories c ON c.category_id = p.category_id
                  LEFT JOIN tbl_suppliers s ON s.supplier_code = p.supplier_code
                  LIMIT $perPage OFFSET $offset";
      $stmt = $pdo->prepare($query);
      $stmt->execute();
      $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $stt = 1;
    if (count($products) > 0) {
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
            <button type='button' class='btn btn-sm btn-warning' data-toggle='modal' data-target='#addEditProductModal' 
            onclick='openEditProductModal(\"{$product['product_guid']}\", \"{$product['product_code']}\", \"{$product['product_name']}\", \"{$product['category_name']}\", \"{$product['stock']}\", \"{$product['supplier_code']}\")'>Edit</button>
            <button type='button' class='btn btn-sm btn-danger' data-toggle='modal' data-target='#deleteProductModal' onclick='openDeleteProductModal(\"{$product['product_guid']}\", \"{$product['product_name']}\")'>Delete</button>
        </td>";
        echo "</tr>";
        $stt++;
      }
    }

  } catch (PDOException $e) {
      echo "Database error: " . $e->getMessage();
  }
}

function getTotalStudents()
{
    global $pdo;
    $query = "SELECT * FROM tbl_products";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null;
    return count($result);
}

// Xử lý form thêm và chỉnh sửa sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productCode = $_POST['productCode'];
    $productName = $_POST['productName'];
    $productType = $_POST['productType'];
    $productQuantity = $_POST['productQuantity'];
    $productSupplier = $_POST['productSupplier'];
    $productImage = null;

    // Xử lý ảnh nếu có upload
    // if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
    //     $targetDir = "uploads/";
    //     $fileName = basename($_FILES['productImage']['name']);
    //     $targetFilePath = $targetDir . $fileName;
    //     if (move_uploaded_file($_FILES['productImage']['tmp_name'], $targetFilePath)) {
    //         $productImage = $targetFilePath;
    //     }
    // }

    try {
        // Kiểm tra nếu sản phẩm đã tồn tại để cập nhật hoặc thêm mới
        $query = "SELECT * FROM tbl_products WHERE product_code = :productCode";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':productCode', $productCode);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Cập nhật sản phẩm
            $query = "UPDATE tbl_products SET 
                        product_name = :productName, 
                        category_name = :productType, 
                        stock = :productQuantity, 
                        supplier_name = :productSupplier";
            if ($productImage) {
                $query .= ", image_path = :productImage";
            }
            $query .= " WHERE product_code = :productCode";
        } else {
            // Thêm mới sản phẩm
            $query = "INSERT INTO tbl_products (product_code, product_name, category_name, stock, supplier_name, image_path)
                      VALUES (:productCode, :productName, :productType, :productQuantity, :productSupplier, :productImage)";
        }

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':productCode', $productCode);
        $stmt->bindParam(':productName', $productName);
        $stmt->bindParam(':productType', $productType);
        $stmt->bindParam(':productQuantity', $productQuantity);
        $stmt->bindParam(':productSupplier', $productSupplier);
        if ($productImage) {
            $stmt->bindParam(':productImage', $productImage);
        }
        $stmt->execute();
        header('Location: index.php'); // Chuyển hướng sau khi lưu
        exit();
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

    if (isset($_POST['delete_product'])) {

        $product_guid = $_POST['delete_product'];

        $stmt = $conn->prepare("UPDATE tbl_products SET DELETED = 1 WHERE product_guid = :product_guid");
        $stmt->bindParam(':product_guid', $product_guid); // i là kiểu integer, dựa vào kiểu dữ liệu của ID trong cơ sở dữ liệu
        $stmt->execute();
        $rowsAffected = $stmt->rowCount();
        var_dump($rowsAffected);

        $stmt = null;
        
        echo "<script type='text/javascript'>
            alert('Deleted success');
            setTimeout(function() {
                console.log('');
            }, 5);
          </script>";
        exit;
    }
?>

<main class="main-content container mt-4">
    <h1 class="mb-4">Product Management</h1>

    <!-- Search form and Add new button -->
    <form method="GET" action="" class="row g-3 mb-3">
        <div class="col-md-6">
            <input type="text" class="form-control" name="search" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
        <div class="col-md-3 text-end">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addEditProductModal" onclick="openAddProductModal()">Add New</button>
        </div>
    </form>

    <!-- Product table -->
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
            $perPage = 10;
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $search = isset($_GET['search']) ? strtolower($_GET['search']) : '';
            // foreach ($products as $product) {
            //     if ($search && !(
            //         strpos(strtolower($product['product_code']), $search) !== false || 
            //         strpos(strtolower($product['product_name']), $search) !== false || 
            //         strpos(strtolower($product['category_name']), $search) !== false || 
            //         strpos(strtolower($product['supplier_name']), $search) !== false
            //     )) {
            //         continue;
            //     }

            //     $stt++;
            // }
            getListProducts($currentPage,$perPage);
            ?>
        </tbody>
    </table>
      <nav aria-label="...">
          <ul class="pagination">
              <li class="page-item <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo ($currentPage > 1) ? ($currentPage - 1) : 1; ?>" tabindex="-1">Previous</a>
              </li>
                  <?php
                      $totalStudents = getTotalStudents();
                      //$totalStudents = 12;
                      $totalPages = ceil($totalStudents / $perPage);
                      for ($i = 1; $i <= $totalPages; $i++) {
                          echo '<li class="page-item ' . ($currentPage == $i ? 'active' : '') . '">';
                          echo '<a class="page-link" href="?page=' . $i . '">' . $i;
                          if ($currentPage == $i) {
                              echo ' <span class="sr-only">(current)</span>';
                          }
                          echo '</a></li>';
                      }
                  ?>
              <li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo ($currentPage < $totalPages) ? ($currentPage + 1) : $totalPages; ?>">Next</a>
              </li>
          </ul>
      </nav>
</main>

<!-- Popup Add/Edit product -->
<div class="modal fade" id="addEditProductModal" tabindex="-1" role="dialog" aria-labelledby="addEditProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEditProductModalLabel">Add/Edit Product</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addEditProductForm" action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" id="productIdHidden" name="productguid">
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" data-dismiss="modal" id="EdidAddButton" form="addEditProductForm">Save</button>
      </div>
    </div>
  </div>
</div>


<!-- ModalDeleted -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <span style="font-weight: bold;" id="DeleteProductName"></span> product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="DeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>


<script>
// Open popup to add new product
function openAddProductModal() {
    document.getElementById('addEditProductModalLabel').textContent = 'Add Product';
    document.getElementById('productIdHidden').value = ''; // Reset hidden input
    document.getElementById('productCode').value = '';
    document.getElementById('productName').value = '';
    document.getElementById('productType').value = '';
    document.getElementById('productQuantity').value = '';
    document.getElementById('productSupplier').value = '';
    document.getElementById('productImage').value = ''; // Reset file input
}

// Open popup to edit product
//openEditProductModal(\"{$product['product_guid']}\",\"{$product['product_code']}\", \"{$product['product_name']}\", \"{$product['category_name']}\", {$product['stock']}, \"{$product['supplier_name']}\")
function openEditProductModal(product_guid, product_code, product_name, category_name, stock, supplier_name) {
    document.getElementById('addEditProductModalLabel').textContent = 'Edit Product';
    document.getElementById('productIdHidden').value = product_guid; // Set hidden input to product ID
    document.getElementById('productCode').value = product_code;
    document.getElementById('productName').value = product_name;
    document.getElementById('productType').value = category_name;
    document.getElementById('productQuantity').value = stock;
    document.getElementById('productSupplier').value = supplier_name;
    // document.getElementById('productImage').value = ''; // Do not pre-fill file input
}

function openDeleteProductModal(product_guid, product_name) {
    //Input name to modal.
    document.getElementById('DeleteProductName').textContent = product_name;
    // Save ID to button Delete.
    var DeteteButton = document.getElementById('DeleteButton');
    DeteteButton.setAttribute('product_guid', product_guid);
}

        document.getElementById('DeleteButton').addEventListener('click', function() {
            var product_guid = this.getAttribute('product_guid');
            // Call function Delete
            fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'delete_product=' + encodeURIComponent(product_guid),
                })
                .then(response => response.text())
                .then(data => {
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
</script>

<?php 
include_once __DIR__ . '/../Public/footer.php'; 
?>