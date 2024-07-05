<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="POST">
    <input type="radio" name="phones" value="1">
    <label for="phones">Сасунг</label>
    <input type="radio" name="phones" value="2">
    <label for="phones">Афон</label>
    <input type="radio" name="phones" value="3">
    <label for="phones">Сяомы</label>
    <input type="submit" name="" id="">
    <?php
    if($_POST){
        session_start();
        if(isset($_SESSION["phones"])){
            $phones = $_SESSION["phones"];
        }else{
            $phones = $_SESSION["phones"] = $_POST["phones"];
        }
        if($phones == '1'){
            echo 'Ви вибрали самсунг! Виберіть гарнітуру до вашого пристроя';
            $furnitureForVibor = ["Навушники сасунг pro 228 limited edition v2 ", "ЗАРЯДКА 1337ВАТ" , "чохоло чорни" , "ЧОХОЛ ЧОРНИ З ПРІНТОМ К - ОН"] ;
            if(isset($_SESSION["furniture"])){
                $furniture = $_SESSION["furniture"];
            }else{
                $furniture = [];
            }
            for($i = 0; $i < count($furnitureForVibor) ; $i++){
                echo"<p> $furnitureForVibor[$i] <button type='submit' name='dobavlenya' value='$furnitureForVibor[$i]'>+</button> </p>";
            }
            if(isset($_POST["dobavlenya"])){
                $add = $_POST["dobavlenya"];
            }else{
                $add = false;
            }
            if(isset($add)){
                echo("добавлено");
                array_push($furniture,$add);
                $_SESSION["furniture"] = $furniture;
                echo"<p>Ви вибрали</p>";
                for($j = 0; $j < count($furniture) ; $j++){
                    echo"<p> $furniture[$j]</p>";
                }
            }
        }
    }
    var_dump($furniture);
    // session_destroy();
    ?>
    </form>
</body>
</html>