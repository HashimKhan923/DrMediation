<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advisor Details and Documents</title>
    <!-- Add Bootstrap CSS link here -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add your custom CSS styles here -->
    <style>
        /* Add your custom styles here */
        .user-details {
            margin-top: 20px;
        }
        .document-list {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- User Details Section -->
        <div class="user-details">
            <h2>Advisor Details</h2>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong>{{$user->name}}</p>
                    <p><strong>Email:</strong>{{$user->email}}</p>
                    <p><strong>Phone:</strong>{{$user->phone_number}}</p>
                </div>
                <div class="col-md-6">
                    <!-- Add more user details here -->
                </div>
            </div>
        </div>
        <h2>Documents</h2>
        <!-- Document List Section -->

        

        <div class="document-list">
            <h4>Documents</h4>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="#">Document 1</a>
                </li>
                <li class="list-group-item">
                    <a href="#">Document 2</a>
                </li>
                <li class="list-group-item">
                    <a href="#">Document 3</a>
                </li>
                <!-- Add more document items here -->
            </ul>
        </div>



    </div>

    <!-- Add Bootstrap JS scripts and jQuery link here (for Bootstrap functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>