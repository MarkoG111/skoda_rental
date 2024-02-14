<?php
$car = $data["car_details"];
?>
<div class="site-section bg-light">
  <div class="container">
    <div class="text-center">
      <div class="mx-auto">
        <p class="text-uppercase category-title"><?= $car->category_name; ?></p>
        <h2><?= $car->name; ?></h2>
      </div>

      <div class="mx-auto mt-5 mb-5 w-75" id="car-gallery">
        <img src="<?= USER_IMAGES . $car->main_image; ?>" alt="car" class="img-fluid gallery-highlight" />

        <div class="car-preview">
          <?php
          $main_image_src = explode(".", $car->main_image);
          $main_image_src[0] .= "-small";
          $new_src = implode(".", $main_image_src);

          $small_images = [$car->main_image, $car->images[0]->image_name, $car->images[1]->image_name];

          foreach ($small_images as $small_image) :
            $new_src = explode(".", $small_image);
            $new_src[0] .= "-small";
            $new_src = implode(".", $new_src);
          ?>

            <img src="<?= USER_IMAGES . $new_src; ?>" alt="<?= $small_image; ?>">
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <div class="row">
      <?php
      $features = [
        ["Mileage", "fi fi-rr-dashboard", $car->mileage],
        ["Transmission", "fi fi-ss-process", $car->transmission_type],
        ["Seats", "fi fi-rr-person-seat-reclined", $car->seats],
        ["Luggage", "fi fi-rr-backpack", $car->luggage],
        ["Fuel", "fi fi-rr-gas-pump-alt", $car->fuel_type],
      ];

      for ($i = 0; $i < count($features); $i++) :
      ?>

        <div class="col-md d-flex align-self-stretch ftco-animate">
          <div class="media block-6 features">
            <div class="media-body py-md-4">
              <div class="d-flex mb-3 align-items-center">
                <div class="icon d-flex align-items-center justify-content-center">
                  <span class="<?= $features[$i][1]; ?>"></span>
                </div>
                <div class="text mb-2">
                  <h3 class="heading pl-3">
                    <?= $features[$i][0]; ?>
                    <span class="feature-value"><?= $features[$i][2]; ?></span>
                  </h3>
                </div>
              </div>
            </div>
          </div>
        </div>

      <?php endfor; ?>
    </div>

    <div class="row mx-auto justify-content-center mt-4" id="tabs-container">
      <ul class="d-flex pb-3" id="list-container">
        <li class="tabs active-tab" data-tabname="desc">Description</li>
        <li class="tabs" data-tabname="features">Features</li>
        <li class="tabs" data-tabname="reviews">Reviews</li>
      </ul>
    </div>

    <div class="tab-content mt-5">
      <div class="row">
        <div class="col-md-12 tab-item" id="desc">
          <p><?= $car->description; ?></p>
        </div>

        <div class="col-md-12 tab-item" id="features">
          <div class="row">
            <div class="col-md-4">
              <ul class="features">
                <?php
                $equipment_n1 = array_slice($car->equipment, 0, 4);
                printEquipmentAddons($equipment_n1);
                ?>
              </ul>
            </div>
            <div class="col-md-4">
              <ul class="features">
                <?php
                $equipment_n2 = array_slice($car->equipment, 4, 4);
                printEquipmentAddons($equipment_n2);
                ?>
              </ul>
            </div>
            <div class="col-md-4">
              <ul class="features">
                <?php
                $equipment_n3 = array_slice($car->equipment, 8);
                printEquipmentAddons($equipment_n3);
                ?>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-md-12 tab-item" id="reviews">
          <?php
          if (count($car->reviews)) :
            foreach ($car->reviews as $review) :
          ?>
              <div class="d-flex justify-content-between">
                <h3><?= $review->first_name . " " . $review->last_name ?></h3>
                <p><?= $review->review_text; ?></p>
              </div>
            <?php endforeach; ?>
          <?php else : ?>
            <p>No reviews for this car.</p>
          <?php endif; ?>
        </div>

        <div class="my-5">
          <?php if (isset($_SESSION['user'])) : ?>
            <h2>Submit a request</h2>

            <form>
              <input type="hidden" id="car_id" value="<?= $car->car_id; ?>" />
              <input type="hidden" id="user_id" value="<?= $_SESSION["user"]->user_id; ?>" />

              <div class="d-flex mt-5 mb-2">
                <div class="form-group mr-5">
                  <label for="from-date">From</label>
                  <input type="date" name="from-date" id="from-date" />
                </div>

                <div class="form-group mx-5">
                  <label for="to-date">To</label>
                  <input type="date" name="to-date" id="to-date" />
                </div>
              </div>

              <div id="date-error" class="form-text text-danger error-field mb-2">
                Date from must be before date to
              </div>
              <div id="request-success" class="text-green">

              </div>

              <input type="button" value="Submit" class="btn btn-green" id="submit-request" name="submit-request">
            </form>
          <?php else : ?>
            <div class="container">
              <h2>Log in to submit a request</h2>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>