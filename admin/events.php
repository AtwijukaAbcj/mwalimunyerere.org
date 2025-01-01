<?php
// Enable error reporting to catch any issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and header
include 'header.php'; 

// Check if the database connection is successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Collect form data
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $overview = mysqli_real_escape_string($con, $_POST['overview']);
    $event_date = mysqli_real_escape_string($con, $_POST['event_date']);
    $event_time = mysqli_real_escape_string($con, $_POST['event_time']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $ticket_price = mysqli_real_escape_string($con, $_POST['ticket_price']);
    $contact_number = mysqli_real_escape_string($con, $_POST['contact_number']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $additional_info = mysqli_real_escape_string($con, $_POST['additional_info']); // NEW FIELD
    $created_date = date('Y-m-d H:i:s'); // Automatically set created date

    // Absolute path to the uploads directory (server path)
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/admin/uploads/";

    // Check if the uploads folder exists, create if not
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
        echo "Created uploads folder.<br>";
    }

    // Construct the target file path (server path)
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    
    // Construct the public URL to the image (what we save in the database)
    $public_url = "https://su.ac.ug/admin/uploads/" . basename($_FILES["image"]["name"]);

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate image file type
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        exit;
    }

    // Check for file upload errors
    if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
        echo "File upload error: " . $_FILES["image"]["error"] . "<br>";
        exit;
    }

    // Ensure the file was uploaded via HTTP POST
    if (!is_uploaded_file($_FILES['image']['tmp_name'])) {
        echo "File was not uploaded via HTTP POST.<br>";
        exit;
    }

    // Validate and move file to the target directory (server path)
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "File uploaded successfully to: " . $target_file . "<br>";

        // Insert data into the database (store public URL)
        $sql = "INSERT INTO events (title, description, overview, event_date, event_time, location, ticket_price, contact_number, category, image, additional_info, created_date) 
                VALUES ('$title', '$description', '$overview', '$event_date', '$event_time', '$location', '$ticket_price', '$contact_number', '$category', '$public_url', '$additional_info', '$created_date')";

        // Execute query and check for errors
        if (mysqli_query($con, $sql)) {
            echo "Event created successfully!";
        } else {
            echo "Database Error: " . $sql . "<br>" . mysqli_error($con);
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Add Event</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title" class="form-label">Event Title:</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Event Description:</label>
                                <textarea name="description" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="overview" class="form-label">Event Overview:</label>
                                <textarea name="overview" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="event_date" class="form-label">Event Date:</label>
                                <input type="date" name="event_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="event_time" class="form-label">Event Time:</label>
                                <input type="time" name="event_time" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location:</label>
                                <input type="text" name="location" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="ticket_price" class="form-label">Ticket Price:</label>
                                <input type="number" name="ticket_price" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact_number" class="form-label">Contact Number:</label>
                                <input type="tel" name="contact_number" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category:</label>
                                <input type="text" name="category" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="additional_info" class="form-label">Additional Information:</label>
                                <textarea name="additional_info" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Event Image:</label>
                                <input type="file" name="image" class="form-control" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Add Event</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Include footer -->
    <?php include 'footer.php'; ?>
