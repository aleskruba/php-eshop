<?php
session_start();
include 'head.php'; 
include 'navbar.php';
require_once 'includes/db.inc.php';

if (!(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1)) {
    header("Location: login.php");
    exit;
} else {
    $current_user_email = $_SESSION["user_email"];
}

// Retrieve all products initially
$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle search query
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination
$productPerPage = 5;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $productPerPage;



$filteredProducts = [];
if (!empty($searchQuery)) {
    foreach ($products as $product) {

        $searchQueryLower = strtolower($searchQuery);
        $productModelLower = strtolower($product['model']);
        

        $queryChars = str_split($searchQueryLower);
        $modelChars = str_split($productModelLower);
        $queryIndex = 0;
        foreach ($modelChars as $char) {
            if ($queryIndex < strlen($searchQueryLower) && $char === $queryChars[$queryIndex]) {
                $queryIndex++;
            }
        }
  
        if ($queryIndex === strlen($searchQueryLower)) {
            $filteredProducts[] = $product;
        }
    }
} else {
  
    $filteredProducts = $products;
}

// Paginate the filtered products
$paginateMProducts = array_slice($filteredProducts, $offset, $productPerPage);
?>

<div class="productscontainer">

<div class="product-search">
    <!-- Search form -->
    <form action="" method="GET">
        <input class='product-search-input' placeholder='Search product' value='<?php echo $searchQuery; ?>' name='search'/>
        <input class='product-search-button' type='submit' value='Search'/>
    </form>
</div>

<?php
if ($paginateMProducts) {
    echo "<div class='products-main' id='products'>";
    foreach ($paginateMProducts as $product) {
        echo "<a href='adminproduct.php?id={$product['id']}' class='product-a'>";
        echo "<div  class='product-inner-div'>";
        echo "<div class='product-model'>{$product['model']}</div>";
        echo "<div class='product-right'>";
        echo "<div class='product-stock'>Stock : {$product['stock']}</div>";
        echo "<div class='product-price'>Price : {$product['price']}</div>";
        echo "</div>";
        echo "</div>";
        echo "</a>";
    }

    echo "</div>";

    // Pagination controls
    echo "<div class='pagination'>";
    $totalPages = ceil(count($filteredProducts) / $productPerPage);
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i > 1 || $totalPages > 1) {
            echo "<a href='?search=$searchQuery&page=$i'>$i</a>";
        }
    }
    echo "</div>";
} else {
    echo "<p>No products found.</p>";
}
?>

</div>
