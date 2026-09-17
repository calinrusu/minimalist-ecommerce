<?php

function getStoreFilePath(): string
{
    if (!is_dir(DB_PATH)) {
        mkdir(DB_PATH, 0777, true);
    }
    return DB_PATH . '/products.json';
}

function loadAdminList(): array
{
	$contents = file_get_contents(DB_PATH . '/admins.json');
	return json_decode($contents, true);
}

function loadStore(): array
{
    $storeFile = getStoreFilePath();

    if (!file_exists($storeFile)) {
        $store = [
            'products' => [
                ['id' => 1, 'name' => 'Classic Hoodie', 'price' => 29.90, 'description' => 'Soft cotton hoodie in a neutral color.', 'image' => 'hoodie.svg'],
                ['id' => 2, 'name' => 'Minimal Backpack', 'price' => 49.50, 'description' => 'Compact backpack for daily use.', 'image' => 'backpack.svg'],
                ['id' => 3, 'name' => 'Ceramic Mug', 'price' => 14.99, 'description' => 'Warm mug with a modern glaze finish.', 'image' => 'mug.svg'],
            ]
        ];
        saveStore($store);
        return $store;
    }

    $contents = file_get_contents($storeFile);
    if ($contents === false || trim($contents) === '') {
        $store = ['products' => []];
        saveStore($store);
        return $store;
    }

    $decoded = json_decode($contents, true);
    if (!is_array($decoded)) {
        $decoded = ['products' => []];
    }

    if (!isset($decoded['products']) || !is_array($decoded['products'])) {
        $decoded['products'] = [];
    }

    return $decoded['products'];
}

function saveStore(array $store): void
{
    file_put_contents(getStoreFilePath(), json_encode($store, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
}

function getProducts(): array
{
    $store = loadStore();
    return $store['products'] ?? [];
}

function searchProducts(string $term, string $category = ''): array
{
    $normalized = trim($term);
    $categoryFilter = trim($category);



    $products = getProducts();
    $filtered = [];
    foreach ($products as $product) {
        $matchesCategory = $categoryFilter === '' || strtolower($product['category'] ?? 'General') === strtolower($categoryFilter);
        $matchesTerm = $normalized === '' || str_contains(strtolower($product['name'] . ' ' . ($product['description'] ?? '')), strtolower($normalized));

        if ($matchesCategory && $matchesTerm) {
            $filtered[] = $product;
        }
    }

    return $filtered;
}

function getProductById(int $productId): ?array
{
    foreach (getProducts() as $product) {
        if ((int) $product['id'] === $productId) {
            return $product;
        }
    }

    return null;
}

function createProductInStorage(string $name, float $price, string $description, string $image): void
{
    $store = loadStore();
    $nextId = 1;
    foreach ($store['products'] as $product) {
        $nextId = max($nextId, (int) $product['id'] + 1);
    }

    $store['products'][] = [
        'id' => $nextId,
        'name' => $name,
        'price' => $price,
        'description' => $description,
        'image' => $image,
    ];

    saveStore($store);
}

function updateProductInStorage(int $productId, array $data): void
{
    $store = loadStore();
    foreach ($store['products'] as &$product) {
        if ((int) $product['id'] === $productId) {
            $product['name'] = $data['name'];
            $product['price'] = (float) $data['price'];
            $product['description'] = $data['description'];
            $product['image'] = $data['image'];
            break;
        }
    }

    saveStore($store);
}

function deleteProductFromStorage(int $productId): void
{
    $store = loadStore();
    $store['products'] = array_values(array_filter($store['products'], static function (array $product) use ($productId): bool {
        return (int) $product['id'] !== $productId;
    }));

    saveStore($store);
}

function createOrderInStorage(string $customerName, string $email, string $address, array $items, float $total): int
{
    $store = loadStore();
    $orderId = count($store['orders']) + 1;
    $store['orders'][] = [
        'id' => $orderId,
        'customer_name' => $customerName,
        'email' => $email,
        'address' => $address,
        'items' => $items,
        'total' => $total,
        'status' => 'Pending',
        'created_at' => date('Y-m-d H:i:s'),
    ];

    saveStore($store);

    return $orderId;
}

function updateOrderStatusInStorage(int $orderId, string $status): void
{
    $store = loadStore();
    foreach ($store['orders'] as &$order) {
        if ((int) $order['id'] === $orderId) {
            $order['status'] = $status;
            break;
        }
    }

    saveStore($store);
}

function getOrdersFromStorage(): array
{
    $store = loadStore();
    return array_reverse($store['orders'] ?? []);
}
