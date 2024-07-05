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
        <input type="submit" name="choose_phone" value="Выбрать">
    </form>

    <form action="index.php" method="POST">
        <button type="submit" name="clear" value="1">Очистить</button>
    </form>
    
    <?php
    session_start();

    // Очистка сессии
    if (isset($_POST['clear'])) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }

    // Обработка выбора телефона
    if (isset($_POST["choose_phone"])) {
        $_SESSION["phones"] = $_POST["phones"];
        header("Location: index.php");
        exit();
    }

    // Показать форму выбора фурнитуры, если выбран телефон
    if (isset($_SESSION["phones"])) {
        $phones = $_SESSION["phones"];
        switch ($phones) {
            case '1':
                echo 'Вы выбрали Самсунг! Выберите гарнитуру:';
                $furnitureForSamsung = ["Навушники Самсунг Pro 228 Limited Edition", "Зарядка 1337 Ватт", "Чохол чорний", "Чохол чорний з прінтом к-он"];
                foreach ($furnitureForSamsung as $i => $furniture) {
                    if (!in_array($furniture, $_SESSION['selected_items'])) {
                        echo "<form action='index.php' method='POST'>";
                        echo "<p>$furniture <button type='submit' name='add_furniture' value='$i'>+</button></p>";
                        echo "</form>";
                    }
                }
                break;

            case '2':
                echo 'Вы выбрали Айфон! Выберите аксессуары:';
                $accessoriesForIPhone = ["Наушники Айфон X", "Зарядка Apple 20W", "Чехол кожаный", "Защитное стекло"];
                foreach ($accessoriesForIPhone as $i => $accessory) {
                    if (!in_array($accessory, $_SESSION['selected_items'])) {
                        echo "<form action='index.php' method='POST'>";
                        echo "<p>$accessory <button type='submit' name='add_accessory' value='$i'>+</button></p>";
                        echo "</form>";
                    }
                }
                break;

            case '3':
                echo 'Вы выбрали Сяоми! Выберите аксессуары:';
                $accessoriesForXiaomi = ["Наушники Xiaomi Pro", "Зарядка Xiaomi 100W", "Силиконовый чехол", "Стекло защитное с закругленными краями"];
                foreach ($accessoriesForXiaomi as $i => $accessory) {
                    if (!in_array($accessory, $_SESSION['selected_items'])) {
                        echo "<form action='index.php' method='POST'>";
                        echo "<p>$accessory <button type='submit' name='add_accessory' value='$i'>+</button></p>";
                        echo "</form>";
                    }
                }
                break;
        }

        // Показать выбранную фурнитуру/аксессуары
        if (!empty($_SESSION['selected_items'])) {
            echo "<p>Выбранные товары:</p>";
            foreach ($_SESSION['selected_items'] as $index => $item) {
                echo "<p>$item <form action='index.php' method='POST'><button type='submit' name='remove_item' value='$index'>Удалить</button></form></p>";
            }
        }
    }
    
    // Обработка добавления фурнитуры/аксессуаров
    if (isset($_POST['add_furniture'])) {
        $dobavlenya = $_POST['add_furniture'];
        $furnitureForSamsung = ["Навушники Самсунг Pro 228 Limited Edition", "Зарядка 1337 Ватт", "Чохол чорний", "Чохол чорний з прінтом к-он"];
        $selectedItem = $furnitureForSamsung[$dobavlenya];
        $_SESSION['selected_items'][] = $selectedItem;
        // Удаление выбранного элемента из исходного списка
        unset($furnitureForSamsung[$dobavlenya]);
        $furnitureForSamsung = array_values($furnitureForSamsung); // Переиндексация массива
        $_SESSION['furnitureForSamsung'] = $furnitureForSamsung;
        header("Location: index.php");
        exit();
    }

    // Обработка добавления аксессуаров для Айфона и Сяоми
    if (isset($_POST['add_accessory'])) {
        $dobavlenya = $_POST['add_accessory'];
        $phones = $_SESSION["phones"];
        switch ($phones) {
            case '2':
                $accessoriesForIPhone = ["Наушники Айфон X", "Зарядка Apple 20W", "Чехол кожаный", "Защитное стекло"];
                $selectedItem = $accessoriesForIPhone[$dobavlenya];
                $_SESSION['selected_items'][] = $selectedItem;
                // Удаление выбранного элемента из исходного списка
                unset($accessoriesForIPhone[$dobavlenya]);
                $accessoriesForIPhone = array_values($accessoriesForIPhone); // Переиндексация массива
                $_SESSION['accessoriesForIPhone'] = $accessoriesForIPhone;
                break;

            case '3':
                $accessoriesForXiaomi = ["Наушники Xiaomi Pro", "Зарядка Xiaomi 100W", "Силиконовый чехол", "Стекло защитное с закругленными краями"];
                $selectedItem = $accessoriesForXiaomi[$dobavlenya];
                $_SESSION['selected_items'][] = $selectedItem;
                // Удаление выбранного элемента из исходного списка
                unset($accessoriesForXiaomi[$dobavlenya]);
                $accessoriesForXiaomi = array_values($accessoriesForXiaomi); // Переиндексация массива
                $_SESSION['accessoriesForXiaomi'] = $accessoriesForXiaomi;
                break;
        }
        header("Location: index.php");
        exit();
    }

    // Обработка удаления фурнитуры/аксессуаров
    if (isset($_POST['remove_item'])) {
        $removeIndex = $_POST['remove_item'];
        if (isset($_SESSION['selected_items'][$removeIndex])) {
            $removedItem = $_SESSION['selected_items'][$removeIndex];
            unset($_SESSION['selected_items'][$removeIndex]);
            $_SESSION['selected_items'] = array_values($_SESSION['selected_items']); // Переиндексация массива
            // Добавление удаленного элемента обратно в исходный список
            switch ($_SESSION["phones"]) {
                case '1':
                    $_SESSION['furnitureForSamsung'][] = $removedItem;
                    break;
                case '2':
                    $_SESSION['accessoriesForIPhone'][] = $removedItem;
                    break;
                case '3':
                    $_SESSION['accessoriesForXiaomi'][] = $removedItem;
                    break;
            }
        }
        header("Location: index.php");
        exit();
    }
    ?>
</body>
</html>
