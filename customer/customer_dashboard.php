<script>// Initialization for ES Users
import { Ripple, initMDB } from "mdb-ui-kit";

initMDB({ Ripple });</script>

<div class="card">
  <div class="bg-image hover-overlay" data-mdb-ripple-init data-mdb-ripple-color="light">
    <img src="assets/dist/img/photo1.png" class="img-fluid"/>
    <a href="#!">
      <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
    </a>
  </div>
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#!" class="btn btn-primary" data-mdb-ripple-init>Button</a>
  </div>
</div>