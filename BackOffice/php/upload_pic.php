<?php
session_start();
require './connect.php';

if (isset($_POST['Upload'])) {
    $_SESSION["Upload"] = $_POST['Upload'];
}

$product_id = $_GET['product_id'];
//Select Product Pic
$sql1 = "SELECT * FROM product_pic WHERE product_id = '$product_id'";
$result1 = mysqli_query($connect, $sql1);
$html1 = "<table class='table table-striped'>"
        . "<thead>
            <tr>
            <th></th>
            <th></th>
            <th></th>
            </tr>";
while ($array = mysqli_fetch_array($result1)) {
    $html1 = $html1 . "<tr>
                        <td><img src='../../img/{$array['pic']}' width=50px height=50px></td>
                        <td>{$array['pic']}</td>
                        <td>
                            <button type='button' class='btn btn-danger' id='delete-pic' onclick=" . "deletePic('{$array['pic_id']}','{$array['product_id']}')>
                               <span class='glyphicon glyphicon-remove'></span> Delete
                            </button>
                        </td>
                    </tr>";
}
$html1 = $html1 . "</table>";

function SaveImage($name, $newwidth, $newheight, $i) {
    if ($_FILES['product_pic']['error'][$i] != 4) {
        if ($_FILES['product_pic']['type'][$i] == "image/jpeg") {
            $newname = $name . ".jpg";
            $newname_thumb = $name . ".jpg";

            copy($_FILES['product_pic']['tmp_name'][$i], $newname);
            list($width, $height) = getimagesize($newname);

            $thumb = imagecreatetruecolor($newwidth, $newheight);
            $source = imagecreatefromjpeg($newname);
            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

            imagejpeg($thumb, "../../img/product/" . $newname_thumb);
            unlink($newname);
        }
    }
}

//Upload Picture
if (isset($_SESSION["Upload"])) {
    for ($i = 0; $i < count($_FILES["product_pic"]["name"]); $i++) {
        if ($_FILES["product_pic"]["type"][$i] == "image/jpeg") {
            $sql1 = "SELECT max(pic_id)+1 as new_pic_id FROM product_pic";
            $result1 = mysqli_query($connect, $sql1);
            $array = mysqli_fetch_array($result1);

            if ($array['new_pic_id'] == NULL) {
                $new_pic_id = "000001";
            } else {
                $new_pic_id = sprintf('%06s', $array['new_pic_id']);
            }

            $fileName = $new_pic_id . $product_id;

            $pathName = "product/" . $fileName . ".jpg";
            $newwidth = 400;
            $newheight = 400;
            SaveImage($fileName, $newwidth, $newheight, $i);

            $sql2 = "INSERT into product_pic values ('$new_pic_id','$product_id','$pathName')";
            $result2 = mysqli_query($connect, $sql2);
        } else {
            echo '<script> alert("Please upload only file type jpg");
            </script>';
        }
    }
    unset($_SESSION['Upload']);
    header("refresh:0; upload_pic.php?product_id=" . $product_id);
    exit;
}
?>
<html>
    <head>
        <title>Product - Back Office</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/product.js"></script>
        <script>
            $(document).ready(function () {
                $("#submit-pic").click(function () {
                    window.opener.location.reload();
                    window.close();
                });
            });
        </script>

    </head>

    <body>
        <div class="container" >        
            <h2>PICTURE</h2><hr>
            <div id="show-pic">
                <?php
                echo $html1;
                ?>
            </div>
        </div>  
        <div class="container" > 
            <div class="row">
                <!-- panel preview -->
                <div class="col-sm-12">
                    <h4>Upload Picture:</h4>
                    <div class="panel panel-default">
                        <form action="upload_pic.php?product_id=<?php echo $product_id; ?>" method="post" enctype="multipart/form-data">
                            <div class="panel-body form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Picture:</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" name="product_pic[]" multiple>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12 text-center">
                                        <input type="submit" class="btn btn-primary" id="upload-pic" name="Upload" value="Upload">
                                        <input type="button" class="btn btn-success" id="submit-pic" name="Submit" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
        <script>
            function deletePic(pic_id, product_id) {

                $.post("../php/delete_pic.php?operation=delete", {
                    "pic_id": pic_id,
                    "product_id": product_id
                }, function (data) {
                    if (data.status === true) {
                        location.reload();
                    } else {
                        alert("ไม่สามารถลบข้อมูลได้");
                    }
                }
                , "json");
            }
        </script>
    </body>

</html>
