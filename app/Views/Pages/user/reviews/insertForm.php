<?php
session_start();
?>
<div class="container-fluid form">

  <div class="row">
    <div class="col-md-8 mx-auto">
      <h2>Post a review</h2>
      <div class="row">
        <div class="col-md-12">
          <input type="hidden" id="user-review-id" value="<?= $_SESSION["user"]->user_id; ?>" />
          
          <form action="" class="form-horizontal" method="POST" id="review-form">

          </form>
        </div>
      </div>
    </div>
  </div>
</div>