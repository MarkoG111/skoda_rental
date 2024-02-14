$(document).ready(function () {
  $("#form-registration").submit(function (e) {
    e.preventDefault()
    checkInputs()
  })

  $("#btn-register").click(function () {
    $.ajax({
      url: "index.php?ajax=register",
      method: "POST",
      dataType: "json",
      data: {
        first_name: $('#first_name').val(),
        last_name: $('#last_name').val(),
        email: $('#email').val(),
        password: $('#password').val(),
        city: $('#city').val(),
        address: $('#address').val(),
        phone: $('#phone').val(),
        licence_number: $('#licence_number').val(),
        years_of_experience: $('#years_of_experience').val(),
        send: true
      },
      success: function () {
        $('#form-registration input[type="text"]').val('')
        $('#form-registration input[type="password"]').val('')
        $('#form-registration input[type="email"]').val('')

        $("#form-registration .form-group").removeClass("success")

        alert("Successfully Registered!")

        $("#registration-modal .close").click()
      },
      error: function (xhr, status, error) {
        let errorMessage = "Error occurred.";

        switch (xhr.status) {
          case 403:
            errorMessage = "Forbidden!";
            break
          case 404:
            errorMessage = "Page not found!"
            break
          case 409:
            errorMessage = "Data Conflict."
            break
          case 422:
            errorMessage = "Unable to process the contained instructions."
            console.log(xhr.responseText)
            break
          case 500:
            errorMessage = "Something went wrong, sorry."
            break
        }

        alert(errorMessage)
      }
    })
  })
})

function checkInputs() {
  const first_name_val = $('#first_name').val().trim()
  const last_name_val = $('#last_name').val().trim()
  const email_val = $('#email').val().trim()
  const password_val = $('#password').val().trim()
  const password_confirm_val = $('#confirm_password').val().trim()
  const city_val = $('#city').val().trim()
  const address_val = $('#address').val().trim()
  const phone_val = $('#phone').val().trim()
  const licence_number_val = $('#licence_number').val().trim()
  const years_of_experience_val = $('#years_of_experience').val().trim()


  if (first_name_val === '') {
    setErrorFor(first_name, 'First Name can\'t be blank.')
  } else if (!isFirstName(first_name_val)) {
    setErrorFor(first_name, 'First Name must start with uperrcase, 2-26 letters')
  } else {
    setSuccessFor(first_name)
  }

  if (last_name_val === '') {
    setErrorFor(last_name, 'Last Name can\'t be blank.')
  } else if (!isLastName(last_name_val)) {
    setErrorFor(last_name, 'Last Name must start with uperrcase, 2-26 letters')
  } else {
    setSuccessFor(last_name)
  }

  if (email_val === '') {
    setErrorFor(email, 'Email can\'t be blank.')
  } else if (!isEmail(email_val)) {
    setErrorFor(email, 'Email is not in good format.')
  } else {
    setSuccessFor(email)
  }

  if (password_val === '') {
    setErrorFor(password, 'Password can\'t be blank.')
  } else if (!isPassword(password_val)) {
    setErrorFor(password, 'Password must have at least 6 characters including number.')
  } else {
    setSuccessFor(password)
  }

  if (password_confirm_val === '') {
    setErrorFor(confirm_password, 'Must repeat password.')
  } else if (password_val !== password_confirm_val) {
    setErrorFor(confirm_password, 'Passwords must match.')
  } else {
    setSuccessFor(confirm_password)
  }

  if (city_val === '') {
    setErrorFor(city, 'City name can\'t be blank.')
  } else if (!isCity(city_val)) {
    setErrorFor(city, 'City name must start uppercase, 2-25 letters.')
  } else {
    setSuccessFor(city)
  }

  if (address_val === '') {
    setErrorFor(address, 'Address name can\'t be blank.')
  } else if (!isAddress(address_val)) {
    setErrorFor(address, 'Address name is not valid.')
  } else {
    setSuccessFor(address)
  }

  if (phone_val === '') {
    setErrorFor(phone, 'Phone number can\'t be blank.')
  } else if (!isPhone(phone_val)) {
    setErrorFor(phone, 'ex. 063/878-5451')
  } else {
    setSuccessFor(phone)
  }

  if (licence_number_val === '') {
    setErrorFor(licence_number, 'Licence number can\'t be blank.')
  } else if (!isLicenceNumber(licence_number_val)) {
    setErrorFor(licence_number, 'Licence number ex: F255-931-50-331-0')
  } else {
    setSuccessFor(licence_number)
  }

  if (years_of_experience_val === '') {
    setErrorFor(years_of_experience, 'Experience can\'t be blank.')
  } else if (!isExperienceYears(years_of_experience_val)) {
    setErrorFor(years_of_experience, 'Experience years must be positive number.')
  } else {
    setSuccessFor(years_of_experience)
  }
}

function setErrorFor(input, message) {
  const form_group = input.parentElement
  const small = form_group.querySelector('small')
  form_group.className = 'form-group error'
  small.innerText = message
}

function setSuccessFor(input) {
  const form_group = input.parentElement
  form_group.className = 'form-group success'
}

function isFirstName(first_name) {
  return /^[A-ZŠĐČĆŽ][a-zšđčćž]{1,25}$/.test(first_name)
}
function isLastName(last_name) {
  return /^[A-ZŠĐČĆŽ][a-zšđčćž]{1,25}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{1,25})*$/.test(last_name)
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
function isLicenceNumber(licence_number) {
  return /^[A-Z\d]{1,5}-\d{3}-\d{2}-\d{3}-\d$/.test(licence_number)
}
function isExperienceYears(years_of_experience) {
  return /^(?:[0-9]|[1-6][0-9]|70)$/.test(years_of_experience)
}