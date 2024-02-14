<!-- Start of registration modal -->
<div class="modal fade" id="registration-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content registration">
      <div class="modal-header">
        <h5 class="modal-title">Registration Form</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="form-registration" class="form">
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" placeholder="" id="first_name" name="first_name" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" placeholder="" id="last_name" name="last_name" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" placeholder="" id="email" name="email" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" placeholder="" id="password" name="password" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" placeholder="" id="confirm_password" name="confirm_password" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="city">City</label>
            <input type="text" placeholder="" id="city" name="city" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" placeholder="" id="address" name="address" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" placeholder="062/372-884" id="phone" name="phone" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="licence_number">Licence Number</label>
            <input type="text" placeholder="" id="licence_number" name="licence_number" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="years_of_experience">Years of Experience</label>
            <input type="number" placeholder="" id="years_of_experience" name="years_of_experience" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>

          <button class="btn btn-success" id="btn-register">Register</button>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close Modal</button>
      </div>
    </div>
  </div>
</div>
<!-- End of registration modal -->

<!-- Start of login modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login Form</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="login-form" class="form">
          <div class="control-group">
            <div class="form-group">
              <input type="email" name="login-email" id="login-email" class="form-control" placeholder="Email" />
            </div>
          </div>
          <div class="control-group">
            <div class="form-group">
              <input type="password" name="login-password" id="login-password" class="form-control" placeholder="Password" />
            </div>
          </div>
          <div class="control-group">
            <input value="Login" name="btn-login" id="btn-login" class="btn btn-success" />

            <div class="loader" id="loader"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer login-footer">
        <div class="modal-footer-login-errors">

        </div>
        <button type="button" class="btn btn-danger modal-cancel" data-dismiss="modal">Close Modal</button>
      </div>
    </div>
  </div>
</div>
<!-- End of login modal -->