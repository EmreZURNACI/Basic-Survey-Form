<?php
require "questions.php";
require "connection.php";
$last_id = null;
if (isset($_COOKIE["userID"])) {
    $last_id = $_COOKIE["userID"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anket App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light ">
    <div class="container bg-container border-0 rounded-3 pt-2">
        <h1 class="text-center"><?php echo (ucwords("İş Hayatınız hakkında 14 Soruluk bir anket")); ?></h1>
        <?php
        $score = 2;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (
                (!empty($_POST["Soru-1"]))
                and (!empty($_POST["Soru-2"]))
                and (!empty($_POST["Soru-3"]))
                and (!empty($_POST["Soru-4"]))
                and (!empty($_POST["Soru-5"]))
                and (!empty($_POST["Soru-6"]))
                and (!empty($_POST["Soru-7"]))
                and (!empty($_POST["Soru-8"]))
                and (!empty($_POST["Soru-9"]))
                and (!empty($_POST["Soru-10"]))
                and (!empty($_POST["Soru-11"]))
                and (!empty($_POST["Soru-12"]))
                and (!empty($_POST["Soru-13"]))
                and (!empty($_POST["Soru-14"]))
            ) {
                foreach ($questions as $key => $question) {
                    $score += (int)($_POST[$key]);
                }
                switch ($score) {
                    case 0 <= $score and 45 > $score:
                        echo ("<p class='text-center fw-bolder fs-4 mt-3 text-danger'>Anketimizi yanıtlandırdığınız için çok teşekkür ederiz. \nKötü Bir Çalışansınız</p>");
                        break;
                    case 45 <= $score and 55 > $score:
                        echo ("<p class='text-center fw-bolder fs-4 mt-3 text-warning'>Anketimizi yanıtlandırdığınız için çok teşekkür ederiz. \nİdare eden Bir Çalışansınız</p>");
                        break;
                    case 55 <= $score and 70 > $score:
                        echo ("<p class='text-center fw-bolder fs-4 mt-3 text-info'>Anketimizi yanıtlandırdığınız için çok teşekkür ederiz. \nİyi Bir Çalışansınız</p>");
                        break;
                    case 70 <= $score and 85 > $score:
                        echo ("<p class='text-center fw-bolder fs-4 mt-3 text-primary'>Anketimizi yanıtlandırdığınız için çok teşekkür ederiz. \nÇok iyi Bir Çalışansınız</p>");
                        break;
                    case 85 <= $score and 100 >= $score:
                        echo ("<p class='text-center fw-bolder fs-4 mt-3 text-success'>Anketimizi yanıtlandırdığınız için çok teşekkür ederiz. \nMükemmel Bir Çalışansınız</p>");
                        break;
                    default:
                        break;
                }
                $sql = "UPDATE `ankettbl` SET `Score` = '$score' WHERE `ankettbl`.`id` = $last_id;";
                $conn->query($sql) === "TRUE";
            } else {
                echo ("<p class='text-center fw-bolder fs-4 mt-3 text-danger'>Durumunuzu Tespit Edebilmemiz İçin Bütün Soruları Yanıtlamanız Gerekir.</p>");
            }
        }
        ?>
        <div class="row">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                <?php foreach ($questions as $key => $question) : ?>
                    <div class="col-10 mx-auto  border-4 border-black border rounded-3 mt-3 p-3">
                        <p class="ps-2 my-2 fw-bold fs-5"><?php echo $key . " )   " . $question; ?></p>
                        <div>
                            <?php for ($i = 0; $i < 5; $i++) : ?>
                                <label for="<?php echo  $key . "-" . $i ?>" class="form-check-label px-2">
                                    <input type="radio" name="<?php echo $key ?>" id="<?php echo  $key . "-" . $i ?>" value="<?php echo 7 - $i; ?>" class="form-check-input">&nbsp;<?php echo $cevaplar[$key][$i]; ?>
                                </label>

                            <?php endfor; ?>
                        </div>
                        <div class="d-block ps-3">
                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                if (empty($_POST[$key])) {
                                    echo "<span class='text-danger'>Cevaplanmayan soru bırakılmamalıdır.</span>";
                                }
                            }

                            ?>
                        </div>
                    </div>
                <?php endforeach ?>
                <div class="mt-1 col-10 mx-auto">
                    <button type="submit" class="btn btn-dark w-100 fw-bold fs-5">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>