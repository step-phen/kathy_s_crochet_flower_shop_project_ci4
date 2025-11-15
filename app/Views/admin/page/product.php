<?= $this->extend('admin/layouts/page-layout') ?>
<?= $this->section('content') ?>

<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h2 fw-bold mb-1">Product Management</h1>
        <p class="text-muted mb-0">
            <i class="bi bi-box-seam me-1"></i>
            View and manage your products
        </p>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Product List <span class="badge bg-info ms-2" id="productCount"></span></h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="bi bi-plus-lg"></i> Add Product
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="productTable" class="table table-hover table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($products) && is_array($products)): ?>
                                <?php foreach ($products as $prod): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <?php if (!empty($prod['image'])): ?>
                                                    <img src="<?= base_url($prod['image']) ?>" alt="Product Image" style="width:80px;height:80px;object-fit:cover;">
                                                <?php endif; ?>
                                                <div>
                                                    <div class="fw-bold mb-1"><?= esc($prod['product_name']) ?></div>
                                                    <div class="text-muted small">ID: <?= esc($prod['product_id']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $catName = $prod['category_id'];
                                            if (isset($categories) && is_array($categories)) {
                                                foreach ($categories as $cat) {
                                                    if ($cat['category_id'] == $prod['category_id']) {
                                                        $catName = $cat['category_name'];
                                                        break;
                                                    }
                                                }
                                            }
                                            echo esc($catName);
                                            ?>
                                        </td>
                                        <td class="text-center"><?= esc($prod['price']) ?></td>
                                        <td class="text-center"><?= esc($prod['stock']) ?></td>
                                        <td>
                                            <?php
                                            $stock = intval($prod['stock']);
                                            if ($stock > 20) {
                                                echo '<small class="badge bg-success">High Stock</small>';
                                            } elseif ($stock > 0) {
                                                echo '<small class="badge bg-warning text-dark">Low Stock</small>';
                                            } else {
                                                echo '<small class="badge bg-danger">Out of Stock</small>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-xs btn-outline-primary p-1" title="update Product">
                                                <i class="bi bi-pencil" style="font-size:0.9em;"></i>
                                            </button>
                                            <button class="btn btn-xs btn-outline-info p-1 view-product-btn" title="View Details"
                                                data-product='<?= json_encode([
                                                                    "product_id" => $prod["product_id"],
                                                                    "product_name" => $prod["product_name"],
                                                                    "category_id" => $prod["category_id"],
                                                                    "price" => $prod["price"],
                                                                    "stock" => $prod["stock"],
                                                                    "description" => $prod["description"],
                                                                    "image" => $prod["image"]
                                                                ]) ?>'>
                                                <i class="bi bi-eye" style="font-size:0.9em;"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Category Table below Product List -->
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Manage Categories</h6>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="bi bi-plus-lg"></i> Add
                </button>
            </div>
            <div class="card-body">
                <!-- Add Category Modal -->
                <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="addCategoryForm">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="categoryName" class="form-label">Category Name</label>
                                        <input type="text" class="form-control" id="categoryName" name="category_name" placeholder="Enter category name" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" type="submit">Add Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <table class="table table-hover table-sm align-middle" id="categoryTable">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Category Name</th>
                            <th class="text-center">created_at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($categories) && is_array($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td class="text-center"><?= esc($cat['category_id']) ?></td>
                                    <td class="text-center"><?= esc($cat['category_name']) ?></td>
                                    <td class="text-center"><?= esc(date('M. j, Y', strtotime($cat['created_at']))) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addProductForm" enctype="multipart/form-data">
                <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                    <div class="mb-3">
                        <label for="productImage" class="form-label">Image</label>
                        <input type="file" class="form-control" id="productImage" name="image" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="productCategory" class="form-label">Category</label>
                        <select class="form-select" id="productCategory" name="category" required>
                            <option value="" disabled selected>Select category</option>
                            <?php if (isset($categories) && is_array($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= esc($cat['category_id']) ?>"><?= esc($cat['category_name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="productDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="productDescription" name="description" rows="5" placeholder="Enter product description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="productPrice" name="price" min="0" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="productStock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="productStock" name="stock" min="0" step="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Product Modal (single instance, outside table loop) -->
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <div class="modal-title" id="viewProductModalLabel">
                    <i class="bi bi-box-seam me-2"></i> Product Details
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4 px-4">
                <div class="row g-4 align-items-center">
                    <div class="col-md-4 text-center">
                        <img id="viewProductImage" src="" alt="Product Image" class="rounded border shadow-sm mb-3" style="max-width:180px;max-height:180px;object-fit:cover;">
                        <div class="mt-2">
                            <span class="text-dark" id="viewProductStock"></span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h3 id="viewProductName" class="fw-bold mb-2"></h3>
                        <div class="mb-2 text-muted small">
                            <i class="bi bi-hash"></i> <span id="viewProductId"></span>
                        </div>
                        <div class="mb-2">
                            <i class="bi bi-tags"></i> Category:
                            <span id="viewProductCategory" class="fw-semibold"></span>
                        </div>
                        <div class="mb-2">
                            <i class="bi bi-cash-stack"></i> Price:
                            <span class="fw-bold text-success">₱<span id="viewProductPrice"></span></span>
                        </div>
                        <div class="mb-2">
                            <i class="bi bi-clipboard-data"></i> Stock:
                            <span id="viewProductStockCount"></span>
                        </div>
                        <div class="mb-2">
                            <i class="bi bi-card-text"></i> Description:
                        </div>
                        <div id="viewProductDescription" class="border rounded p-3 bg-light small"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Helper function to get base URLs safely
        const productListUrl = '<?= base_url('admin/product/list') ?>?withCount=1';
        const productAddUrl = '<?= base_url('admin/product/add') ?>';
        const categoryAddUrl = '<?= base_url('admin/category/add') ?>';

        // DataTable options reused for re-init
        const dataTableOptions = {
            paging: true,
            searching: true,
            info: true,
            lengthChange: true,
            pageLength: 10,
            order: [
                [0, 'desc']
            ], // Sort by ID descending
            language: {
                search: "Search products:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ products",
                paginate: {
                    previous: "<",
                    next: ">"
                }
            }
        };

        // Only init DataTable once; refresh will reinit
        let productTable = $('#productTable').DataTable(dataTableOptions);

        // Function to refresh product table and count via AJAX
        function refreshProductTable() {
            // Destroy datatable first, otherwise error when reinit
            if ($.fn.DataTable.isDataTable('#productTable')) {
                productTable.destroy();
            }
            fetch(productListUrl)
                .then(response => response.json())
                .then(data => {
                    // Replace tbody with new rows
                    const tbody = document.querySelector('#productTable tbody');
                    if (data.html) {
                        tbody.innerHTML = data.html;
                    } else {
                        tbody.innerHTML = '<tr><td colspan="100%">No products found.</td></tr>';
                    }
                    // Update product count
                    if (data.count !== undefined) {
                        document.getElementById('productCount').textContent = data.count;
                    }
                    // Re-initialize DataTable
                    productTable = $('#productTable').DataTable(dataTableOptions);
                }).catch(() => {
                    Swal && Swal.fire ?
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Could not refresh product table.'
                        }) :
                        alert('Could not refresh product table.');
                });
        }

        // Show category name in modal (not just ID)
        $(document).on('click', '.view-product-btn', function() {
            const prod = $(this).data('product');
            $('#viewProductImage').attr(
            'src', prod.image ?
            ('<?= base_url() ?>/' + prod.image) :
            'https://via.placeholder.com/180x180?text=No+Image'
            );
            $('#viewProductName').text(prod.product_name || 'No name');
            $('#viewProductId').text(prod.product_id || '');

            // Find category name from categories array (embedded in page)
            let categoryName = '';
            <?php if (isset($categories) && is_array($categories)): ?>
            const categories = <?= json_encode($categories) ?>;
            const foundCat = categories.find(c => c.category_id == prod.category_id);
            categoryName = foundCat ? foundCat.category_name : prod.category_id;
            <?php else: ?>
            categoryName = prod.category_id;
            <?php endif; ?>
            $('#viewProductCategory').text(categoryName);

            $('#viewProductPrice').text(prod.price !== undefined ? prod.price : '');
            $('#viewProductStockCount').text(prod.stock !== undefined ? prod.stock : '');
            // Stock badge logic
            let stockBadge = '';
            const stock = parseInt(prod.stock, 10);
            if (stock > 20) {
            stockBadge = '<span class="badge bg-success">High Stock</span>';
            } else if (stock > 0) {
            stockBadge = '<span class="badge bg-warning text-dark">Low Stock</span>';
            } else {
            stockBadge = '<span class="badge bg-danger">Out of Stock</span>';
            }
            $('#viewProductStock').html(stockBadge);
            $('#viewProductDescription').text(prod.description || 'No description');
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('viewProductModal'));
            modal.show();
        });

        // Product Add Logic
        const addProductForm = document.getElementById('addProductForm');
        if (addProductForm) {
            addProductForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(addProductForm);
                fetch(productAddUrl, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            if (window.Swal) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            } else {
                                alert(data.message);
                            }
                            addProductForm.reset();
                            const modal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
                            if (modal) modal.hide();
                            refreshProductTable(); // Dynamically update product table and count
                        } else {
                            if (window.Swal) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message || 'Failed to add product.'
                                });
                            } else {
                                alert(data.message || 'Failed to add product.');
                            }
                        }
                    })
                    .catch(() => {
                        if (window.Swal) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while adding the product.'
                            });
                        } else {
                            alert('An error occurred while adding the product.');
                        }
                    });
            });
        }

        // Category Add Logic — submit via AJAX and update DOM without reloading
        const addCategoryForm = document.getElementById('addCategoryForm');
        if (addCategoryForm) {
            // simple HTML-escape helper
            const escapeHtml = (unsafe) => {
                return unsafe
                    .replaceAll('&', '&amp;')
                    .replaceAll('<', '&lt;')
                    .replaceAll('>', '&gt;')
                    .replaceAll('"', '&quot;')
                    .replaceAll("'", '&#039;');
            };

            const formatDate = (isoString) => {
                try {
                    const d = new Date(isoString);
                    return d.toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' });
                } catch (e) {
                    return isoString;
                }
            };

            addCategoryForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(addCategoryForm);
                fetch(categoryAddUrl, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const newCat = data.category;
                            // Add new row to category table (prepend)
                            const tbody = document.querySelector('#categoryTable tbody');
                            const rowHtml = `\n<tr>\n<td class="text-center">${escapeHtml(String(newCat.category_id))}</td>\n<td class="text-center">${escapeHtml(newCat.category_name)}</td>\n<td class="text-center">${escapeHtml(formatDate(newCat.created_at))}</td>\n</tr>`;
                            if (tbody) tbody.insertAdjacentHTML('afterbegin', rowHtml);

                            // Add option to productCategory select
                            const productCategory = document.getElementById('productCategory');
                            if (productCategory) {
                                const opt = document.createElement('option');
                                opt.value = newCat.category_id;
                                opt.textContent = newCat.category_name;
                                // insert at top after placeholder
                                productCategory.appendChild(opt);
                            }

                            if (window.Swal) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'New Category Added',
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }

                            addCategoryForm.reset();
                            const modal = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
                            if (modal) modal.hide();
                        } else {
                            if (window.Swal) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message || 'Failed to add category.'
                                });
                            } else {
                                alert(data.message || 'Failed to add category.');
                            }
                        }
                    })
                    .catch(() => {
                        if (window.Swal) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while adding the category.'
                            });
                        } else {
                            alert('An error occurred while adding the category.');
                        }
                    });
            });
        }
    });
</script>
<?= $this->endSection() ?>