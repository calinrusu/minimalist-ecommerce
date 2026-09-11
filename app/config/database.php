<?php
// app/config/database.php

function getStoreFilePath(): string
{
    $directory = dirname(DB_PATH);
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    return DB_PATH;
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
            ],
            'orders' => [],
        ];
        saveStore($store);
        return $store;
    }

    $contents = file_get_contents($storeFile);
    if ($contents === false || trim($contents) === '') {
        $store = ['products' => [], 'orders' => []];
        saveStore($store);
        return $store;
    }

    $decoded = json_decode($contents, true);
    if (!is_array($decoded)) {
        $decoded = ['products' => [], 'orders' => []];
    }

    if (!isset($decoded['products']) || !is_array($decoded['products'])) {
        $decoded['products'] = [];
    }

    if (!isset($decoded['orders']) || !is_array($decoded['orders'])) {
        $decoded['orders'] = [];
    }

    return $decoded;
}

function saveStore(array $store): void
{
    file_put_contents(getStoreFilePath(), json_encode($store, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
}

function getDatabaseConnection(): ?PDO
{
    static $pdo = null;

    if ($pdo !== null) {
        return $pdo;
    }

    if (DB_MODE !== 'mysql') {
        return null;
    }

    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        return null;
    }

    return $pdo;
}

function initializeDatabase(): void
{
    $pdo = getDatabaseConnection();
    if (!$pdo) {
        return;
    }

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            description TEXT,
            image VARCHAR(255) DEFAULT NULL,
            category VARCHAR(100) NOT NULL DEFAULT "General"
        ) ENGINE=InnoDB'
    );

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            customer_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            address TEXT NOT NULL,
            items LONGTEXT NOT NULL,
            total DECIMAL(10,2) NOT NULL,
            status VARCHAR(50) NOT NULL DEFAULT "Pending",
            created_at DATETIME NOT NULL
        ) ENGINE=InnoDB'
    );

    $count = (int) $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
    if ($count === 0) {
        $stmt = $pdo->prepare('INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)');
        $seedProducts = [
            ['Classic Hoodie', 29.90, 'Soft cotton hoodie in a neutral color.', 'hoodie.svg', 'Apparel'],
            ['Minimal Backpack', 49.50, 'Compact backpack for daily use.', 'backpack.svg', 'Accessories'],
            ['Ceramic Mug', 14.99, 'Warm mug with a modern glaze finish.', 'mug.svg', 'Home'],
        ];

        foreach ($seedProducts as $product) {
            $stmt->execute($product);
        }
    }
}

function getProducts(): array
{
    initializeDatabase();
    $pdo = getDatabaseConnection();

    if ($pdo) {
        $stmt = $pdo->query('SELECT * FROM products ORDER BY id ASC');
        return $stmt->fetchAll();
    }

    $store = loadStore();
    return $store['products'] ?? [];
}

function searchProducts(string $term, string $category = ''): array
{
    $normalized = trim($term);
    $categoryFilter = trim($category);

    initializeDatabase();
    $pdo = getDatabaseConnection();

    if ($pdo) {
        if ($normalized !== '' && $categoryFilter !== '') {
            $search = '%' . $normalized . '%';
            $stmt = $pdo->prepare('SELECT * FROM products WHERE (name LIKE ? OR description LIKE ?) AND category = ? ORDER BY id ASC');
            $stmt->execute([$search, $search, $categoryFilter]);
            return $stmt->fetchAll();
        }

        if ($normalized !== '') {
            $search = '%' . $normalized . '%';
            $stmt = $pdo->prepare('SELECT * FROM products WHERE name LIKE ? OR description LIKE ? ORDER BY id ASC');
            $stmt->execute([$search, $search]);
            return $stmt->fetchAll();
        }

        if ($categoryFilter !== '') {
            $stmt = $pdo->prepare('SELECT * FROM products WHERE category = ? ORDER BY id ASC');
            $stmt->execute([$categoryFilter]);
            return $stmt->fetchAll();
        }

        $stmt = $pdo->query('SELECT * FROM products ORDER BY id ASC');
        return $stmt->fetchAll();
    }

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
    initializeDatabase();
    $pdo = getDatabaseConnection();

    if ($pdo) {
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$productId]);
        $product = $stmt->fetch();
        return $product ?: null;
    }

    foreach (getProducts() as $product) {
        if ((int) $product['id'] === $productId) {
            return $product;
        }
    }

    return null;
}

function createProductInStorage(string $name, float $price, string $description, string $image): void
{
    initializeDatabase();
    $pdo = getDatabaseConnection();

    if ($pdo) {
        $stmt = $pdo->prepare('INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $price, $description, $image]);
        return;
    }

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
    initializeDatabase();
    $pdo = getDatabaseConnection();

    if ($pdo) {
        $stmt = $pdo->prepare('UPDATE products SET name = ?, price = ?, description = ?, image = ? WHERE id = ?');
        $stmt->execute([$data['name'], $data['price'], $data['description'], $data['image'], $productId]);
        return;
    }

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
    initializeDatabase();
    $pdo = getDatabaseConnection();

    if ($pdo) {
        $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
        $stmt->execute([$productId]);
        return;
    }

    $store = loadStore();
    $store['products'] = array_values(array_filter($store['products'], static function (array $product) use ($productId): bool {
        return (int) $product['id'] !== $productId;
    }));

    saveStore($store);
}

function createOrderInStorage(string $customerName, string $email, string $address, array $items, float $total): int
{
    initializeDatabase();
    $pdo = getDatabaseConnection();

    if ($pdo) {
        $stmt = $pdo->prepare('INSERT INTO orders (customer_name, email, address, items, total, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$customerName, $email, $address, json_encode($items, JSON_UNESCAPED_UNICODE), $total, 'Pending', date('Y-m-d H:i:s')]);
        return (int) $pdo->lastInsertId();
    }

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
    initializeDatabase();
    $pdo = getDatabaseConnection();

    if ($pdo) {
        $stmt = $pdo->prepare('UPDATE orders SET status = ? WHERE id = ?');
        $stmt->execute([$status, $orderId]);
        return;
    }

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
    initializeDatabase();
    $pdo = getDatabaseConnection();

    if ($pdo) {
        $stmt = $pdo->query('SELECT * FROM orders ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    $store = loadStore();
    return array_reverse($store['orders'] ?? []);
}
