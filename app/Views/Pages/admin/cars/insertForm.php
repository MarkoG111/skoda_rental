<?php
require_once "../../../../models/initInsertFormCar.php";
require_once "../../../../config/setup.php";
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 mx-auto">
      <h2>Insert new car</h2>

      <div class="row">
        <div class="col-md-12">
          <form action="models/cars/insertCar.php" class="form-horizontal" method="POST" enctype="multipart/form-data" onSubmit="return checkInsertCarForm()">
            <div class="card">
              <div class="card-header">Basic Info</div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <?php printFormInput("car_name", "Car Name", "text"); ?>
                  </div>
                  <div class="col-md-6">
                    <?php printFormList($categories, "category_id", "category_name", "Select Category"); ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="description">Car Description</label>
                      <textarea class="form-control" name="description" id="description" rows="3">

                      </textarea>
                      <small id="descErr" class='form-text text-danger error-field'>Description must have at
                        least 10 characters</small>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?php printFormInput("model_year", "Model year", "number"); ?>
                  </div>
                  <div class="col-md-6">
                    <?php printFormList($fuels, "fuel_id", "fuel_type", "Select Fuel"); ?>
                  </div>
                </div>
                <div class="row my-4">
                  <div class="col-md-6">
                    <?php printFormInput("price", "Price per day", "number"); ?>
                  </div>
                  <div class="col-md-6">
                    <?php printCheckbox($transmissions, "transmission_id", "transmission_type", "Transmission"); ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?php printFormInput("seats", "Number of seats", "number"); ?>
                  </div>
                  <div class="col-md-6">
                    <?php printFormInput("doors", "Number of doors", "number"); ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?php printFormInput("mileage", "Mileage", "number"); ?>
                  </div>
                  <div class="col-md-6">
                    <?php printFormInput("luggage", "Luggage", "number"); ?>
                  </div>
                </div>

                <h3>Images</h3>
                <div class="row">
                  <div class="col-md-4">
                    <?php printImageFile("main_image", "Cover photo"); ?>
                  </div>
                  <div class="col-md-4">
                    <?php printImageFile("other_image", "Other photo"); ?>
                  </div>
                  <div class="col-md-4">
                    <?php printImageFile("other_image2", "Other photo"); ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="card my-5">
              <div class="card-header">Equipment</div>
              <div class="card-body">
                <div class="row">
                  <?php printEquipment(); ?>
                </div>
              </div>
            </div>

            <button class="btn btn-green my-3" type="button" id="btn-insert-car" name="btn-insert-car">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>