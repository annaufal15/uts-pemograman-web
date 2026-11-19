<?php
session_start();

// Membantu mengamankan data saat ditampilkan kembali ke HTML.
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

$formData = [
    "nama" => "", "email" => "", "semester" => "", "tanggal" => "",
    "jenis_pesan" => "", "minat" => [], "prodi" => "", "pesan" => "",
];
$errors = [];
$berhasil = false;

// P8: validasi sisi server dan penyimpanan data formulir ke session.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach (["nama", "email", "semester", "tanggal", "jenis_pesan", "prodi", "pesan"] as $field) {
        $formData[$field] = trim((string) ($_POST[$field] ?? ""));
    }
    $minat = $_POST["minat"] ?? [];
    $formData["minat"] = is_array($minat) ? array_values(array_intersect($minat, ["HTML", "CSS"])) : [];

    if (strlen($formData["nama"]) < 3 || strlen($formData["nama"]) > 50) {
        $errors[] = "Nama lengkap harus diisi 3 sampai 50 karakter.";
    }
    if (!filter_var($formData["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Masukkan alamat email yang valid.";
    }
    $semesterAngka = filter_var($formData["semester"], FILTER_VALIDATE_INT);
    if ($semesterAngka === false || $semesterAngka < 1 || $semesterAngka > 14) {
        $errors[] = "Semester harus berupa angka 1 sampai 14.";
    }
    $tanggalObj = DateTime::createFromFormat("Y-m-d", $formData["tanggal"]);
    if (!$tanggalObj || $tanggalObj->format("Y-m-d") !== $formData["tanggal"]) {
        $errors[] = "Tanggal kunjungan tidak valid.";
    }
    if (!in_array($formData["jenis_pesan"], ["pertanyaan", "saran"], true)) {
        $errors[] = "Pilih jenis pesan.";
    }
    if (count($formData["minat"]) === 0) {
        $errors[] = "Pilih minimal satu topik yang diminati.";
    }
    if (!in_array($formData["prodi"], ["SI", "TI"], true)) {
        $errors[] = "Pilih program studi yang tersedia.";
    }
    if ($formData["pesan"] === "" || strlen($formData["pesan"]) > 300) {
        $errors[] = "Pesan wajib diisi dan maksimal 300 karakter.";
    }

    if (!$errors) {
        foreach ($formData as $key => $value) {
            $_SESSION[$key] = $value;
        }
        header("Location: index.php#hasilKontak");
        exit;
    }
}

// P6: PHP dasar dan pemrograman sisi peladen.
$nim = "0344300002";
$namaMahasiswa = "Cantika Putih";
$programStudi = "SI";
$tahunAkademik = "2026/2027";
$semester = 4;
$ipk = 3.75;
$statusAktif = true;
$catatanTambahan = null;

const NAMA_MATA_KULIAH = "Pemrograman Web Dasar";
const PROFIL_GITHUB = "satpamal";

// Operator.
$batasSemester = 8;
$sisaSemester = $batasSemester - $semester;
$semesterValid = $semester >= 1 && $semester <= $batasSemester;
$statusSemester = ($semesterValid && $statusAktif) ? "Sesuai rentang" : "Perlu diperiksa";

// Percabangan if-elseif-else.
if ($semester < 3) {
    $keteranganSemester = "Semester awal";
} elseif ($semester <= 6) {
    $keteranganSemester = "Semester menengah";
} else {
    $keteranganSemester = "Semester akhir";
}

$namaProdi = ($programStudi == "SI") ? "Sistem Informasi" : (($programStudi == "TI") ? "Teknik Informatika" : "Lainnya");

// Percabangan switch-case-default.
switch ($programStudi) {
    case "SI":
        $fokusProgramStudi = "Sistem informasi dan proses bisnis";
        break;
    case "TI":
        $fokusProgramStudi = "Komputasi dan pengembangan perangkat lunak";
        break;
    default:
        $fokusProgramStudi = "Belum ditentukan";
}
?>
<!doctype html>
<html lang="id">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Profil Mahasiswa</title>
	<link rel="stylesheet" href="style.css" />
</head>

<body>
	<header>
		<div class="header-top">
			<h1>Profil Mahasiswa</h1>

			<button
				class="nav-toggle"
				id="navToggle"
				type="button"
				aria-label="Buka navigasi"
				aria-controls="navMenu"
				aria-expanded="false">
				&#9776;
			</button>
		</div>

		<nav>
			<ul id="navMenu">
				<li><a href="#home">Beranda</a></li>
				<li><a href="#about">Tentang</a></li>
				<li><a href="#contact">Kontak</a></li>
			</ul>
		</nav>
	</header>

	<main>
		<section id="home">
			<h2>Selamat Datang</h2>
			<p>Halo, saya <strong><?php echo $namaMahasiswa; ?></strong>. Saya sedang mempelajari matakuliah <strong><?php print NAMA_MATA_KULIAH; ?></strong> pada tahun akademik <?php echo $tahunAkademik; ?>.</p>

			<img src="img/foto-profil.jpg" alt="Foto profil Nama Mahasiswa" />
		</section>

		<section id="about">
			<h2>Tentang Saya</h2>

			<article>
				<h3>Profil Singkat</h3>
				<p>Program Studi: <?php echo $namaProdi . " (" . $programStudi . ")"; ?></p>
				<p>Fokus program studi: <?php echo $fokusProgramStudi; ?></p>
				<p>Status mahasiswa: <?php echo $statusAktif ? "Aktif" : "Tidak aktif"; ?></p>
				<p>Semester: <?php echo $semester . " (" . $keteranganSemester . ")"; ?></p>
				<p>Sisa semester hingga batas: <?php echo $sisaSemester; ?></p>
				<p>Pemeriksaan rentang semester: <?php echo $statusSemester; ?></p>
				<p>IPK: <?php echo number_format($ipk, 2, ',', '.'); ?></p>
				<p>Catatan tambahan: <?php echo $catatanTambahan === null ? "Belum ada" : $catatanTambahan; ?></p>

				<h3>Target Belajar (Perulangan for)</h3>
				<ol>
					<?php
					// Perulangan for tanpa array; materi larik dibahas pada P9.
					for ($i = 1; $i <= 5; $i++) {
						echo "<li>Target belajar ke-" . $i . ": ";
						switch ($i) {
							case 1:
								echo "Memahami sintaks dasar PHP.";
								break;
							case 2:
								echo "Menggunakan variabel dan konstanta.";
								break;
							case 3:
								echo "Menerapkan operator dan percabangan.";
								break;
							case 4:
								echo "Menggunakan perulangan for dan while.";
								break;
							default:
								echo "Belum dipetakan";
								break;
						}
						echo "</li>";
					}
					?>
				</ol>

				<h3>Semester (Perulangan while):</h3>
				<ol>
					<?php
					$nomorSemester = 1;
					while ($nomorSemester <= 3) {
						echo "<li>Semester " . $nomorSemester . "</li>";
						$nomorSemester++; // operator penugasan
					}
					?>
				</ol>
			</article>
		</section>

		<section id="contact">
			<h2>Kontak</h2>

			<p>
				Kunjungi
				<a target="_blank" href="https://github.com/<?= PROFIL_GITHUB ?>">profil GitHub saya</a>.
			</p>

			<?php if ($errors): ?>
                <div class="form-feedback-error" role="alert">
                    <strong>Formulir belum dapat dikirim:</strong>
                    <ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul>
                </div>
            <?php endif; ?>

			<form id="contactForm" class="js-contact-form" data-validation="contact" action="index.php" method="post" novalidate>
				<div class="form-group">
					<label for="nama">Nama Lengkap</label><br />

					<input
						class="input-form"
						type="text"
						id="nama"
						name="nama"
                        value="<?= e($formData["nama"]) ?>"
						placeholder="Masukkan nama lengkap"
						minlength="3"
						maxlength="50"
						required />
				</div>

				<div class="form-group">
					<label for="email">Email</label><br />

					<input class="input-form" type="email" id="email" name="email" value="<?= e($formData["email"]) ?>" placeholder="nama@email.com" required />
				</div>

				<div class="form-group">
					<label for="semester">Semester</label><br />

					<input class="input-form" type="number" id="semester" name="semester" value="<?= e($formData["semester"]) ?>" min="1" max="14" required />
				</div>

				<div class="form-group">
					<label for="tanggal">Tanggal Kunjungan</label><br />

					<input class="input-form" type="date" id="tanggal" name="tanggal" value="<?= e($formData["tanggal"]) ?>" required />
				</div>

				<div class="form-group">
					<p>Jenis Pesan</p>

					<input type="radio" id="pertanyaan" name="jenis_pesan" value="pertanyaan" <?= $formData["jenis_pesan"] === "pertanyaan" ? "checked" : "" ?> required />
					<label for="pertanyaan">Pertanyaan</label>

					<input type="radio" id="saran" name="jenis_pesan" value="saran" <?= $formData["jenis_pesan"] === "saran" ? "checked" : "" ?> />
					<label for="saran">Saran</label>
				</div>

				<div class="form-group">
					<p>Topik yang Diminati</p>

					<input type="checkbox" id="minat-html" name="minat[]" value="HTML" <?= in_array("HTML", $formData["minat"], true) ? "checked" : "" ?> />
					<label for="minat-html">HTML</label>

					<input type="checkbox" id="minat-css" name="minat[]" value="CSS" <?= in_array("CSS", $formData["minat"], true) ? "checked" : "" ?> />
					<label for="minat-css">CSS</label>
				</div>

				<div class="form-group">
					<label for="prodi">Program Studi</label><br />

					<select class="input-form" id="prodi" name="prodi" required>
						<option value="">-- Pilih Program Studi --</option>
						<option value="SI" <?= $formData["prodi"] === "SI" ? "selected" : "" ?>>Sistem Informasi</option>
						<option value="TI" <?= $formData["prodi"] === "TI" ? "selected" : "" ?>>Teknik Informatika</option>
					</select>
				</div>

				<div class="form-group">
					<label for="pesan">Pesan</label><br />

					<textarea
						class="input-form"
						id="pesan"
						name="pesan"
						maxlength="300"
						placeholder="Tulis pesan Anda"
						required><?= e($formData["pesan"]) ?></textarea>
				</div>

				<button type="submit">Kirim</button>
				<button type="reset">Batal</button>
				<p class="form-feedback" data-form-feedback aria-live="polite"></p>
			</form>

			<?php if (isset($_SESSION["nama"])): ?>
				<article id="hasilKontak" class="submission-result" aria-live="polite">
					<h3>Data Formulir yang Dikirim</h3>
					<p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($_SESSION["nama"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Email:</strong> <?= htmlspecialchars($_SESSION["email"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Semester:</strong> <?= htmlspecialchars($_SESSION["semester"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Tanggal Kunjungan:</strong> <?= htmlspecialchars($_SESSION["tanggal"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Jenis Pesan:</strong> <?= htmlspecialchars($_SESSION["jenis_pesan"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Topik yang Diminati:</strong>
						<?= htmlspecialchars(implode(", ", $_SESSION["minat"] ?? []), ENT_QUOTES, "UTF-8") ?>
					</p>
					<p><strong>Program Studi:</strong> <?= htmlspecialchars($_SESSION["prodi"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Pesan:</strong> <?= nl2br(htmlspecialchars($_SESSION["pesan"] ?? "", ENT_QUOTES, "UTF-8")) ?></p>
				</article>
			<?php endif; ?>
		</section>
	</main>

	<footer>
		<p>&copy; <?= date("Y") ?> <?php echo $namaMahasiswa; ?> [<?= $nim ?>]</p>
	</footer>
	<script src="script.js"></script>
</body>

</html>