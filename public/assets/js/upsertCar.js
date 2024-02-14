let errors = [];

let car_form_fields = [
  {
    selector: "#car_name",
    regex: /^[A-z\s\d\.]{2,30}$/,
    type: "input",
    example: "Sportage"
  },
  {
    selector: "#category_id",
    regex: "",
    type: "ddl"
  },
  {
    selector: "#description",
    regex: "",
    type: "textarea"
  },
  {
    selector: "#model_year",
    regex: /^(19|20)[0-9]{2}$/,
    type: "input",
    example: 2000
  },
  {
    selector: "#price",
    regex: "",
    type: "number"
  },
  {
    selector: "#fuel_id",
    regex: "",
    type: "ddl"
  },
  {
    selector: "input[name=transmission]",
    regex: "",
    type: "radio",
    error_selector: "#transmission_type_err",
    name: "transmission"
  },
  {
    selector: "#seats",
    regex: "",
    type: "number"
  },
  {
    selector: "#doors",
    regex: "",
    type: "number"
  },
  {
    selector: "#mileage",
    regex: "",
    type: "number"
  },
  {
    selector: "#luggage",
    regex: "",
    type: "number"
  },
  {
    selector: "#main_image",
    regex: "",
    type: "file"
  },
  {
    selector: "#other_image",
    regex: "",
    type: "file"
  },
  {
    selector: "#other_image2",
    regex: "",
    type: "file"
  }
];

let car_form_data = new FormData()
function checkInsertCarForm() {
  for (const element of car_form_fields) {
    if (element.type == "input") {
      checkInputField(element, car_form_data)
    }
    else if (element.type == "number") {
      checkNumberField(element, car_form_data)
    }
    else if (element.type == "ddl") {
      checkDropDownListField(element, car_form_data)
    }
    else if (element.type == "textarea") {
      const textarea = $(element.selector)

      if (textarea.val().length < 10 || textarea.val().trim().length < 10) {
        errors.push("Description must have at least 10 characters")
        textarea.addClass("border border-danger")
        $("#descErr").fadeIn()
        return false
      } else {
        $("#descErr").hide()
        textarea.removeClass("border-danger")
        const prop_name = textarea[0].name
        car_form_data.append(prop_name, textarea.val())
      }
    }
    else if (element.type == "radio") {
      const radio_button = $(element.selector + ":checked")

      if (radio_button.length == 0 || radio_button.val() == "") {
        errors.push("Select one option")
        $(element.error_selector).fadeIn()
        return false
      } else {
        $(element.error_selector).hide()
        car_form_data.append(element.name, radio_button.val())
      }
    }
    else if (element.type == "file") {
      if (!$(element.selector).val()) {
        errors.push("Upload photo error")
        $(element.selector + "Err").fadeIn()
        return false
      } else {
        $(element.selector + "Err").hide()
        const image = document.querySelector(element.selector).files[0]
        const prop_name = element.selector.substr(1)
        car_form_data.append(prop_name, image)
      }
    }
  }

  const accessories = $('.accessories:checked')

  if (accessories.length) {
    const accessories_array = Array.from(accessories)

    for (const element of accessories_array) {
      const element_id = $(element).attr("id")
      const element_value = $(element).val()

      car_form_data.append(element_id, element_value)
    }
  }

  if (errors.length) {
    return errors
  } else {
    car_form_data.append("btn-insert-car", "true")
    return car_form_data
  }
}

function checkInputField(element, data = new FormData()) {
  const field = $(element.selector)
  const regex = element.regex
  const field_error = $(element.selector + "Err")
  const prop_name = element.selector.substr(1)

  if (regex.test(field.val())) {
    field.removeClass("border-danger")
    field_error.hide()
    data.append(prop_name, field.val())
  } else {
    errors.push(element.selector + " not in right format")
    field.val("")
    field.addClass("border border-danger")
    field_error.html("Valid format: " + element.example)
    field_error.fadeIn()
    return false
  }
}

function checkNumberField(element, data = new FormData()) {
  const field = $(element.selector)
  const field_error = $(element.selector + "Err")
  const prop_name = element.selector.substr(1)

  if (field.val() < 0 || field.val() == "") {
    field.addClass("border border-danger")
    errors.push(element.selector + " enter positive number")
    field_error.html("Valid format: enter positive number")
    field_error.fadeIn()
    return false
  } else {
    field.removeClass("border-danger")
    field_error.hide()
    data.append(prop_name, field.val())
  }
}

function checkDropDownListField(element, data = new FormData()) {
  const field = $(element.selector)
  const prop_name = element.selector.substr(1)

  if (field.val() == 0) {
    field.addClass("border border-danger")
    errors.push(element.selector + " select one element")
    return false
  } else {
    field.removeClass("border-danger")
    data.append(prop_name, field.val())
  }
}

let update_car_form_data = new FormData()
function checkUpdateCarForm() {
  update_car_form_data.append("car_id", $("#car-id").val())

  for (const element of car_form_fields) {
    if (element.type == "input") {
      checkInputField(element, update_car_form_data)
    }
    else if (element.type == "number") {
      checkNumberField(element, update_car_form_data)
    }
    else if (element.type == "ddl") {
      checkDropDownListField(element, update_car_form_data)
    }
    else if (element.type == "textarea") {
      const textarea = $(element.selector)

      if (textarea.val().length < 10 || textarea.val().trim().length < 10) {
        errors.push("Description must have at least 10 characters")
        textarea.addClass("border border-danger")
        $("#descErr").fadeIn()
        return false
      } else {
        $("#descErr").hide()
        textarea.removeClass("border-danger")
        let prop_name = textarea[0].name
        update_car_form_data.append(prop_name, textarea.val())
      }
    }
    else if (element.type == "radio") {
      const radio_button = $(element.selector + ":checked")

      if (radio_button.length == 0 || radio_button.val() == "") {
        errors.push("Select one option")
        $(element.error_selector).fadeIn()
        return false
      } else {
        $(element.error_selector).hide()
        update_car_form_data.append(element.name, radio_button.val())
      }
    }
    else if (element.type == "file") {
      if ($(element.selector).val()) {
        $(element.selector + "Err").hide()
        const image = document.querySelector(element.selector).files[0]
        const prop_name = element.selector.substr(1)
        update_car_form_data.append(prop_name, image)
      }
    }
  }

  const accessories = $('.accessories:checked')

  if (accessories.length) {
    const accessories_array = Array.from(accessories)

    for (const element of accessories_array) {
      const element_id = $(element).attr("id")
      const element_value = $(element).val()

      update_car_form_data.append(element_id, element_value)
    }
  }

  if (errors.length) {
    return errors
  } else {
    update_car_form_data.append("btn-update-car", "true")
    return update_car_form_data
  }
}