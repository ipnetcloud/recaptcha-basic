<?php
//TESTING (returns true every time)
// Site key: 6Lf41i8iAAAAANmvvNp6Q16O5RE2-boLTsUENIdZ
// Secret key: 6Lf41i8iAAAAANmvvNp6Q16O5RE2-boLTsUENIdZ

$captcha = $_POST["captcha"]; //response data
$secret = "6LcPTjIiAAAAADTDTMR_TeXdGXmCS0V43dGcu5dz"; //your recaptcha secret

//Recaptcha verification and JSON response decode
$verify = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha), true);

//Value of json key "success"
$success = $verify["success"];

$nome = stripslashes($_POST["nome"]);
$email = stripslashes($_POST["email"]);
$assunto = stripslashes($_POST["assunto"]);
$mensagem = stripslashes($_POST["mensagem"]);

$headers = "From: " . $email . "\r\n" .
    "Reply-To: " . $email . "\r\n" .
    "X-Mailer: PHP/" . phpversion();

// prepare email body text
$Body .= "Nome: ";
$Body .= $nome;
$Body .= "\n";

$Body .= "Mensagem: ";
$Body .= $mesagem;
$Body .= "\n";

if ($success == false) {
  //This user was not verified by recaptcha.
  echo "Recaptcha Verification Failed";
} else if ($success == true) {
    //This user is verified by recaptcha
    // send email
    //change email@email.com to your desired recipient
    if (mail("email@email.com", $subject, $Body, $headers)){
      //send successful
      echo "Recaptcha com sucesso, email enviado";
    }else{
      //send failure
        echo "Falha ao enviar mensagem";
      }
}

// Include Google Cloud dependencies using Composer
require 'vendor/autoload.php';

use Google\Cloud\RecaptchaEnterprise\V1\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\Event;
use Google\Cloud\RecaptchaEnterprise\V1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1\TokenProperties\InvalidReason;

/**
* Create an assessment to analyze the risk of a UI action.
* @param string $siteKey The key ID for the reCAPTCHA key (See https://cloud.google.com/recaptcha-enterprise/docs/create-key)
* @param string $token The user's response token for which you want to receive a reCAPTCHA score. (See https://cloud.google.com/recaptcha-enterprise/docs/create-assessment#retrieve_token)
* @param string $project Your Google Cloud project ID
*/
function create_assessment(
   string $siteKey,
   string $token,
   string $project
): void {
    // TODO: To avoid memory issues, move this client generation outside
    // of this example, and cache it (recommended) or call client.close()
    // before exiting this method.
   $client = new RecaptchaEnterpriseServiceClient();
   $projectName = $client->projectName($project);

   $event = (new Event())
       ->setSiteKey($siteKey)
       ->setToken($token);

   $assessment = (new Assessment())
       ->setEvent($event);

   try {
       $response = $client->createAssessment(
           $projectName,
           $assessment
       );

       // You can use the score only if the assessment is valid,
       // In case of failures like re-submitting the same token, getValid() will return false
       if ($response->getTokenProperties()->getValid() == false) {
           printf('The CreateAssessment() call failed because the token was invalid for the following reason: ');
           printf(InvalidReason::name($response->getTokenProperties()->getInvalidReason()));
       } else {
           printf('The score for the protection action is:');
           printf($response->getRiskAnalysis()->getScore());

           // Optional: You can use the following methods to get more data about the token
           // Action name provided at token generation.
           // printf($response->getTokenProperties()->getAction() . PHP_EOL);
           // The timestamp corresponding to the generation of the token.
           // printf($response->getTokenProperties()->getCreateTime()->getSeconds() . PHP_EOL);
           // The hostname of the page on which the token was generated.
           // printf($response->getTokenProperties()->getHostname() . PHP_EOL);
       }
   } catch (exception $e) {
       printf('CreateAssessment() call failed with the following error: ');
       printf($e);
   }
}

// TODO(Developer): Replace the following before running the sample
create_assessment(
   '6LcPTjIiAAAAADTDTMR_TeXdGXmCS0V43dGcu5dz',
   'YOUR_USER_RESPONSE_TOKEN',
   '01EB3A-4C2676-0DC6BA'
);


?>
