<div class="containter-fluid">
  <div class="row">
    <div class="col-12 col-md-7 align-self-center">
      <a href="index.php">
        <img src="public/assets/img/logo.png" alt="logo" class="ml-5 logo" />
      </a>
    </div>

    <div class="col-12 col-md-5">
      <nav class="navbar-nav">
        <?php foreach ($data['menu_all'] as $menu_item) : ?>
          <li class="nav-item"><a href="index.php?page=<?= $menu_item->href ?>" class="nav-link"><?= $menu_item->text ?></a></li>
        <?php endforeach; ?>

        <?php if (isset($_SESSION['user']) && $_SESSION['user']->role_id == '2') : ?>
          <?php foreach ($data['menu_authorized'] as $menu_item) : ?>
            <li class="nav-item">
              <a href="index.php?page=<?= $menu_item->href ?>" class="nav-link">
                <?= $menu_item->text ?>
                <?= $_SESSION['user']->first_name; ?>
                <i class="fas fa-user"></i>
              </a>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['user']) && $_SESSION['user']->role_id == '1') : ?>
          <?php foreach ($data['menu_admin'] as $menu_item) : ?>
            <li class="nav-item"><a href="index.php?page=<?= $menu_item->href ?>" class="nav-link"><?= $menu_item->text ?></a></li>
          <?php endforeach; ?>
        <?php endif; ?>
      </nav>
    </div>
  </div>
</div>

<div class="container-fluid bg-dark p-4">
  <div class="navbar">
    <div class="col-12 col-sm-12 col-md-9">
      <form class="form-inline my-2 my-lg-0">
        <input type="search" id="search-navigation" name="search-navigation" class="form-control mr-sm-2" placeholder="Search Model" aria-label="Search" />
        <button type="button" id="search-button-navigation" class="btn btn-outline-success my-2 my-sm-0" value="SubmitNav">Search</button>
      </form>
    </div>

    <div class="col-12 col-md-3 text-center login-cred">
      <p>
        <?php if (!isset($_SESSION['user'])) : ?>
          <a href="#" data-target="#login-modal" data-toggle="modal" class="px-1 pr">Sign In</a>
          <a href="#" data-target="#registration-modal" data-toggle="modal" class="px-4">Create Account</a>
        <?php else : ?>
          <a href="index.php?page=logout">Logout</a>
        <?php endif; ?>
      </p>
    </div>
  </div>
</div>
