<?php
    /**
     * Записывает в файл пару BTC-адрес - private key
     * Принимает оплаченый биткоин-адрес
     */
    $searchfor = $_POST['payed_addr'];// получаем биткоин-адрес
    $file = 'pr-key.txt';// файл, куда будем сохранять BTC-адрес - private key
    
    header('Content-Type: text/plain');// prevents the browser from parsing this as HTML
    
    // Ищет в файле строчку, котороя содержит передаваемую подстроку
    function search($file, $searchfor) {
        $contents = file_get_contents($file);// get the file contents, assuming the file to be readable (and exist)
        $pattern = preg_quote($searchfor, '/');// escape special characters in the query
        $pattern = "/^.*$pattern.*\$/m";// finalise the regular expression, matching the whole line
        if(preg_match($pattern, $contents, $matches)){// search, and store all matching occurences in $matches
           return $matches[0];
        }
        else{
           return 'error with searching '.$searchfor;
        }
    }
    
    $payed_code = search($file, $searchfor);// ищем строку с нужным биткоин-адресом
    
    if (search('payed.txt',$payed_code) == ('error with searching '.$payed_code)) {// если payed.txt не содержит такого BTC-адреса, то записываем его туда
        $file = fopen("payed.txt", "a");
        fwrite($file, $payed_code);
        fclose($file);
    }
?>