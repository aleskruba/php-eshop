<style>
    .page404-main{
    display: flex;
    justify-content: center;
    align-items: center;

}
.page404 {
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Styles for 404 header */
.page404-h1 {

    font-size: 36px;
    margin-bottom: 20px;
    color: red7; /* Tomato color */
}

/* Styles for 404 paragraph */
.page404-p {
    font-size: 18px;
    margin-bottom: 30px;
}

/* Styles for 404 link */
.page404-a {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.page404-a:hover {
    background-color: #0056b3;
}

</style>
<?php
http_response_code(404);
echo '<div class="page404-main">';
echo '<div class="page404">';   
echo "<h1 class='page404-h1'>404 - Page Not Found </h1>";
echo "<h1 class='page404-h1'>I am so sorry :-) </h1>";
echo "<p class='page404-p'>The requested page could not be found.</p>";
echo "<a p class='page404-a' href='./index.php'>Go to Homepage</a>";
echo "</div>";   
echo "</div>"; 
?>
