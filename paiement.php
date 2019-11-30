<?php
if(isset($_POST['prix']) && !empty($_POST['prix'])){
    require_once('vendor/autoload.php');
    $prix = (float)$_POST['prix'];

    // On instancie Stripe
    \Stripe\Stripe::setApiKey('VOTRE_CLE_PRIVEE');

    $intent = \Stripe\PaymentIntent::create([
        'amount' => $prix*100,
        'currency' => 'eur'
    ]);
}else{
    header('Location: /index.php');
}


?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Paiement</title>
    </head>
    <body>
        <form method="post">
            <div id="errors"></div><!--Contiendra les messages d'erreur de paiement-->
            <input type="text" id="cardholder-name" placeholder="Titulaire de la carte">
            <div id="card-elements"></div><!--Contiendra le formulaire de saisie des informations de carte-->
            <div id="card-errors" role="alert"></div><!--Contiendra les erreurs relatives à la carte-->
            <button id="card-button" type="button" data-secret="<?= $intent['client_secret'] ?>">Procéder au paiement</button>
        </form>

        <script src="https://js.stripe.com/v3/"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>