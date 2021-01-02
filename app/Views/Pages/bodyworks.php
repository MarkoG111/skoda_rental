<?php
//var_dump($data["bodyworks"]);
$bodywork = $data["bodyworks"];
?>
<div class="heading text-center my-4">
  <h1 class="font-weight-bold">Bodyworks for : <span class="prim-color"><?= $bodywork[0]->modelName ?></span></h1>
</div>

<div class="container-fluid">
  <div class="row my-add">
    <?php foreach ($bodywork as $bw) : ?>
      <div class="col text-center">
        <a href="#">
          <img src="<?= $bw->bodyworkPath ?>" alt="<?= $bw->alt ?>" />
        </a>
        <h3 class="font-weight-bold text-uppercase"><?= $bw->bodyworkName ?></h3>
        <p>Total Price: <span class="prim-color tot-price">14000 &euro;</span></p>
        <div class="buttons">
          <a href="#" class="black-link">View Details</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>