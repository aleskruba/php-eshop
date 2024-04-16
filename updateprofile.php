<?php
session_start();

// Array of countries (you can fetch this from a database or an API)
$countries = array(
    "United States", 
    "United Kingdom", 
    "Canada", 
    "Australia", 
    "Germany", 
    "Czech Republic", 
);

if (!isset($_SESSION["user_id"])) {
    // Store the current URL in a session variable
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit;
} else {
    $current_user_id = $_SESSION["user_id"];
    $current_user_email = $_SESSION["user_email"];
}

include 'head.php'; 
include 'navbar.php';
require_once 'includes/db.inc.php';
require_once 'includes/cloudinary.inc.php';


if (isset($_SESSION["user_id"])) {
    $current_user_id = $_SESSION["user_id"];

    // Query to fetch user details based on ID
    $sql = "SELECT * FROM users WHERE id = :current_user_id";

    try {
        // Prepare and execute the query
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':current_user_id', $current_user_id);
        $stmt->execute();

        // Fetch the user details
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Display user details
        if ($user) {
            echo "<form class='update-form' action='includes/update/update.inc.php' method='post'>";
            echo "<div class='user-main'>";
            echo "<div class='user-detail'>";
            echo "<div class='image-div' id='imageDiv'>";
            if ($user['image']) {
                echo "<img src='" . $user['image'] . "' alt='User Image' class='user-image'>";
            } else {
                echo "<img src='profile.png' alt='User Image' class='user-image'>";
            }
            echo "</div>";
            echo "<div class='user-details-true'>";    
            echo "<p>First Name: " . $user['f_name'] . "</p>";
            echo "<p>Last Name: " . $user['l_name'] . "</p>";
            echo "<p>Country: " . $user['country'] . "</p>";
            echo "<p>Email: " . $user['email'] . "</p>";
            echo "</div>";
            echo "<div class='user-details-false'>";   

            echo "<div>";
            echo "<input class='user-input' name='f_name' value='".$user['f_name']."' placeholder='First Name'/>";
            echo "</div>";
            echo "<div>";
            echo "<input class='user-input' name='l_name' value='".$user['l_name']."' placeholder='Last Name'/>";
            
            echo "</div>";
            echo "<div>";
            echo "<select class='user-input' id='user-input' name='country'>";
            foreach ($countries as $country) {
                $selected = ($user['country'] == $country) ? "selected" : ""; // Check if current country matches user's country
                echo "<option value='$country' $selected>$country</option>";
            }
            echo "</select>";
            
            echo "</div>";
            echo "<div>";
            echo "<input class='user-input' type=email name='email' value=".$user['email']." placeholder='email'/>" ;
            echo "</div>";
            
            echo "</div>";
            echo "<div class='infotext'>  </div>";
            
            echo "</div>";

            echo "<div class='update-button-active'>";
            echo "<div class='user-update-button'> Update </div>";
            echo "<div class='user-back-button' id='backbutton'> Back </div>";
            echo "</div>";

            echo "<div class='update-button-hidden'>";
            echo "<button  id='user-update-button' type='submit'> Save </button>";
            echo "<div class='user-back-button' id='cancelbutton'> Cancel </div>";
            echo "</div>";
            
            echo "</div>";
            echo "</form>"; 
        } else {
            echo "User not found.";
        }
    } catch (PDOException $e) {
        die("Error: Could not execute query. " . $e->getMessage());
    }
} else {
    echo "Invalid user ID.";
}
?>


<script>

    

const updateButton = document.querySelector('.user-update-button');
const userDetailTrue = document.querySelector('.user-details-true');
const userDetailFalse = document.querySelector('.user-details-false');
const updateButtonActive =document.querySelector('.update-button-active');
const updateButtonHidden =document.querySelector('.update-button-hidden');
const cancelbutton = document.getElementById('cancelbutton');
const backbutton = document.getElementById('backbutton');
const infotext = document.querySelector('.infotext');



updateButton.addEventListener('click', () => {
    userDetailTrue.style.display = 'none';
    userDetailFalse.style.display = 'block';
    updateButtonActive.style.display = 'none';
    updateButtonHidden.style.display = 'flex';
    infotext.textContent = 'If you change your email you will be logged out.';
});

cancelbutton.addEventListener('click', () => {
    userDetailTrue.style.display = 'block';
    userDetailFalse.style.display = 'none';
    updateButtonActive.style.display = 'flex';
    updateButtonHidden.style.display = 'none';
});

backbutton.addEventListener('click', () => {
    window.location.href = './profile.php'; // Replace './profile.php' with the actual URL of your profile page
});

</script>

<?php
/* if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'db.inc.php';

    try {
        $json_data = file_get_contents("php://input");
        echo "Received JSON data: " . $json_data; // Debugging statement

        // Check if $json_data is already an array
        if (!is_array($json_data)) {
            // Decode the JSON string into an array
            $data = json_decode($json_data, true);

            // Check if decoding was successful
            if ($data === null) {
                echo "Failed to decode JSON data.";
                exit;
            }
        } else {
            // $json_data is already an array
            $data = $json_data;
        }

        // Process your data here...
        echo "Processed data: ";
        print_r($data); // Debugging statement

        // Example response data
        $response_data = array(
            'status' => 'success',
            'message' => 'Data received successfully'
        );

        // Encode the response data as JSON and send it back
        echo json_encode($response_data);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle other HTTP request methods if needed
}
?>


<script>
document.getElementById('imageDiv').addEventListener('click', function() {
    var input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/jpeg, image/jpg, image/png';
    input.onchange = function(event) {
        var file = event.target.files[0];
        if (!file) return; // No file selected
        var extension = file.name.split('.').pop().toLowerCase();
        if (['jpg', 'jpeg', 'png'].indexOf(extension) === -1) {
            alert('Please select a JPG, JPEG, or PNG file.');
            return;
        }
        
        var reader = new FileReader();
        reader.onload = function() {
            document.querySelector('.user-image').src = reader.result;
        }
        reader.readAsDataURL(file);
        
        // Create FormData object to send the file
        var formData = new FormData();
        formData.append('file', file);
        formData.append('upload_preset', 'schoolapp'); // Replace 'your_upload_preset' with your Cloudinary upload preset

        // Perform fetch request to Cloudinary upload API
        fetch('https://api.cloudinary.com/v1_1/<?php echo CLOUDINARY_CLOUD_NAME ?>/image/upload', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Uploaded image URL:', data.secure_url); // Log the URL of the uploaded image
            
    
            fetch('./includes/update/saveimage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ data: data.secure_url })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Parse JSON response
            })
            .then(data => {
                // Handle the response data here
                console.log(data); // Log the response data to console
            })
            .catch(error => {
                console.error('Error:', error);
            });


        })
        .catch(error => console.error('Error:', error));
    };
    input.click();
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function() {




    

})






   
    </script>  

