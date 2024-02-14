let current_page = location.href

$(document).ready(function () {
  $(".panel-item").click(changeUserPage)

  if (current_page.indexOf("cars") != -1) {
    ajaxCall("app/models/initApiCar.php", function (data) {
      const transmissions_array = data.transmissions
      const categories_array = data.categories
      const fuels_array = data.fuels

      const transmissions = printTransmissionChb(transmissions_array)
      const categories = printSelectList(categories_array, 'category_id', 'category_name', 'Category')
      const fuels = printSelectList(fuels_array, 'fuel_id', 'fuel_type', 'Fuel')

      $(transmissions).insertAfter("#search-key")
      $(categories).insertAfter("#search-key")
      $(fuels).insertAfter("#search-key")
    })

    ajaxCall("index.php?ajax=filterSortCars", function (data) {
      const cars = populateCarDiv(data.cars)
      $("#cars-container").html(cars)

      const pagination = displayPagination(data)
      $("#pagination-cars").html(pagination)
    })

    $("#slider-range").slider({
      range: true,
      min: 0,
      max: 200,
      values: [0, 200],
      slide: function (event, ui) {
        $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1])
        $("#min-value").val(ui.values[0])
        $("#max-value").val(ui.values[1])
      }
    })

    $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1))

    $("#btn-filter-cars, #search-button-navigation").click(filterCars)
  }

  if (current_page.indexOf("carDetails") != -1) {
    imageGallery()

    $(".tabs").click(changeTab)

    $(".tab-item:not(:first)").hide()
    $(".error-field").hide()

    $("#submit-request").click(sendRentRequest)
  }
})

function changeUserPage(e) {
  e.preventDefault()

  const page = $(this).data("pagename")

  $(".panel-item").removeClass("btn-green")

  $(this).removeClass("btn-light")
  $(this).addClass("btn-green")

  switch (page) {
    case "user-bookings":
      const booking = new UserBooking()
      booking.printUserBookings()
      break
    case "user-reviews":
      const review = new UserReview()
      review.printUserReviews()
      break
  }
}

function ajaxCall(url, callback) {
  $.ajax({
    url: url,
    success: callback,
    error: function (xhr, error, status) {
      console.log(xhr, error, status)
    }
  })
}

function ajaxCallPost(url, data, callback) {
  $.ajax({
    url: url,
    type: "POST",
    dataType: "json",
    data: data,
    success: callback,
    error: function (xhr) {
      console.log(xhr)

      if (xhr.responseText) {
        alert(xhr.responseJSON)
      }
    }
  })
}

function ajaxCallPromise(url) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: url,
      success: (data) => resolve(data),
      error: (xhr, error, status) => reject({ xhr, errror, status })
    })
  })
}

function changeTab() {
  const tab_name = $(this).data("tabname")

  $(".tabs").removeClass("active-tab")
  $(this).addClass("active-tab")

  $(".tab-item").hide()
  $("#" + tab_name).fadeIn()
}

function printTransmissionChb(data) {
  let html = "<p>Transmission type <br/> <small>Press ctrl and click to deselect</small></p>"

  for (let i = 0; i < data.length; i++) {
    html += `<div class="custom-control custom-radio">
      <input type="radio" class="custom-control-input control" id="custom-radio-${i}" name="transmission" value="${data[i].transmission_id}" />
      <label class="custom-control-label" for="custom-radio-${i}">${data[i].transmission_type}</label>
    </div>`
  }

  return html
}

function printSelectList(data, value_field, text_field, label) {
  let html = `<select name='${value_field}' id='${value_field}' class='form-control'> <option value='0'>Select ${label}</option>`

  for (let i = 0; i < data.length; i++) {
    html += `<option value='${data[i][value_field]}'>${data[i][text_field]}</option>`
  }

  html += `</select>`

  return html
}

function populateCarDiv(data) {
  let html = ""

  for (const element of data) {
    html += `
    <div class="col-sm-12 col-md-4 mb-4">
      <div class="item-1">
        <img src="public/assets/img/uploaded${element.main_image}" alt="${element.name}" class="img-fluid" />

        <div class="item-1-content">
          <div class="text-center">
            <h3>${element.category_name} ${element.name}</h3>
            <div class="rent-price"><span>$ ${element.price_per_day} / </span>day</div>
          </div>

          <ul class="specs">
            <li>
              <span>Doors:</span>
              <span class="spec">${element.doors}</span>
            </li>
            <li>
              <span>Seats:</span>
              <span class="spec">${element.seats}</span>
            </li>
            <li>
              <span>Transmission:</span>
              <span class="spec">${element.transmission_type}</span>
            </li>
            <li>
              <span>Fuel:</span>
              <span class="spec">${element.fuel_type}</span>
            </li>
          </ul>

          <div class="d-flex action">
            <a href="index.php?page=carDetails&carId=${element.car_id}" class="btn btn-green">View Details</a>
          </div>
        </div>
      </div>
    </div>
    `
  }

  return html
}


let page_number = 1

function getFilterData(clickedButton) {
  return {
    keyword: $("#search-key").val() || "",
    keyword_nav: $("#search-navigation").val() || "",
    fuel_id: $("#fuel_id").val() || "0",
    category_id: $("#category_id").val() || "0",
    transmission_id: $("input[name='transmission']:checked").val() || "0",
    min_val_price: parseInt($("#min-value").val()) || 0,
    max_val_price: parseInt($("#max-value").val()) || 0,
    button_val: $(clickedButton).val(),
    page_number: page_number
  };
}

function filterCars() {
  const data_filter = getFilterData()

  ajaxCallPost("index.php?ajax=filterSortCars", data_filter, function (data) {
    const html_cars = data.cars.length ? populateCarDiv(data.cars) : "<h3>We don't have any car for selected criteria.</h3>"

    $("#cars-container").html(html_cars)

    displayPagination(data)
  })
}

function displayPagination(data) {
  let current_page = data.currentPage
  let html_pagination = '<ul class="pagination">'

  for (let i = 1; i <= data.numberOfPages; i++) {
    let is_active = i === current_page ? 'active' : ''
    html_pagination += `<a class="p-2 link-pagination ${is_active}" href="index.php?page=cars&page_number=${i}${data.queryString}">${i}</a>`
  }

  html_pagination += '</ul>'

  $("#pagination-cars").html(html_pagination)

  $(".link-pagination").click(changePaginationPage)
}

function changePaginationPage(e) {
  e.preventDefault()

  let href_attribute = $(this).attr("href").split("&")
  let query_string = ""

  for (let i = 1; i < href_attribute.length; i++) {
    if (i == 1) {
      query_string += href_attribute[i]
    } else {
      query_string += "&" + href_attribute[i]
    }
  }

  console.log(query_string)

  const data_filter = getFilterData()
  const page_number = getPageNumberFromUrl(query_string)

  $.ajax({
    type: "POST",
    url: "index.php?ajax=filterSortCars",
    data: { ...data_filter, page_number: page_number },
    success: function (data) {
      const cars = data.cars.length ? populateCarDiv(data.cars) : "";
      $("#cars-container").html(cars)

      displayPagination(data)
    },
    error: function (xhr) {
      console.log(xhr)
    }
  })
}

function getPageNumberFromUrl(url) {
  const match = url.match(/page_number=(\d+)/)
  return match ? parseInt(match[1]) : 1
}

function imageGallery() {
  let highlight = $(".gallery-highlight")
  let previews = $(".car-preview img")

  previews.click(function () {
    let small_img = $(this).attr("src")
    let big_img = small_img.replace("small", "").replace("-", "").replace("//", "/")

    highlight.attr("src", big_img)

    previews.removeClass("car-active")

    $(this).addClass("car-active")
  })
}

function sendRentRequest() {
  const car_id = $("#car_id").val()
  const user_id = $("#user_id").val()

  const date_from = $("#from-date").val()
  const date_to = $("#to-date").val()

  const current_date = new Date()
  const current_timestamp = Date.UTC(current_date.getFullYear(), current_date.getMonth(), current_date.getDate())

  const date_from_obj = new Date(date_from)
  const date_to_obj = new Date(date_to)
  const date_from_timestamp = Date.UTC(date_from_obj.getFullYear(), date_from_obj.getMonth(), date_from_obj.getDate())
  const date_to_timestamp = Date.UTC(date_to_obj.getFullYear(), date_to_obj.getMonth(), date_to_obj.getDate())

  if (date_from_timestamp < current_timestamp || date_to_timestamp < current_timestamp) {
    alert("You must choose date in future")
    return false
  }
  if (date_from == "" || date_to == "") {
    alert("You must choose both dates")
    return false
  }
  if (date_from_timestamp > date_to_timestamp) {
    $(".error-field").fadeIn()
    return false
  } else {
    $(".error-field").fadeOut()
  }

  const obj_to_send = {
    car_id,
    user_id,
    date_from,
    date_to,
    btn_send_request: true
  }

  ajaxCallPost("index.php?ajax=handleBooking", obj_to_send, data => {
    $("#request-success").html(data)
  })
}

function checkContactForm() {
  let errors = []

  const fields = [
    {
      selector: "#first_name_contact",
      regex: /^[A-Z][a-z]{2,20}(\s[A-Z][a-z]{3,20}){0,2}$/,
      type: "input",
      example: "John"
    },
    {
      selector: "#last_name_contact",
      regex: /^[A-Z][a-z]{2,20}(\s[A-Z][a-z]{3,20}){0,2}$/,
      type: "input",
      example: "Smith"
    },
    {
      selector: "#email_contact",
      regex: /^[A-z\d\.-]{5,100}\@[a-z]{2,10}\.[a-z]{2,20}$/,
      type: "input",
      example: "johnsmith@gmail.com"
    },
    {
      selector: "#message",
      type: "textarea",
      example: "Your message must have at least 10 characters"
    }
  ]

  for (const element of fields) {
    if (element.type == "input") {
      checkInputField(element)
    }
    else if (element.type == "textarea") {
      const textarea = $(element.selector)

      if (textarea.val().length < 10) {
        errors.push("Message must have at least 10 characters")
        textarea.addClass("border border-danger")

        $(element.selector + "Err").html(element.example)
        $(element.selector + "Err").fadeIn()

        return false
      } else {
        $(element.selector + "Err").hide()
        textarea.removeClass("border-danger")
      }
    }
  }

  if (errors.length) {
    return false
  } else {
    return true
  }
}

function populateBookingsTable(data) {
  let html = ""

  for (const element of data) {
    html += `<tr>
      <td>${element.booking_id}</td>
      <td>${element.first_name} ${element.last_name}</td>
      <td>${element.category_name} ${element.name}</td>
      <td>${element.date_from}</td>
      <td>${element.date_to}</td>
      <td>${element.price_per_day} &euro;</td>
      <td id="status" data-statusid="${element.status}">${element.status == 1 ? "Confirmed" : element.status == 2 ? "Canceled" : "Not Processed"}</td>`
    if (current_page.indexOf("admin") != -1) {
      html += `
        <td>
          <a href="#" class="cancel-booking-admin btn btn-danger" data-bookingid="${element.booking_id}">Cancel</a>
          <a href="#" class="confirm-booking-admin btn btn-green" data-bookingid="${element.booking_id}" data-carid="${element.car_id}">Confirm</a>
        </td>
      </tr>`
    } else {
      html += `
        <td>
          <a href="#" class="cancel-booking-user btn btn-danger" data-bookingid="${element.booking_id}">Cancel</a>
        </td>
      </tr>`
    }
  }

  return html
}

function populateUserReviewsTable(data) {
  let html = ""

  for (const element of data) {
    html += `<tr>
      <td>${element.review_id}</td>
      <td>${element.category_name} ${element.name}</td>
      <td>
        <textarea class="form-control" id="review${element.review_id}" rows="3">${element.review_text}</textarea>
      </td>
      <td>
        <a href="#" class="edit-review" data-reviewid="${element.review_id}" data-reviewstatus="1">
          <i class="fi fi-rs-edit px-2"></i>
        </a>
        <a href="#" class="delete-review" data-reviewid="${element.review_id}" data-reviewstatus="0">
          <i class="fi fi-br-cross px-2"></i>
        </a>
      </td>
    </tr>`
  }

  return html
}

function populateFormForInsertReview(data) {
  let html = ""

  html += `
  <div class="card">
    <div class="card-header">Reviews info</div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">`

  if (data.length) {
    html += `<label for="car">Select car</label>
              <select class="form-control" name="car_id" id="car_id">
                <option value="0">Select</option>`
    for (const element of data) {
      html += `<option value="${element.car_id}">${element.category_name} ${element.name}</option>`
    }
    html += `</select>`
  } else {
    html += `<p>You must first rent a car to be able to write a review</p>`
  }

  html += `</div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
              <label for="review_text">Review text</label>
              <textarea class="form-control" name="review_text" id="review_text" rows="3"></textarea>
              <small id="review_textErr" class='form-text text-danger error-field'>Review must have at least 10 chars</small>
          </div>
        </div>

      </div>
    </div>
  </div>
  <button class="btn btn-green my-3" type="button" id="btnInsertReview" name="btnInsertReview">Submit</button>`

  return html
}

class UserBooking {
  printUserBookings() {
    const url = "app/views/pages/user/bookings/selectAll.php"
    const url_populate = "index.php?ajax=userBookings"

    ajaxCall(url, data => {
      $("#main-content-user").html(data)
    })

    ajaxCall(url_populate, bookings => {
      const html_bookings = populateBookingsTable(bookings)
      $("#table-body-bookings-user").html(html_bookings)

      $(".cancel-booking-user").click((e) => {
        e.preventDefault()
        const booking_id = e.target.dataset.bookingid

        this.cancelBookingRequestUser(booking_id)
      })
    })
  }

  cancelBookingRequestUser(booking_id) {
    const status = $("#status").data("statusid")

    if (status == 1) {
      const obj_to_send = {
        booking_id: booking_id,
      }

      ajaxCallPost("index.php?ajax=cancelBookingUser", obj_to_send, data => {
        alert("Successfully canceled")
        this.printUserBookings()
      })
    } else {
      alert("Admin didn't approved your request, You cannot cancel yet")
    }
  }
}

class UserReview {
  printUserReviews() {
    const url = "app/views/pages/user/reviews/selectAll.php"
    const url_populate = "index.php?ajax=userReviews"

    ajaxCall(url, data => {
      $("#main-content-user").html(data)
    })

    ajaxCall(url_populate, reviews => {
      const html_reviews = populateUserReviewsTable(reviews)
      $("#user-reviews-table").html(html_reviews)

      $(".edit-review").click(e => {
        e.preventDefault()
        const review_id = e.target.parentElement.dataset.reviewid
        this.handleEditReview(review_id)
      })

      $(".delete-review").click(e => {
        e.preventDefault()
        const review_id = e.target.parentElement.dataset.reviewid
        if (confirm("Are you sure you want to delete this review?")) {
          this.handleDeleteReview(review_id)
        }
      })

      $(".insert-review").click(() => {
        this.printInsertReview()
      })
    })
  }

  handleEditReview(review_id) {
    const review_text = $("#review" + review_id)

    if (review_text.val().trim().length) {
      const url = "index.php?ajax=reviewUpdate"

      const review_data = {
        review_id: review_id,
        review_text: review_text.val(),
        btnUpdateReview: true
      }

      ajaxCallPost(url, review_data, data => {
        if (data) {
          alert("Updated successfully")
          this.printUserReviews()
        } else {
          console.log(data)
        }
      })
    }
  }

  handleDeleteReview(review_id) {
    const url = "index.php?ajax=reviewDelete"

    const review_data = {
      review_id: review_id,
      btnDeleteReview: true
    }

    ajaxCallPost(url, review_data, data => {
      if (data) {
        alert("Successfully deleted")
        this.printUserReviews()
      } else {
        console.log(data)
      }
    })
  }

  printInsertReview() {
    const url = "app/views/pages/user/reviews/insertForm.php"
    const url_populate = "index.php?ajax=carsForReview"

    ajaxCall(url, data => {
      $("#main-content-user").html(data)
    })

    ajaxCall(url_populate, cars => {
      const html_cars = populateFormForInsertReview(cars)
      $("#review-form").html(html_cars)

      $("#btnInsertReview").click(() => this.checkInsertReviewForm())
    })
  }

  checkInsertReviewForm() {
    let errors = []
    let review_data = {}

    const fields = [
      {
        selector: "#car_id",
        type: "ddl"
      },
      {
        selector: "#review_text",
        regex: "",
        type: "textarea"
      }
    ]

    for (const element of fields) {
      let property_name = element.selector.substr(1)

      if (element.type == "ddl") {
        if ($(element.selector).val() != 0) {
          $(element.selector + "Err").hide()
          $(element.selector).removeClass("border-danger")
          review_data[property_name] = $(element.selector).val()
        } else {
          errors.push(element.selector + " you must choose")
          $(element.selector).addClass("border border-danger")
          return false
        }
      }
      if (element.type == "textarea") {
        let textarea = $(element.selector)

        if (textarea.val().length < 10 || textarea.val().trim().length < 10) {
          errors.push("Review must have at least 10 characters")
          textarea.addClass("border border-danger")
          $(element.selector + "Err").fadeIn()
          return false
        } else {
          $(element.selector + "Err").hide()
          textarea.removeClass("border-danger")
          review_data[property_name] = textarea.val()
        }
      }
    }

    if (!$("#car_id").length) {
      return false
    }

    let user_review_id = $("#user-review-id").val()
    review_data["user_id"] = user_review_id

    review_data["btnInsertReview"] = true

    if (errors.length) {
      return false
    }

    ajaxCallPost("index.php?ajax=insertUserReview", review_data, data => {
      alert("Successfully inserted review")
      this.printUserReviews()
    })
  }
}