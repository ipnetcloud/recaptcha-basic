$(function() {

//on submit, call submitForm() function
  $("#contactForm").submit(function(event) {
    event.preventDefault();
    submitForm();
  });

//function that handles AJAX call to PHP file
  let submitForm = () => {
    let nome = $("#nome").val();
    let email = $("#email").val();
    let subject = $("#subject").val();
    let message = $("#message").val();

    $.ajax({
      type: "POST",
      url: "./contact.php",
      data: {
        nome: name,
        email: email,
        subject: subject,
        message: message,
        captcha: grecaptcha.getResponse()
      },
      success: function(text){
        if (text == "Recaptcha Success, Mail Sent Successfully") {
          //You can delete the console.logs if youre satisfied it works fine
          console.log("Mail Sent :" + text);
          formSuccess();
        } else {
          console.log("Mail Send Failure :" + text);
        }
      }
    });

  };

  let formSuccess = () => {
    $("#msgSubmit").removeClass("hidden");
  };

  grecaptcha.enterprise.execute(6LcPTjIiAAAAADTDTMR_TeXdGXmCS0V43dGcu5dz, {
    action: 'login',
    twofactor: true
  }).then(token => {
    // Handle the generated token.
  });

});
