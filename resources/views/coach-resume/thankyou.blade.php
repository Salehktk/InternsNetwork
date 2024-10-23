<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thank You</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #ece9e6, #ffffff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #333;
    }

    .thank-you-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      width: 100%;
      padding: 20px;
    }

    .thank-you-box {
      background: #ffffff;
      padding: 50px;
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
      max-width: 450px;
      width: 100%;
    }

    .checkmark-circle {
      font-size: 3rem;
      color: #27ae60;
      margin-bottom: 20px;
      display: inline-flex;
      justify-content: center;
      align-items: center;
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background-color: #ecf9f2;
    }

    .thank-you-title {
      font-size: 2.5rem;
      font-weight: 600;
      margin-bottom: 20px;
      color: #2c3e50;
    }

    .thank-you-message {
      font-size: 1.2rem;
      line-height: 1.6;
      color: #7f8c8d;
    }

    @media (max-width: 768px) {
      .thank-you-box {
        padding: 30px;
      }

      .thank-you-title {
        font-size: 2rem;
      }

      .thank-you-message {
        font-size: 1rem;
      }
    }
  </style>
</head>

<body>
  <div class="thank-you-container">
    <div class="thank-you-box">
      <div class="checkmark-circle">
        <i class="fas fa-check"></i>
      </div>
      <h1 class="thank-you-title">Thank You!</h1>
      <p class="thank-you-message">Thank you for your information. Please wait for us to do our thing to get you all set
        up. We’ll be in touch soon.</p>
    </div>
  </div>
</body>

</html>