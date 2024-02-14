<div class="site-section" id="contact-section">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-7 text-center mb-5">
        <h2>Contact Us </h2>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8 mb-5">
        <form action="vendor/phpmailer/phpmailer/index.php" method="POST" onSubmit="return checkContactForm()">
          <div class="form-group row">
            <div class="col-md-6 mb-4 mb-lg-0">
              <?php
              printFormInput("first_name_contact", "First Name", "text");
              ?>
            </div>
            <div class="col-md-6">
              <?php
              printFormInput("last_name_contact", "Last Name", "text");
              ?>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12">
              <?php
              printFormInput("email_contact", "Email", "text");
              ?>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12">
              <div class='form-group'>
                <label for='message'>Message</label>
                <textarea name="message" id="message" class="form-control" cols="30" rows="10"></textarea>
                <small id='messageErr' class='form-text text-danger error-field'>Valid format: </small>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-6 mr-auto">
              <input type="submit" class="btn btn-block btn-green text-white py-3 px-5" id="btnContact" name="btnContact" value="Send Message">
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-4 ml-auto">
        <div class="bg-white p-3 p-md-5">
          <h3 class="text-black mb-4">Contact Info</h3>
          <ul class="list-unstyled footer-link">
            <li class="d-block mb-3">
              <span class="d-block text-black">Address:</span>
              <span>777 Brockton Avenue, MA 235</span>
            </li>
            <li class="d-block mb-3"><span class="d-block text-black">Phone:</span><span>+1 242 4942 290</span></li>
            <li class="d-block mb-3"><span class="d-block text-black">Email:</span><span>admin@skoda-rent.com</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>