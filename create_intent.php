<?php
require_once 'stripe-php/init.php'; 

try {
  $stripe = new \Stripe\StripeClient("sk_test_51OC15MCSdYQbmH35ikhO5sojdrreAexXp7PKByQdBKyLBm80Mz0UAgsCmpccm5DY1HfLiGM9U6BAtHJyGk61wzBi00NgipaqUW");
    $intent = $stripe->paymentIntents->create(
      [
        // sample values for stripe, not needed for phpmyadmin database
        'amount' => 1099,
        'currency' => 'usd',
        'description' => 'Donation to Talk Sick Fundraiser.',
        'automatic_payment_methods' => ['enabled' => true]
      ]
    );
    echo json_encode(array('client_secret' => $intent->client_secret));
} catch (Error $e) {
  http_response_code(500); 
  echo json_encode(['error' => $e->getMessage()]); 
}
    
?>