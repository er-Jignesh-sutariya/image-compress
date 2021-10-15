<?php require_once('webp.php');

$path = 'images/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = explode('.', $_FILES['image']['name']);
    
    $filename = time().'.'.end($image);
    $imgs = $filename;

    if (in_array(end($image), ['png', 'jpg', 'jpeg']) ) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path.$filename);
        createThumbnail($path.$filename, $path.$filename, 1080, 1080);
    
        if (in_array(end($image), ['jpg', 'jpeg']))
            $convert = imagecreatefromjpeg($path.$filename);
        if (end($image) == 'png')
            $convert = imagecreatefrompng($path.$filename);
        
        $img = convert_webp($path, $convert, time());
        unlink($path.$filename);
    }

    header('Location: ?image='.$img, '_self');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thumb and webp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Compress and convert</h1>
        <br>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="image" id="image" onchange="this.form.submit()" accept="image/png, image/jpg, image/jpeg" />
        </form>
        <br>
        <p>Compress and convert the image to webp while uploading jpg, jpeg or png image</p>
        <br>
        <h4>Result : </h4>
        <?php if(isset($_GET['image'])): ?><img src="<?= $path.$_GET['image'] ?>" alt="" height="250" width="250"><?php endif; ?>
    </div>
</body>
</html>