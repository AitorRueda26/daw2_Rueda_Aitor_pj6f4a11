<?php
require_once __DIR__ . '/functions.php';

$orders = readOrders(__DIR__ . '/../orders/orders.json');

$codi = isset($_GET['codi']) ? trim($_GET['codi']) : '';

if ($codi !== '') {
    $orders = array_values(array_filter($orders, function ($o) use ($codi) {
        return isset($o['codi']) && trim((string) $o['codi']) === $codi;
    }));

    if (count($orders) === 0) {
        renderError(404, 'Order not found', 'No order exists with code "' . $codi . '"');
    }
}

http_response_code(200);
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bakery commands</title>
    <link rel="stylesheet" href="../client/form.css">
    <style>
        body {
    font-family: Arial, Helvetica, sans-serif;
    margin: 30px auto;
    max-width: 1100px;
    color: #222;
}

h1 {
    text-align: center;
}

table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ccc;
    padding: 8px 12px;
    text-align: left;
    vertical-align: top;
}

th {
    background: #f2f2f2;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

tbody tr:nth-child(even) {
    background: #fafafa;
}

tbody tr:hover {
    background: #eef4ff;
}

/* Las tres columnas de dinero: alineadas a la derecha y sin partirse */
td.num, th.num {
    text-align: right;
    white-space: nowrap;
}

/* La columna de productos no se estira más de la cuenta */
td ul {
    margin: 0;
    padding-left: 18px;
}

td ul li {
    margin-bottom: 4px;
}

    </style>
</head>
<body>

<h1>Bakery Commands</h1>

<form method="get" action="">
    <label for="codi">Order code:</label>
    <input type="text" id="codi" name="codi" value="<?= htmlspecialchars($codi) ?>" autofocus>
    <button type="submit">Search</button>
</form>
<br>

<table>
    <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Telephone</th>
            <th>Products</th>
            <th>Subtotal</th>
            <th>IVA</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['codi'] ?? '') ?></td>
                <td><?= htmlspecialchars($c['nom'] ?? '') ?></td>
                <td><?= htmlspecialchars($c['adreca'] ?? '') ?></td>
                <td><?= htmlspecialchars($c['email'] ?? '') ?></td>
                <td><?= htmlspecialchars($c['telefon'] ?? '') ?></td>
                <td>
                    <?php if (!empty($c['productes'])): ?>
                        <ul>
                            <?php foreach ($c['productes'] as $p): ?>
                                <li>
                                    <?= htmlspecialchars($p['producte'] ?? '') ?>
                                    — <?= (int) ($p['quantitat'] ?? 0) ?> x <?= number_format((float) ($p['import'] ?? 0), 2) ?> €
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <em>No products</em>
                    <?php endif; ?>
                </td>
                <td class="num"><?= number_format((float) ($c['subtotal'] ?? 0), 2) ?> €</td>
                <td class="num"><?= number_format((float) ($c['iva'] ?? 0), 2) ?> €</td>
                <td class="num"><strong><?= number_format((float) ($c['total'] ?? 0), 2) ?> €</strong></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>

