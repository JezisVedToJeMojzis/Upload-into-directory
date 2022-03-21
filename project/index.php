<pre>
<?php
    $path = isset($_GET["path"]) ? $_GET["path"] : "uploads/";
    if(isset($_POST["title"]) && isset($_FILES["fileToUpload"])) {
        $ext = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);
        $filename = $path . $_POST["title"] . ".$ext";
        if (!file_exists($filename)) {
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $filename);
        } else {
            $timestamp = filemtime($filename);
            $filename = $path . $_POST["title"] . ".$ext " . "(" . $timestamp . ")";
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $filename);
        }
    }
?>
</pre>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Upload to directory</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Upload to directory</h1>
    <hr>
<div id="container">
    <?php
        echo "<h2>Adresár</h2>"
    ?>
<table class="sortable">
    <thead>
        <tr>
            <th>File name</th>
            <th class="sorttable_numeric">File size</th>
            <th>Upload date</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $files = scandir($path);
    if(realpath($path)=="/var/www/site136.webte.fei.stuba.sk/zad1/uploads"){ //cant go out of uploads/ directory ***//change url to yours***
        $files = array_diff(scandir($path), array('.', '..'));
    }else{
        $files = scandir($path);
    }
    foreach($files as $file)
    {
        if(is_dir($path.$file)){
            ?>
            <tr>
                <td><a href="?path=<?php echo $path.$file."/"?>"><?php echo $file?></a></td>
            </tr>
            <?php
        }

        else{
            ?>
            <tr>
                <td><?php echo $file?></td>
                <td><?php echo filesize($path.$file)." bytes"?></td>
                <td><?php echo date("d/m/y h:i:s",filemtime($path.$file))?></td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>
</div>
<hr>
    <div id="upload">
    <h2>Upload to directory</h2>
    <form actions ="index.php" enctype="multipart/form-data" method="post">
        <div id="t"><label for="title">File name: </label><input id="title" type="text" name="title"</div>
        <div id="f"><label for="file">File: </label><input id="file" name="fileToUpload"  type="file"</div>
        <div id="u"><button type="submit" id="button">Upload</button></div>
    </form>
    </div>

</body>
<script src="sorttable.js"></script>
</html>
