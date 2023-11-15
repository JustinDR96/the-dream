<?php

$apiKey = 'YfuF5I8fSI5PsHpEFjBK1A==3wc9CqE8xkg8RX6Y'; // Remplacez 'YOUR_API_KEY' par votre clé API

$curl = curl_init();

curl_setopt_array($curl, [
   CURLOPT_URL => 'https://api.api-ninjas.com/v1/convertcurrency?want=EUR&have=USD&amount=5000',
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_CUSTOMREQUEST => 'GET',
   CURLOPT_HTTPHEADER => [
      'X-Api-Key: ' . $apiKey,
      'Content-Type: application/json',
   ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
   echo 'cURL Error #:' . $err;
} else {
   // echo $response;
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
            <option value="USD">$USD</option>
         </select>
         <i class="fas fa-exchange-alt"></i>
         <select id="new_currency" name="new_currency" class="selectCurrency">
            <option value="USD">$USD</option>
         </select>
      </div>

      <input type="submit" value="Convert" class="convert">
      <h5 class="finalAmount" id="finalAmount">montant final</h5>
   </form>
</body>

</html>