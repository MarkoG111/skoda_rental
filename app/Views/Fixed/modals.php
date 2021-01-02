<!-- Start of registration modal -->
<div class="modal fade" id="registrationModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content registration">
      <div class="modal-header">
        <h5 class="modal-title">Registration Form</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="index.php?page=do-register" method="POST" id="formRegister" class="form">
          <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" placeholder="Marko" id="firstName" name="tbFirstName" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" placeholder="Luis" id="lastName" name="tbLastName" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" placeholder="example@gmail.com" id="email" name="tbEmail" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" placeholder="gachan07" id="password" name="tbPassword" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" placeholder="Repeat password" id="confirmPassword" name="tbConfirmPassword" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="city">City</label>
            <input type="text" placeholder="Gornji Milanovac" id="city" name="tbCity" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" placeholder="Prince Milos 88/22" id="address" name="tbAddress" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" placeholder="062/372-884" id="phone" name="tbPhone" />
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
          </div>
          <button class="btn btn-success" id="btnRegister" name="btnRegister">Register</button>
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
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login Form</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="index.php?page=doLogin" method="POST">
          <div class="control-group">
            <div class="form-group">
              <input type="email" name="tbEmail" id="loginEmail" class="form-control" placeholder="Email" />
            </div>
          </div>
          <div class="control-group">
            <div class="form-group">
              <input type="password" name="tbPassword" id="loginPassword" class="form-control" placeholder="Password" />
            </div>
          </div>
          <div class="control-group">
            <input type="submit" value="Login" name="btnLogin" id="btnLogin" class="btn btn-success" />
          </div>
        </form>
      </div>
      <div class="modal-footer login-footer">
        <div class="modal-footer-errors">
          <?php
          if (isset($_SESSION["login-errors"])) {
            if (count($_SESSION["login-errors"])) {
              foreach ($_SESSION["login-errors"] as $err) {
                echo $err . "<br/>";
              }
            }
            unset($_SESSION["login-errors"]);
          }
          ?>
        </div>
        <button type="button" class="btn btn-danger modal-cancel" data-dismiss="modal">Close Modal</button>
      </div>
    </div>
  </div>
</div>
<!-- End of login modal -->