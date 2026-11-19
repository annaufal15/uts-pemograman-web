<?php
// Contoh pembacaan data formulir menggunakan metode GET (materi P7).
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

$fields = ["nama", "email", "semester", "tanggal", "jenis_pesan", "prodi", "pesan"];
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Formulir GET</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <section>
        <h1>Data Formulir (GET)</h1>
        <?php if ($_SERVER["REQUEST_METHOD"] !== "GET" || empty($_GET)): ?>
            <p>Belum ada data formulir yang dikirim melalui URL.</p>
        <?php else: ?>
            <?php foreach ($fields as $field): ?>
                <p><strong><?= e(ucwords(str_replace("_", " ", $field))) ?>:</strong> <?= e($_GET[$field] ?? "-") ?></p>
            <?php endforeach; ?>
            <p><strong>Minat:</strong> <?= e(implode(", ", (array) ($_GET["minat"] ?? []))) ?></p>
        <?php endif; ?>
        <p><a href="index.php">Kembali ke profil</a></p>
    </section>
</main>
</body>
</html>
