$(document).ready(function () {
  $(".panel-item").click(changeAdminPage)
})

function changeAdminPage(e) {
  e.preventDefault()
  let page = $(this).data("pagename")

  $(".panel-item").removeClass("btn-green");

  $(this).removeClass("btn-light")
  $(this).addClass("btn-green")

  switch (page) {
    case "cars":
      let car = new Car()
      car.printAdminCars()
      break
    case "bookings":
      let booking = new AdminBooking()
      booking.printAdminBookings()
      break
    case "stats":
      let stats = new Stats()
      stats.printStats()
      break
    case "admin_reviews":
      let admin_review = new AdminReview()
      admin_review.printAdminReviews()
      break
  }
}

function populateAdminCarsTable(data) {
  let html = ""

  for (const element of data) {
    html += `<tr>
      <td>${element.name}</td>
      <td>${element.price_per_day} &euro;</td>
      <td>${element.fuel_type}</td>
      <td>${element.model_year}</td>
      <td>
        <a href="#" class="edit-admin-car" data-carid="${element.car_id}">
          <i class="fi fi-rs-edit px-2"></i>
        </a>
        <a href="#" class="delete-admin-car" data-carid="${element.car_id}">
          <i class="fi fi-br-cross px-2"></i>
        </a>
      </td>
    </tr>`
  }

  return html
}

function printEquipment(equipment) {
  const accessories = [
    { "id_prop": "aircondition", "text": "Airconditions" },
    { "id_prop": "break_system", "text": "AntiLock Breaking System" },
    { "id_prop": "leather_seats", "text": "Leather Seats" },
    { "id_prop": "brake_assist", "text": "Brake Assist" },
    { "id_prop": "crash_sensor", "text": "Crash Sensor" },
    { "id_prop": "onboard_pc", "text": "Onboard computer" },
    { "id_prop": "gps", "text": "GPS" },
    { "id_prop": "locking", "text": "Central Locking" },
    { "id_prop": "abs", "text": "ABS" },
    { "id_prop": "bluetooth", "text": "Bluetooth" },
    { "id_prop": "child_seat", "text": "Child Seat" },
    { "id_prop": "parking_sensor", "text": "Parking Sensors" },
  ];

  let output = "";

  for (let i = 0; i < accessories.length; i++) {
    const accessory = accessories[i];
    const equipmentItem = equipment.find(item => item.feature_name == accessory.text);

    const checked = equipmentItem && equipmentItem.feature_value == "1" ? "checked='checked'" : "";

    output += `
      <div class='col-md-4 my-2'>
        <div class='form-check form-check-inline'>
          <input class='accessories form-check-input' type='checkbox' id='${accessory.id_prop}' name='${accessory.id_prop}' value='1' ${checked} />
          <label class='form-check-label' for='${accessory.id_prop}'>${accessory.text}</label>
        </div>
      </div>`;
  }

  return output;
}

function populateAdminReviewsTable(data) {
  let html = ""

  for (const element of data) {
    html += `<tr>
      <td>${element.review_id}</td>
      <td>${element.first_name} ${element.last_name}</td>
      <td>${element.category_name} ${element.name}</td>
      <td>${element.review_text}</td>
      <td>${element.review_status == 1 ? "Visible" : "Hidden"}</td>
      <td>
        <a href="#" class="change-status" data-reviewid="${element.review_id}" data-reviewstatus="1">
          Show
        </a>
        /
        <a href="#" class="change-status" data-reviewid="${element.review_id}" data-reviewstatus="0">
          Hide
        </a>
      </td>
    </tr>`
  }

  return html
}

function addSuffixToFileName(file_name, suffix) {
  let file_parts = file_name.split(".")
  file_parts[0] += suffix
  return file_parts.join(".")
}

class Car {
  printAdminCars() {
    const url = "app/views/pages/admin/cars/selectAll.php"
    const url_populate = "index.php?ajax=adminCars"

    // Ukloni prethodne dogadjaje
    $(document).off("click", ".edit-admin-car");
    $(document).off("click", ".delete-admin-car");
    $(document).off("click", ".insert-car");

    ajaxCall(url, data => {
      $("#main-content").html(data)
    })

    ajaxCall(url_populate, cars => {
      const html_cars = populateAdminCarsTable(cars)
      $("#admin-table-cars").html(html_cars)

      $(".insert-car").click(() => this.printInsertCarForm())
    })

    $(document).on("click", ".edit-admin-car", (e) => {
      e.preventDefault()
      const car_id = e.target.parentElement.dataset.carid

      this.printUpdateCarForm(car_id)
    })

    $(document).on("click", ".delete-admin-car", (e) => {
      e.preventDefault()
      const car_id = e.target.parentElement.dataset.carid
      if (confirm("Are you sure you want to delete this car?")) {
        this.deleteCar(car_id)
      }
    })
  }

  printInsertCarForm() {
    const url = "app/views/pages/admin/cars/insertForm.php"

    ajaxCall(url, data => {
      $("#main-content").html(data)

      $("#btn-insert-car").click(() => this.insertCar())
    })
  }

  insertCar() {
    const car_data = checkInsertCarForm()

    $.ajax({
      url: "index.php?ajax=insertCar",
      method: "POST",
      data: car_data,
      contentType: false,
      processData: false,
      success: (response) => {
        if (response) {
          alert("Successfully inserted.")
          this.printAdminCars()
        } else {
          console.log(response)
        }
      },
      error: function (xhr) {
        console.log(xhr);
      }
    })
  }

  async printUpdateCarForm(car_id) {
    const url = "app/views/pages/admin/cars/updateForm.php?carId=" + car_id

    const data = await ajaxCallPromise(url)

    $("#main-content").html(data)

    let response = await $.ajax({
      url: "index.php?ajax=singleCar",
      method: "POST",
      data: { car_id: car_id }
    });

    $("#car-id").val(response.car.car_id)

    $("#car_name").val(response.car.name)
    $("#category_id").val(response.car.category_id)
    $("#description").val(response.car.description)
    $("#model_year").val(response.car.model_year)
    $("#fuel_id").val(response.car.fuel_id)
    $("#price").val(response.car.price_per_day)
    $("#seats").val(response.car.seats)
    $("#doors").val(response.car.doors)
    $("#mileage").val(response.car.mileage)
    $("#luggage").val(response.car.luggage)

    const main_image_name = addSuffixToFileName(response.car.main_image, "-small")
    $(".cover-img").attr("src", "public/assets/img/uploaded" + main_image_name)

    const other_image_name = addSuffixToFileName(response.images[0].image_name, "-small")
    $(".other-img1").attr("src", "public/assets/img/uploaded" + other_image_name)

    const other_image_name2 = addSuffixToFileName(response.images[1].image_name, "-small")
    $(".other-img2").attr("src", "public/assets/img/uploaded" + other_image_name2)

    $("#main_image").val("")

    const transmission_array = $(".custom-control-input")
    for (let i = 0; i < transmission_array.length; i++) {
      const element = transmission_array[i]
      if (element.value == response.car.transmission_id) {
        element.checked = true
        break
      }
    }

    const accessoriesHTML = printEquipment(response.equipment);
    $(".equipment-div").html(accessoriesHTML)

    $("#btn-update-car").click(() => this.updateCar())
  }

  updateCar() {
    const car_data = checkUpdateCarForm()

    $.ajax({
      url: "index.php?ajax=updateCar",
      method: "POST",
      data: car_data,
      contentType: false,
      processData: false,
      success: (response) => {
        if (response) {
          alert("Successfully updated");
          this.printAdminCars();
        } else {
          console.log(response);
        }
      },
      error: function (xhr) {
        console.log(xhr);
      }
    })
  }

  deleteCar(car_id) {
    const obj_to_send = {
      car_id: car_id,
      btnDeleteCar: true
    }

    ajaxCallPost("index.php?ajax=deleteCar", obj_to_send, data => {
      if (data) {
        alert("Successfully deleted")
        this.printAdminCars()
      }
    })
  }
}

class Stats {
  printStats() {
    const url = "app/views/pages/admin/statsLog.php"

    ajaxCall(url, data => {
      $("#main-content").html(data)
    })
  }
}

class AdminBooking {
  printAdminBookings() {
    const url = "app/views/pages/admin/bookings/selectAll.php"
    const url_populate = "index.php?ajax=adminBookings"

    ajaxCall(url, data => {
      $("#main-content").html(data)
    })

    ajaxCall(url_populate, bookings => {
      const html_bookings = populateBookingsTable(bookings)
      $("#table-body-bookings").html(html_bookings)

      $(".cancel-booking-admin").click((e) => {
        e.preventDefault()

        const booking_id = e.target.dataset.bookingid

        this.cancelBookingRequestAdmin(booking_id)
      })

      $(".confirm-booking-admin").click((e) => {
        e.preventDefault()

        const booking_id = e.target.dataset.bookingid
        const car_id = e.target.dataset.carid

        this.confirmBookingRequestAdmin(booking_id, car_id)
      })
    })
  }

  cancelBookingRequestAdmin(booking_id) {
    const obj_to_send = {
      booking_id: booking_id,
    }

    ajaxCallPost("index.php?ajax=cancelBookingAdmin", obj_to_send, data => {
      alert("Successfully canceled")
      this.printAdminBookings()
    })
  }

  confirmBookingRequestAdmin(booking_id, car_id) {
    const obj_to_send = {
      booking_id: booking_id,
      car_id: car_id,
      btn_handle_book: true
    }

    ajaxCallPost("index.php?ajax=confirmBooking", obj_to_send, data => {
      alert(data)
      this.printAdminBookings()
    })
  }
}

class AdminReview {
  printAdminReviews() {
    const url = "app/views/pages/admin/reviews/selectAll.php"
    const url_populate = "index.php?ajax=adminReviews"

    ajaxCall(url, data => {
      $("#main-content").html(data)
    })

    ajaxCall(url_populate, reviews => {
      const html_reviews = populateAdminReviewsTable(reviews)
      $("#admin-reviews-table").html(html_reviews)

      $(".change-status").click((e) => {
        e.preventDefault()

        const review_id = e.target.dataset.reviewid
        const review_status = e.target.dataset.reviewstatus

        this.changeReviewStatus(review_id, review_status)
      })
    })
  }

  changeReviewStatus(review_id, review_status) {
    const url = "index.php?ajax=changeReviewStatus"

    const obj_to_send = {
      review_id: review_id,
      review_status: review_status,
      btnChangeStatus: true
    }

    ajaxCallPost(url, obj_to_send, data => {
      if (data) {
        alert("Status changed")
        this.printAdminReviews()
      }
    })
  }
}