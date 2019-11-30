window.onload = () => {
    // Variables
    let stripe = Stripe('VOTRE_CLE_PUBLIQUE')
    let elements = stripe.elements()
    let redirect = "/index.php"

    // Objets de la page
    let cardHolderName = document.getElementById("cardholder-name")
    let cardButton = document.getElementById("card-button")
    let clientSecret = cardButton.dataset.secret;

    // Crée les éléments du formulaire de carte bancaire
    let card = elements.create("card")
    card.mount("#card-elements")

    // On gère la saisie
    card.addEventListener("change", (event) => {
        let displayError = document.getElementById("card-errors")
        if(event.error){
            displayError.textContent = event.error.message;
        }else{
            displayError.textContent = "";
        }
    })

    // On gère le paiement
    cardButton.addEventListener("click", () => {
        stripe.handleCardPayment(
            clientSecret, card, {
                payment_method_data: {
                    billing_details: {name: cardHolderName.value}
                }
            }
        ).then((result) => {
            if(result.error){
                document.getElementById("errors").innerText = result.error.message
            }else{
                document.location.href = redirect
            }
        })
    })

}