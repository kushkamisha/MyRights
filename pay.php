<?php
    include "vendors/phpqrcode/qrlib.php";// библиотека для генерации QR-кода
    include "upload.php";
?>

<!doctype html>
<head>
    <meta charset="UTF-8">
    <title>Copyright-Ledger</title>
    <script src="vendors/jquery/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="Style/pay.css" type="text/css" />
</head>
<body>
    <div id="header">
        <div class="triangle" id="back_triangle"></div>
        <a href="index.html" id="back_block">
            <img src="images/arrow_pay.svg" id="back_arrow">
            <div id="back_text">back</div>
        </a>
        
        <div class="triangle" id="copyright_triangle"></div>
        <div id="copyright">&copy; Copyright-Ledger 2016</div>
    </div>
    
    <div id="page_container">
        <div id="result" align=center></div><br>
        <table>
            <tr>
                <td>
                    <img id="qr_code" src="test.png">
                </td>
                <td>
                    <div id="address">
                        We can embed the document's digest in the blockchain for you!<br>
                        You'll need to pay <b>2 mBTC</b> to do so, to cover our costs. Please pay to the following address:<br> <br>
                        <div id="btc_addr"></div><br>
                        Received: <span id="received"></span> mBTC
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
    <script type="text/javascript">
        $(document).ready( function() {
            var res_upload = "<?php echo $res_upload ?>";// результат загрузки файла на сервер (загружен или нет)
            var btc_addr = "<?php echo $btc_addr ?>";// биткоин-адрес файла
            var url = 'https://blockchain.info/address/' + btc_addr + '?format=json';
            var btc_payed = 0;// сколько satoshi получил биткоин-адрес
            $("#result").html(res_upload);
            $("#btc_addr").html(btc_addr);
            
            function payment() { // проверяет сколько получено средств на данный BTC-адрес
                $.ajax({
                  type: 'POST',
                  url: 'check_payment.php',
                  data: 'url=' + url,
                  success: function(data){
                    btc_payed = data;
                    $("#received").html(btc_payed / 100000);// переводим полученный результат из satoshi в mBTC
                  }
                });
                if (btc_payed >= 200000) {// если пользователь положил на счет 2mBTC или более, то мы его об этом уведомляем
                    $.ajax({
                      type: 'POST',
                      url: 'payed.php',
                      data: 'payed_addr=' + btc_addr,
                      success: function(data){
                        alert('success');
                        clearInterval(myTimer);
                      }
                    });
                }
            }
            payment();
            var myTimer = setInterval(payment, 3000);// парсим наш BTC-адрес каждые 3 секунды
        });
    </script>   
</body>
</html>