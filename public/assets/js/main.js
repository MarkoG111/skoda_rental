$(document).ready(function () {
  populateModels()
  checkLoginForm()
})

// START ---------->>> Show car models on models page
function populateModels() {
  $.ajax({
    url: "index.php?page=loadModels",
    method: "GET",
    dataType: "json",
    success: function (data) {
      printModels(data)
    },
    error: function (xhr, status, error) {
      console.log(status, xhr.status, error)
      console.log(xhr.responseText)
    }
  })
}

function printModels(models) {
  let print = ""
  for (let model of models) {
    print += printModel(model)
  }
  $("#skoda-models").html(print)
}

function printModel(model) {
  return `
      <div class="car col-xs-12 col-sm-6 col-lg-4 my-4">
        <div class="car-wrap scale-in-center">
          <div class="col-xs-10 col-lg-8 col-sm-8">
            <img src="${model.path}" class="img-fluid" alt="${model.alt}" />
          </div>
          <div class="col-xs-2 col-lg-4 col-sm-4 modelDetails">
            <h3 class="modelName font-weight-bold text-uppercase">${model.modelName}</h3>
            <div class="buttons">
              <a href="index.php?page=bodyworks&idModel=${model.idModel}" class="black-link">More</a>
            </div>
          </div>
        </div>
      </div>
  `
}
// END ---------->>> Show car models on models page

// START ---------->>> Registration validation
const formRegister = document.getElementById("formRegister");

formRegister.addEventListener("submit", e => {
  e.preventDefault()
})

$("#btnRegister").click(function () {
  let regErrors = null

  let firstNameVal = $('#firstName').val().trim()
  let lastNameVal = $('#lastName').val().trim()
  let emailVal = $('#email').val().trim()
  let passwordVal = $('#password').val().trim()
  let passwordConfirmVal = $('#confirmPassword').val().trim()
  let cityVal = $('#city').val().trim()
  let addressVal = $('#address').val().trim()
  let phoneVal = $('#phone').val().trim()

  regErrors = checkInputs(firstNameVal, lastNameVal, emailVal, passwordVal, passwordConfirmVal, cityVal, addressVal, phoneVal)

  if (regErrors.length) {
    console.log(regErrors)
  } else {
    $.ajax({
      url: "index.php?page=doRegister",
      method: "POST",
      data: {
        firstName: firstNameVal,
        lastName: lastNameVal,
        email: emailVal,
        password: passwordVal,
        confirmPassword: passwordConfirmVal,
        city: cityVal,
        address: addressVal,
        phone: phoneVal,
        send: true
      },
      success: function () {
        $('#formRegister input').val('')
        $("#formRegister .form-group").removeClass("success")
        alert("Successfully Registered!")
      },
      error: function (xhr, status, error) {
        let msgErr = "Error occurred.";
        switch (xhr.status) {
          case 403:
            msgErr = "Forbidden!";
            break
          case 404:
            msgErr = "Page not found!"
            break
          case 409:
            msgErr = "Data Conflict."
            break
          case 422:
            msgErr = "Unable to process the contained instructions."
            console.log(xhr.responseText)
            break
          case 500:
            msgErr = "Something went wrong, sorry."
            break
        }
        alert(msgErr)
      }
    })
  }
})

function checkInputs(firstNameVal, lastNameVal, emailVal, passwordVal, passwordConfirmVal, cityVal, addressVal, phoneVal) {
  let regErrors = []

  if (firstNameVal === '') {
    setErrorFor(firstName, 'First Name can\'t be blank.')
    regErrors.push('First Name can\'t be blank.')
  } else if (!isFirstName(firstNameVal)) {
    setErrorFor(firstName, 'First Name must start with uperrcase, 2-26 letters')
    regErrors.push('First Name must start with uperrcase, 2-26 letters')
  } else {
    setSuccessFor(firstName)
  }

  if (lastNameVal === '') {
    setErrorFor(lastName, 'Last Name can\'t be blank.')
    regErrors.push('Last Name can\'t be blank.')
  } else if (!isLastName(lastNameVal)) {
    setErrorFor(lastName, 'Last Name must start with uperrcase, 2-26 letters')
    regErrors.push('Last Name must start with uperrcase, 2-26 letters')
  } else {
    setSuccessFor(lastName)
  }

  if (emailVal === '') {
    setErrorFor(email, 'Email can\'t be blank.')
    regErrors.push('Email can\'t be blank.')
  } else if (!isEmail(emailVal)) {
    setErrorFor(email, 'Email is not in good format.')
    regErrors.push('Email is not in good format.')
  } else {
    setSuccessFor(email)
  }

  if (passwordVal === '') {
    setErrorFor(password, 'Password can\'t be blank.')
    regErrors.push('Password can\'t be blank.')
  } else if (!isPassword(passwordVal)) {
    setErrorFor(password, 'Password must have at least 6 characters including number.')
    regErrors.push('Password must have at least 6 characters including number.')
  } else {
    setSuccessFor(password)
  }

  if (passwordConfirmVal === '') {
    setErrorFor(confirmPassword, 'Must repeat password.')
    regErrors.push('Must repeat password.')
  } else if (passwordVal !== passwordConfirmVal) {
    setErrorFor(confirmPassword, 'Passwords must match.')
    regErrors.push('Passwords must match.')
  } else {
    setSuccessFor(confirmPassword)
  }

  if (cityVal === '') {
    setErrorFor(city, 'City name can\'t be blank.')
    regErrors.push('City name can\'t be blank.')
  } else if (!isCity(cityVal)) {
    setErrorFor(city, 'City name must start uppercase, 2-25 letters.')
    regErrors.push('City name must start uppercase, 2-25 letters.')
  } else {
    setSuccessFor(city)
  }

  if (addressVal === '') {
    setErrorFor(address, 'Address name can\'t be blank.')
    regErrors.push('Address name can\'t be blank.')
  } else if (!isAddress(addressVal)) {
    setErrorFor(address, 'Address name is not valid.')
    regErrors.push('Address name is not valid.')
  } else {
    setSuccessFor(address)
  }

  if (phoneVal === '') {
    setErrorFor(phone, 'Phone number can\'t be blank.')
    regErrors.push('Phone number can\'t be blank.')
  } else if (!isPhone(phoneVal)) {
    setErrorFor(phone, 'ex. 063/878-5451')
    regErrors.push('ex. 063/878-5451')
  } else {
    setSuccessFor(phone)
  }

  return regErrors
}

function setErrorFor(input, message) {
  const formGroup = input.parentElement
  const small = formGroup.querySelector('small')
  formGroup.className = 'form-group error'
  small.innerText = message
}

function setSuccessFor(input) {
  const formGroup = input.parentElement
  formGroup.className = 'form-group success'
}

function isFirstName(firstName) {
  return /^[A-ZŠĐČĆŽ][a-zšđčćž]{1,25}$/.test(firstName)
}
function isLastName(lastName) {
  return /^[A-ZŠĐČĆŽ][a-zšđčćž]{1,25}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{1,25})*$/.test(lastName)
}
function isEmail(email) {
  return /^\w+([\.\-]\w+)*@\w+([\.\-]\w+)*(\.\w{2,4})+$/.test(email)
}
function isPassword(password) {
  return /^(?=.*\d).{6,31}$/.test(password)
}
function isCity(city) {
  return /^[A-ZŠĐČĆŽ][a-zšđčćž]{1,24}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{1,24})*$/.test(city)
}
function isAddress(address) {
  return /^[A-ZŠĐČĆŽ]?[a-zšđčćž]{1,24}(\s[A-ZŠĐČĆŽ]?[a-zšđčćž]{1,24})*(\s(\d{1,3}.?\d{0,3}))*$/.test(address)
}
function isPhone(phone) {
  return /^06[0-79]\/[0-9]{3}\-[0-9]{3,4}$/.test(phone)
}
// END ---------->>> Registration validation

// START ---------->>> Login validation
function checkLoginForm() {
  $("#loginEmail").blur(checkEmail)
  $("#loginEmail").addClass("gray-border")
  $("#loginPassword").blur(checkPassword)
  $("#loginPassword").addClass("gray-border")

  function checkEmail() {
    let loginButton = $("#btnLogin")
    let email = $("#loginEmail").val()
    let regexEmail = /^\w+([\.\-]\w+)*@\w+([\.\-]\w+)*(\.\w{2,4})+$/
    if (!regexEmail.test(email)) {
      $("#loginEmail").addClass("not-correct-border")
      loginButton.prop("disabled", true)
    } else {
      $("#loginEmail").removeClass("not-correct-border")
      loginButton.prop("disabled", false)
    }
  }

  function checkPassword() {
    let loginButton = $("#btnLogin")
    let password = $("#loginPassword").val()
    let regexPassword = /^(?=.*\d).{6,31}$/
    if (!regexPassword.test(password)) {
      $("#loginPassword").addClass("not-correct-border")
      loginButton.prop("disabled", true)
    } else {
      $("#loginPassword").removeClass("not-correct-border")
      loginButton.prop("disabled", false)
    }
  }
}


// END ---------->>> Login validation