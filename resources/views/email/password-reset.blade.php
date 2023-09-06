<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dr. Meditation - Password Reset OTP</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Dr. Meditation Password Reset OTP</h2>
                    </div>
                    <div class="card-body">
                        <p>Hello, Mr. {{$name}}</p>
                        <p>You have requested to reset your password for your Dr. Meditation account. Please use the following OTP (One-Time Password) to complete the password reset process:</p>
                        <h3 class="text-center"><strong>Your OTP:</strong> {{$token}}</h3> <!-- Replace '123456' with the actual OTP -->
                        <p>If you did not request this password reset, please ignore this email. Your account security is important to us.</p>
                        <p>Thank you for using Dr. Meditation!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and jQuery links here (if needed) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>