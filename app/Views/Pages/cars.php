<div class="heading text-center my-4">
  <h2 class="font-weight-bold">Various ŠKODA cars</h2>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">
      <h3>Filter</h3>

      <form class="filter-form mt-4">
        <input type="text" name="search-key" id="search-key" class="form-control" placeholder="Search" />

        <input type="hidden" name="min-value" id="min-value" value="" />
        <input type="hidden" name="max-value" id="max-value" value="" />
        <div>
          <label for="amount">Price range:</label>
          <input type="text" id="amount" readonly />
        </div>
        <div id="slider-range"></div>

        <input type="button" name="btn-filter-cars" id="btn-filter-cars" class="btn btn-green" value="Submit" />
      </form>
    </div>

    <div class="col-md-9">
      <h3>Car listing</h3>

      <div class="row mt-4" id="cars-container">

      </div>

      <div id="pagination-cars">

      </div>
    </div>
  </div>
</div>