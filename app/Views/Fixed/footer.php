<footer class="container-fluid bg-black">
  <div class="container align-self-center">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-4 align-self-center">
        <ul class="social-links">
          <li>
            <a href="https://www.linkedin.com/in/marko-gacanovic-4a133016a/" target="blank" class="icon-link">
              <i class="fab fa-linkedin fa-3x"></i>
            </a>
          </li>
          <li>
            <a href="https://www.facebook.com" target="blank" class="icon-link">
              <i class="fab fa-facebook fa-3x"></i>
            </a>
          </li>
          <li>
            <a href="https://www.github.com" target="blank" class="icon-link">
              <i class="fab fa-github fa-3x"></i>
            </a>
          </li>
        </ul>
      </div>

      <div class="col-12 col-md-4">
        <p class="text-white mt-4">Website made by <a href="#" class="author-link">Marko Gačanović</a></p>
      </div>

      <div class="col-12 col-md-4 text-right ">
        <ul class="navbar-nav footer-nav">
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
        </ul>
      </div>
    </div>
  </div>
</footer>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="public/assets/js/jquery-ui.js"></script>

<script src="public/assets/js/main.js"></script>
<script src="public/assets/js/register.js"></script>
<script src="public/assets/js/login.js"></script>
<script src="public/assets/js/adminPanel.js"></script>
<script src="public/assets/js/upsertCar.js"></script>
</body>

</html>