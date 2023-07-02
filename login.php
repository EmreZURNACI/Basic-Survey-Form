<?php
$GLOBALS["user"] = null;
require("cities.php");
require("connection.php");
$errMessage = null;
$cookie_name = "userID";
$cookie_value = null;
?>
<?php
function safeForm($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["fullName"])) {
        $fullName = safeForm($_POST["fullName"]);
        if (isset($_POST["job"])) {
            $job = safeForm($_POST["job"]);
            if (isset($_POST["age"])) {
                $age = safeForm($_POST["age"]);
                if (isset($_POST["gender"])) {
                    $gender = safeForm($_POST["gender"]);
                    if (isset($_POST["city"])) {
                        $city = safeForm($_POST["city"]);
                        if ($city != -1) {
                            $sql = "INSERT INTO `ankettbl` (`id`, `fullName`, `occupation`, `age`, `gender`, `city`) VALUES (NULL, '$fullName', '$job', '$age', '$gender', '$city');";
                            $conn->query($sql) === "TRUE";
                            $last_id = $conn->insert_id;
                            $cookie_value = $last_id;
                            setcookie($cookie_name, $cookie_value);
                            header("Location:index.php");
                            exit;
                        }
                    }
                }
            }
        }
    }
    if ((empty($fullName)) or (empty($job)) or (empty($age)) or (empty($gender)) or (empty($city))) {
        $errMessage = "Anket sonuçlarının doğruluğu için bilgilerinizi eksiksiz doldurmalısınız";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="vh-100 vw-100">
    <div class="container">
        <div class="row">
            <h1 class="text-center">Anketi Görüntülemek İçin Giriş Yapın</h1>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="col-8 mx-auto">
                <div class="mb-2">
                    <label for="fullName" class="form-check-label ps-1 fw-bold fs-5">Adınız ve Soyadınız:</label>
                    <input type="text" tabindex="1" id="fullName" name="fullName" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="job" class="form-check-label ps-1 fw-bold fs-5">Mesleğiniz:</label>
                    <input type="text" tabindex="2" id="job" name="job" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="age" class="form-check-label ps-1 fw-bold fs-5">Yaşınız:</label>
                    <input type="number" tabindex="3" id="age" name="age" class="form-control" maxlength="125">
                </div>
                <div class="mb-2">
                    <label class="form-check-label ps-1 fw-bold fs-5">Cinsiyet:</label>
                    <div>
                        <input type="radio" tabindex="4" id="Erkek" name="gender" value="Erkek" class="form-check-input"><label for="Erkek" class="form-check-label">Erkek</label>
                        <input type="radio" tabindex="5" id="Kadın" name="gender" value="Kadın" class="form-check-input"><label for="Kadın" class="form-check-label">Kadın</label>
                    </div>
                </div>
                <div class="mb-2">
                    <label for="city" class="form-check-label ps-1 fw-bold fs-5">Hangi Şehirde Çalışıyorsunuz:</label>
                    <select name="city" class="form-select" tabindex="6">
                        <option value="-1" selected>Seçin</option>
                        <?php foreach ($sehirler as $key => $sehir) : ?>
                            <option value="<?php echo (int)($key + 1); ?>"><?php echo $sehir; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary w-100" tabindex="7">Kaydet ve Anketi Gör</button>
                </div>
                <div>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        echo ("<span class='text-danger fw-bold'>$errMessage</span>");
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>

</body>

</html>