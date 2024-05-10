<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Property Listing</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f8f8f8;
    }

    h1 {
      text-align: center;
      padding: 20px 0;
      background-color: #333;
      color: #fff;
      margin: 0;
    }

    .header {
      background-color: #333;
      color: #fff;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header h1 {
      flex-grow: 1; /* Allow the text to take up remaining space */
      text-align: center; /* Center the text within the header */
    }

    .profile {
      display: flex;
      align-items: center;
    }

    .profile img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
    }

    .profile h3 {
      margin: 0;
    }

    .properties {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      margin: 0 auto;
      width: 80%;
    }

    .property {
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-bottom: 20px;
      width: 30%;
      transition: transform 0.3s ease-in-out;
    }

    .property:hover {
      transform: scale(1.05);
    }

    .property img {
      width: 100%;
      height: 300px; /* Set a fixed height for all images */
      object-fit: cover; /* Ensure the images maintain their aspect ratio */
      border-radius: 5px;
      margin-bottom: 10px;
    }

    h2, p {
      margin: 0;
    }

    h2 {
      margin-bottom: 10px;
      font-size: 18px;
      color: #333;
    }

    p:nth-child(odd) {
      font-weight: bold;
    }

    button {
      display: block;
      margin-top: 10px;
      padding: 10px 20px;
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease-in-out;
    }

    button:hover {
      background-color: #555;
    }
  </style>
</head>
<body>
  <div class="header">
    <div class="profile">
      <img src="assets/dist/img/avatar.png" alt="Profile Image">
      <h3>Welcome, John Doe</h3>
    </div>
    <h1>MARKET</h1>
  </div>
  <br><br>
  <div class="properties">
    <div class="property">
      <img src="assets/dist/img/tomato.jpg" alt="Property Image 1">
      <h2>FRESH TOMATO</h2>
      <p>Price : ₱400.00</p>
      <p>Address: Gensan</p>
      <p>Owner: Elmer Watapampam</p>
      <button>Check out</button>
    </div>
    <div class="property">
      <img src="assets/dist/img/eggplant.png" alt="Property Image 1">
      <h2>EGGPLANT</h2>
      <p>Price : ₱400.00</p>
      <p>Address: Gensan</p>
      <p>Owner: Elmer Watapampam</p>
      <button>Check out</button>
    </div>
    <div class="property">
      <img src="assets/dist/img/kalabasa.jpg" alt="Property Image 1">
      <h2>SQUASH</h2>
      <p>Price : ₱400.00</p>
      <p>Address: Gensan</p>
      <p>Owner: Elmer Watapampam</p>
      <button>Check out</button>
    </div>  
    <div class="property">
      <img src="assets/dist/img/tomato.jpg" alt="Property Image 1">
      <h2>FRESH TOMATO</h2>
      <p>Price : ₱400.00</p>
      <p>Address: Gensan</p>
      <p>Owner: Elmer Watapampam</p>
      <button>Check out</button>
    </div>
    <div class="property">
      <img src="assets/dist/img/eggplant.png" alt="Property Image 1">
      <h2>EGGPLANT</h2>
      <p>Price : ₱400.00</p>
      <p>Address: Gensan</p>
      <p>Owner: Elmer Watapampam</p>
      <button>Check out</button>
    </div>
    <div class="property">
      <img src="assets/dist/img/kalabasa.jpg" alt="Property Image 1">
      <h2>SQUASH</h2>
      <p>Price : ₱400.00</p>
      <p>Address: Gensan</p>
      <p>Owner: Elmer Watapampam</p>
      <button>Check out</button>
    </div> 
  </div>
</body>
</html>