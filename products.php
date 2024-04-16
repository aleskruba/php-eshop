<?php
require_once 'includes/db.inc.php';

// Retrieve search query from URL parameter
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination
$productPerPage = 5;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $productPerPage;

try {
    // Query to fetch data from the products table
    $sql = "SELECT * FROM products";

    // Prepare and execute the query
    $stmt = $pdo->query($sql);

    // Fetch all rows as an associative array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Filter products based on search query
    $filteredProducts = [];
    if (!empty($searchQuery)) {
        foreach ($products as $product) {
            // Check if the product model contains the search query
            if (stripos($product['model'], $searchQuery) !== false) {
                $filteredProducts[] = $product;
            }
        }
    } else {
        // If no search query, use all products
        $filteredProducts = $products;
    }

    // Paginate the filtered products
    $paginateMProducts = array_slice($filteredProducts, $offset, $productPerPage);

    // Initialize cart as an empty array if it's not set in localStorage
    $cart = json_decode($_COOKIE['cart'] ?? '[]', true);

    // Display the search form
    echo "<div class='product-search-div'>";
    echo "<form action='' method='GET'>";
    echo "<input class='product-search-input' placeholder='Search for product' value='" . htmlspecialchars($searchQuery) . "' name='search'/>";
    echo "<input class='product-search-button' type='submit' value='Search'/>";
    echo "</form>";
    echo "</div>";

    // Check if there are any products
    if (!empty($paginateMProducts)) {
        echo "<div class='products'>";
        // Loop through the products and display the data
        foreach ($paginateMProducts as $product) {
            echo "<a href='product.php?id=" . $product['id'] . "' class='product-link'>";
            echo "<div class='product'>";
            echo "<div class='imgDiv'>";
            echo "<img src='" . $product['img'] . "' alt='" . $product['model'] . "' class='img'>";
            echo "</div>";
            echo "<div class='modelDiv'>";
            echo "<h3>" . $product['model'] . "</h3>";
            echo "</div>";
            echo "<div class='descriptionDiv'>";
            echo "<p class='description'>" . (strlen($product['description']) > 100 ? substr($product['description'], 0, 100) . "..." : $product['description']) . "</p>";
            echo "</div>";
            echo "<p class='price'>$" . $product['price'] . "</p>";
            echo "<p class='stock'>In Stock: " . $product['stock'] . "</p>";
            echo "<button class='buy-button' id='" . $product["id"] . "' onclick='addToCartMain(" . $product['id'] . ", " . $product['stock'] . ", " . $product['price'] . ", \"" . $product['model'] . "\", \"" . htmlspecialchars(addslashes($product['description'])) . "\", \"" . htmlspecialchars(addslashes($product['img'])) . "\")'>Buy</button>";
            echo "</div>";
            echo "</a>";
        }
        echo "</div>";

        // Display pagination links based on total products count
        echo "<div class='pagination'>";
        $totalPages = ceil(count($filteredProducts) / $productPerPage);
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i > 1 || $totalPages > 1) {
                echo "<a href='?search=$searchQuery&page=$i'>$i</a>";
            }
        }
        echo "</div>";
    } else {
        echo "No products found.";
    }
} catch (PDOException $e) {
    die("Error: Could not execute query. " . $e->getMessage());
}

// Close the database connection
unset($pdo);
?>
