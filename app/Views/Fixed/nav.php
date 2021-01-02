<div class="containter-fluid">
  <div class="row">
    <div class="col-12 col-sm-12 col-md-9 align-self-center">
      <a href="index.php">
        <img src="public/assets/img/logo.png" alt="logo" class="ml-5 logo" />
      </a>
    </div>

    <div class="col-12 col-md-3">
      <nav class="navbar-nav">
        <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="index.php?page=models" class="nav-link">Models</a></li>
        <li><a href="#" class="nav-link"><i class="fas fa-user"></i>&nbsp;<?php if (isset($_SESSION['person'])) echo $_SESSION['person']->firstName; ?></a></li>
      </nav>
    </div>
  </div>
</div>

<div class="container-fluid bg-dark p-4">
  <div class="navbar">
    <div class="col-12 col-sm-12 col-md-9">
      <form class="form-inline my-2 my-lg-0">
        <input type="search" class="form-control mr-sm-2" placeholder="Search Model" aria-label="Search">
        <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Search</button>
      </form>
    </div>

    <div class="col-12 col-md-3 text-center login-cred">
      <p>
        <?php if (!isset($_SESSION['person'])) : ?>
          <a href="#" data-target="#loginModal" data-toggle="modal" class="px-1 pr">Sign In</a>
          <a href="#" data-target="#registrationModal" data-toggle="modal" class="px-4">Create Account</a>
        <?php else : ?>
          <a href="index.php?page=logout">Logout</a>
        <?php endif; ?>
      </p>
    </div>
  </div>
</div>