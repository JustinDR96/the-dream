<?php
$config = require('config.php');
$apiKey = $config['apiKey'];
$req_url = "https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD";
$response_json = file_get_contents($req_url);

if (false !== $response_json) {

   try {

      $response = json_decode($response_json);

      if ('success' === $response->result) {

         $currencies = array_keys((array)$response->conversion_rates);
      }
   } catch (Exception $e) {
   }
}

$convertedAmount = null;
if ($_SERVER["REQUEST_METHOD"] == "GET") {
   if (isset($_GET['currency']) && isset($_GET['old_currency']) && isset($_GET['new_currency'])) {
      $amount = $_GET['currency'];
      $fromCurrency = $_GET['old_currency'];
      $toCurrency = $_GET['new_currency'];

      $conversionUrl = "https://v6.exchangerate-api.com/v6/{$apiKey}/pair/{$fromCurrency}/{$toCurrency}/{$amount}";

      $conversion_json = file_get_contents($conversionUrl);

      if ($conversion_json !== false) {
         $conversion_data = json_decode($conversion_json);

         if ($conversion_data && $conversion_data->result === 'success') {
            $convertedAmount = $conversion_data->conversion_result;
         }
      }
   }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>The Dream</title>
   <link rel="stylesheet" href="style.scss">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
   <form action="" method="get">
      <input type="text" name="currency" id="currency" required placeholder="Enter your amount.">
      <div class="select">
         <select id="old_currency" name="old_currency" class="selectCurrency">
            <?php
            if (isset($currencies)) {
               foreach ($currencies as $currencyCode) {
                  echo "<option value=\"$currencyCode\">{$currencyCode}</option>";
               }
            }
            ?>
         </select>
         <i class="fas fa-exchange-alt" onclick="swapCurrencies()"></i>
         <select id="new_currency" name="new_currency" class="selectCurrency">
            <?php
            if (isset($currencies)) {
               foreach ($currencies as $currencyCode) {
                  echo "<option value=\"$currencyCode\">{$currencyCode}</option>";
               }
            }
            ?>
         </select>
      </div>

      <input type="submit" value="Convert" class="convert">
      <?php
      if ($convertedAmount !== null) {
         $toCurrency = $_GET['new_currency'];
         echo "<h5 class=\"finalAmount\">$convertedAmount $toCurrency</h5>";
      }
      ?>
   </form>
   <script>
      function swapCurrencies() {
         var oldCurrencySelect = document.getElementById('old_currency');
         var newCurrencySelect = document.getElementById('new_currency');
         var tempCurrency = oldCurrencySelect.value;
         oldCurrencySelect.value = newCurrencySelect.value;
         newCurrencySelect.value = tempCurrency;
         
         document.getElementById('exchangeFlag').value = 1;
      }
   </script>
</body>

</html>