<?php
require_once "../../../models/statsLog.php";
?>

<div class="container-fluid my-2" id="">
  <div class="row">
    <div class="col-md-8 mx-auto">
      <h2>Number of online users</h2>
      <p><?= $number_of_logged_users ?></p>

      <h2>Stats for last 24 hours</h2>
      <p>Total number of visits: <?= $total ?></p>

      <div class="card">
        <div class="card-header">Visits </div>
        <div class="card-body">
          <table class="table table-striped table-responsive-md">
            <thead>
              <tr>
                <th>Page</th>
                <th>Number</th>
              </tr>
            </thead>

            <tbody>
              <?php
              foreach ($array_final as $key => $value) : ?>
                <tr>
                  <td>
                    <?= $key . ":" ?>
                  </td>

                  <td>
                    <?= round($value * 100 / $total, 2) . " %: $value times" ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>