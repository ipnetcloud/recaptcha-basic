<?php
//TESTING (returns true every time)
// Site key: 6LcI01AiAAAAALtG6k-l16JnPnKg4_-QqZgNqx2b
// Secret key: 6LcI01AiAAAAALtG6k-l16JnPnKg4_-QqZgNqx2b

$captcha = $_POST["captcha"]; //response data
$secret = "6LcI01AiAAAAALtG6k-l16JnPnKg4_-QqZgNqx2b"; //your recaptcha secret

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

?>
