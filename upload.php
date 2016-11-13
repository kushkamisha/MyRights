<?php
    /**
     * Сохраняет загружаемый файл на сервере в папку "files" с именем,
     * которое отображает время загрузки на сервер в unix формате.
     * 
     * Получает из файла blockchain.rb сгенерированный из данного файла
     * биткоин-адрес и создает для него картинку с QR кодом.
     */
    $uploaddir = './files/';// каталог, в который мы будем принимать файл:
    $extension_mass = explode(".", $_FILES['uploadfile']['name']);
    $extension = $extension_mass[count($extension_mass) - 1];// узнаем расширение загружаемого файла
    $dir = opendir('./files/');
    $fname = time().".".$extension;// новое имя файла
    $uploadfile = $uploaddir.basename($fname);
    
    // Копируем файл из каталога для временного хранения файлов:
    if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile)) {
        $res_upload = "<h1>File is successfully downloaded!</h1>";
    } else { 
        $res_upload = "<h1>Error! Can`t uppload to file!</h1>"; 
        exit; 
    }
    $name = "files/".$fname;// сохраняем относительное имя файла для blockchain.rb 
    $btc_addr = exec('ruby ruby/blockchain.rb '.$name);// получаем при помощи blockchain.rb сгенерированный из файла биткоин-адрес
    QRcode::png("bitcoin:".$btc_addr."?amount=0.002", "test.png", QR_ECLEVEL_L, 20, 0);// создаем картинку QR кода
?>