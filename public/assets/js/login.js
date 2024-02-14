$(document).ready(function () {
  $("#login-email").blur(checkEmail)
  $("#login-password").blur(checkPassword)

  $("#login-password").css("border", "1px solid gray")
  $("#login-email").css("border", "1px solid gray")

  $("#btn-login").click(function () {
    const valid = checkEmail() && checkPassword()

    $("#loader").show()
    $("#btn-login").prop("disabled", true)

    setTimeout(function () {
      $("#loader").hide()
      $("#btn-login").prop("disabled", false)
    }, 500)

    if (valid) {
      $.ajax({
        url: "index.php?ajax=login",
        method: "POST",
        dataType: "json",
        data: {
          email: $("#login-email").val(),
          password: $("#login-password").val()
        },
        success: function (response) {
          if (response == "redirect_user") {
            window.location.href = "index.php?page=user";
          }
          if (response == "redirect_admin") {
            window.location.href = "index.php?page=admin";
          }
        },
        error: function (xhr, status, error) {
          let errors = xhr.responseText.substring(1, xhr.responseText.length - 1).split(',')

          errors_html = "<ul>"
          errors.forEach(function (error) {
            errors_html += "<li>" + error + "</li>"
          })
          errors_html += "</ul>"

          $(".modal-footer-login-errors").html(errors_html.replace(/["']/g, ''))
        }
      })
    } else {
      $(".modal-footer-login-errors").html("Please check your input and try again.");
    }
  })
})

function checkField(value, regex, element) {
  const is_valid = regex.test(value)

  element.css("border", is_valid ? "1px solid green" : "1px solid red")

  $(".modal-footer-login-errors").html("")

  return is_valid
}

function checkEmail() {
  const regex_email = /^\w+([\.\-]\w+)*@\w+([\.\-]\w+)*(\.\w{2,4})+$$/

  return checkField($("#login-email").val(), regex_email, $("#login-email"))
}

function checkPassword() {
  const regex_password = /^(?=.*\d).{6,31}$/

  return checkField($("#login-password").val(), regex_password, $("#login-password"))
}
