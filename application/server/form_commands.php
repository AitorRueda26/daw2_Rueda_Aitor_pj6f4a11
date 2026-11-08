<?php
// Ruta absoluta al JSON, partiendo de la carpeta del propio PHP
$fitxer = '../orders/orders.json';
$orders = file_exists($file) ? readOrders($file) : [];


// 1. Leer lo que ya hay (si el archivo no existe, array vacío)
$comandes = [];
if (file_exists($fitxer)) {
    $contingut = file_get_contents($fitxer);
    $comandes = json_decode($contingut, true) ?: [];
}

// 2. Productos: precio y nombre según el índice del checkbox
$cataleg = [
    0 => ['producte' => 'Red velvet',    'preu' => 10.00],
    1 => ['producte' => 'Cheesecake',    'preu' => 15.50],
    2 => ['producte' => 'chocolate cake','preu' => 15.75],
    3 => ['producte' => 'lemon cake',    'preu' => 8.99],
];

// 3. Recoger los productos con cantidad > 0
$productes = [];
$subtotal  = 0;

foreach ($cataleg as $i => $p) {
    $q = (int) ($_POST["quantitat$i"] ?? 0);

    if ($q > 0) {
        $import = $q * $p['preu'];
        $productes[] = [
            'producte'  => $p['producte'],
            'quantitat' => $q,
            'import'    => round($import, 2),
        ];
        $subtotal += $import;
    }
}

$iva = round($subtotal * 0.21, 2);

// 4. Nueva comanda
$comandes[] = [
    'codi'      => $_POST['codi'] ?? '',
    'nom'       => $_POST['nom'] ?? '',
    'adreca'    => $_POST['adreca'] ?? '',
    'email'     => $_POST['email'] ?? '',
    'telefon'   => $_POST['telefon'] ?? '',
    'productes' => $productes,
    'subtotal'  => round($subtotal, 2),
    'iva'       => $iva,
    'total'     => round($subtotal + $iva, 2),
];

// 5. Guardar
$json = json_encode($comandes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

if (file_put_contents($fitxer, $json) === false) {
    die('No s\'ha pogut escriure a ' . $fitxer);
}

header('Location: ../client/Interface_admin.html');
exit;
