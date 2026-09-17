<?php

function addToCart(int $productId, int $quantity = 1): void
{
    $cart = $_SESSION['cart'] ?? [];
    $cart[$productId] = (int) ($cart[$productId] ?? 0) + $quantity;
    $_SESSION['cart'] = $cart;
}

function updateCartQuantity(int $productId, int $quantity): void
{
    $cart = $_SESSION['cart'] ?? [];

    if ($quantity <= 0) {
        unset($cart[$productId]);
    } else {
        $cart[$productId] = $quantity;
    }

    $_SESSION['cart'] = $cart;
}

function removeFromCart(int $productId): void
{
    $cart = $_SESSION['cart'] ?? [];
    unset($cart[$productId]);
    $_SESSION['cart'] = $cart;
}

function clearCart(): void
{
    unset($_SESSION['cart']);
}

function setFlashMessage(string $message): void
{
    $_SESSION['flash'] = $message;
}

function addToWishlist(int $productId): void
{
    $customer = $_SESSION['customer'] ?? null;
    if (!$customer || empty($customer['logged_in'])) {
        return;
    }

    $wishlist = $_SESSION['wishlist'] ?? [];
    $wishlist[$productId] = true;
    $_SESSION['wishlist'] = $wishlist;
}

function removeFromWishlist(int $productId): void
{
    $wishlist = $_SESSION['wishlist'] ?? [];
    unset($wishlist[$productId]);
    $_SESSION['wishlist'] = $wishlist;
}

function getWishlistItems(): array
{
    $wishlist = $_SESSION['wishlist'] ?? [];
    if (empty($wishlist)) {
        return [];
    }

    $items = [];
    foreach (getProducts() as $product) {
        $productId = (int) $product['id'];
        if (isset($wishlist[$productId])) {
            $items[] = $product;
        }
    }

    return $items;
}

function getDiscountForCoupon(string $couponCode): float
{
    $code = strtoupper(trim($couponCode));
    $coupons = [
        'SAVE10' => 0.10,
        'WELCOME20' => 0.20,
        'SPRING15' => 0.15,
    ];

    return $coupons[$code] ?? 0.0;
}

function applyCoupon(string $couponCode): float
{
    $discount = getDiscountForCoupon($couponCode);
    $_SESSION['coupon'] = $discount > 0 ? strtoupper(trim($couponCode)) : '';
    return $discount;
}

function getAppliedCoupon(): string
{
    return $_SESSION['coupon'] ?? '';
}

function getDiscountAmount(float $subtotal): float
{
    $coupon = getAppliedCoupon();
    if ($coupon === '') {
        return 0.0;
    }

    return round($subtotal * getDiscountForCoupon($coupon), 2);
}

function getFinalTotal(float $subtotal): float
{
    return round($subtotal - getDiscountAmount($subtotal), 2);
}

function createProduct(string $name, float $price, string $description, string $image): void
{
    createProductInStorage($name, $price, $description, $image);
}

function searchCatalog(string $term, string $category = ''): array
{
    return searchProducts($term, $category);
}

function updateProduct(int $productId, array $data): void
{
    updateProductInStorage($productId, $data);
}

function deleteProduct(int $productId): void
{
    deleteProductFromStorage($productId);
}

function isAdminLoggedIn(): bool
{
    return !empty($_SESSION['is_admin']);
}

function loginAdmin(string $username, string $password): bool
{
    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION['is_admin'] = true;
        return true;
    }

    return false;
}

function logoutAdmin(): void
{
    unset($_SESSION['is_admin']);
}

function getCartSummary(): array
{
    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) {
        return ['items' => [], 'total' => 0];
    }

    $products = getProducts();
    $productMap = [];
    foreach ($products as $product) {
        $productMap[(int) $product['id']] = $product;
    }

    $items = [];
    $total = 0;

    foreach ($cart as $productId => $quantity) {
        if (!isset($productMap[$productId])) {
            continue;
        }

        $product = $productMap[$productId];
        $quantity = (int) $quantity;
        $lineTotal = (float) $product['price'] * $quantity;
        $total += $lineTotal;

        $items[] = [
            'id' => (int) $product['id'],
            'name' => $product['name'],
            'price' => (float) $product['price'],
            'quantity' => $quantity,
            'line_total' => $lineTotal,
        ];
    }

    return ['items' => $items, 'total' => $total];
}

function createOrder(string $customerName, string $email, string $address): int
{
    $summary = getCartSummary();
    return createOrderInStorage($customerName, $email, $address, $summary['items'], $summary['total']);
}

function updateOrderStatus(int $orderId, string $status): void
{
    updateOrderStatusInStorage($orderId, $status);
}

function getOrders(): array
{
    return getOrdersFromStorage();
}

function formatOrderItems(mixed $items): string
{
    if (is_string($items)) {
        $decoded = json_decode($items, true);
        if (is_array($decoded)) {
            $items = $decoded;
        }
    }

    if (!is_array($items)) {
        return '';
    }

    $display = [];
    foreach ($items as $item) {
        if (!is_array($item)) {
            continue;
        }

        $display[] = ($item['quantity'] ?? 1) . '× ' . ($item['name'] ?? 'item');
    }

    return implode(', ', $display);
}

function getReviewsForProduct(int $productId): array
{
    $store = loadStore();
    $reviews = $store['reviews'] ?? [];
    $productReviews = [];

    foreach ($reviews as $review) {
        if ((int) ($review['product_id'] ?? 0) === $productId) {
            $productReviews[] = $review;
        }
    }

    return $productReviews;
}

function addReview(int $productId, string $author, string $comment, int $rating): void
{
    $store = loadStore();
    $store['reviews'][] = [
        'product_id' => $productId,
        'author' => $author,
        'comment' => $comment,
        'rating' => max(1, min(5, $rating)),
        'created_at' => date('Y-m-d H:i:s'),
    ];

    saveStore($store);
}
