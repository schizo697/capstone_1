<script>// Initialization for ES Users
import { Ripple, initMDB } from "mdb-ui-kit";

initMDB({ Ripple });</script>

<style>
.card {
  width: 18rem;
}

.card .bg-image {
  position: relative;
  overflow: hidden;
}

.card .bg-image img {
  width: 100%;
  height: 200px; /* Adjust the height as needed */
  object-fit: cover;
}

.card .card-body {
  padding: 1.25rem;
}

.card .card-title {
  font-size: 1.25rem;
  font-weight: bold;
}

.card .card-text {
  margin-bottom: 1rem;
}

.card .btn-primary {
  width: 100%;
}
</style>

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