<?php

// Initialisation de l'API
$apiKey = 'b57227c323b200c8f3ded1b2';
$url = "https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD";

// Fonction pour récupérer les devises depuis l'API
function getCurrencies()
{
   global $url;

   $curl = curl_init();

   curl_setopt_array($curl, [
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST => 'GET',
   ]);

   $response = curl_exec($curl);
   $err = curl_error($curl);

   curl_close($curl);

   if ($err) {
      echo 'cURL Error #:' . $err;
      return [];
   } else {
      $data = json_decode($response, true);

      // Vérifiez si la conversion JSON a réussi
      if ($data !== null && isset($data['conversion_rates'])) {
         // Extraire les devises disponibles
         return array_keys($data['conversion_rates']);
      } else {
         echo "Erreur lors de la conversion JSON";
         return [];
      }
   }
}

// Obtenez la liste des devises
$currencies = getCurrencies();
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
            // Afficher les options du menu déroulant pour les devises
            foreach ($currencies as $currencyCode) {
               echo "<option value=\"$currencyCode\">{$currencyCode}</option>";
            }
            ?>
         </select>
         <i class="fas fa-exchange-alt"></i>
         <select id="new_currency" name="new_currency" class="selectCurrency">
            <?php
            // Afficher les options du menu déroulant pour les devises
            foreach ($currencies as $currencyCode) {
               echo "<option value=\"$currencyCode\">{$currencyCode}</option>";
            }
            ?>
         </select>
      </div>

      <input type="submit" value="Convert" class="convert">
      <h5 class="finalAmount" id="finalAmount">montant final</h5>
   </form>
</body>

</html>