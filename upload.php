<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<?php
$uploadSuccess = false;
if ($_FILES){
        $target = "uploads/";
        $targetFile = $target . basename($_FILES['uploadedName']['name']);
        $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);
        $uploadSuccess = true;


        if (file_exists($targetFile)){
            echo "<p class='text-danger'>Soubor již existuje</p>";
            $uploadSuccess = false;
        }
        if ($_FILES['uploadedName']['name'] > 8000000){
            echo "<p class='text-danger'>Soubor je příliž velký</p>";
        }

        if ($_FILES['uploadedName']['error'] != 0){
            echo "<p class='text-danger'>Chyba při uploadu na server</p>";
            $uploadSuccess = false;
        }


        //vlastní přesun souborů

        if (!$uploadSuccess){
            echo "<p class='text-danger'>Došlo k chybě uploadu</p>";

        }else{
            if (move_uploaded_file($_FILES['uploadedName']['tmp_name'], $targetFile)){
                echo "<p class='text-success'>Soubor ". basename( $_FILES['uploadedName']['name']) . " byl uložen</p>";
            }else{
                echo "<p class='text-danger'>Došlo k chybě uploadu</p>";
            }
        }


}

?>

    <form class="row g-2 align-items-end" method="post" action="", enctype="multipart/form-data">
            <div class="col-auto mb-3">

                <label for="formFile" class="form-label">Select image to upload.</label>
                <!--                <input class="form-control" type="file" id="formFile">-->
                <input class="form-control" style="max-width: 400px" id="formFile" type="file", name="uploadedName" accept="[image/]"/>
            </div>

        <div class="col-auto">
            <input class="btn btn-primary mb-3" type="submit", value="Nahrát", name="submit">
        </div>

    </form>

<?php
    if ($uploadSuccess){

        $type = explode('/', $_FILES['uploadedName']['type'])[0];

        switch ($type){
            case "image":
                echo "<img src='$targetFile'>";
                break;
            case "video":
                echo "<video width='320' height='240' autoplay controls>
                        <source src='$targetFile' type='{$_FILES['uploadedName']['type']}'>
                        Your browser does not support the video tag.
                     </video>";
                break;
            case "audio":
                echo "
                <audio controls autoplay>
                    <source src='$targetFile' type='{$_FILES['uploadedName']['type']}'>
                    Your browser does not support the audio element.
                </audio>
                ";
                break;
        }
    }
?>


</body>
</html>
