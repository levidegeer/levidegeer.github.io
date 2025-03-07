<?php
// contact_handler.php - Place this file in the same directory as your HTML file

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize inputs
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));
    
    // Basic validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    // If no errors, proceed with sending the email
    if (empty($errors)) {
        // Set up email parameters
        $to = "levidegeer@gmail.com"; // Replace with your actual email
        $subject = "Portfolio Contact Form: Message from $name";
        
        // Create email content with proper headers
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$message\n";
        
        // Additional headers
        $headers = "From: $name <$email>\r\n";
        $headers .= "Reply-To: $email\r\n";
        
        // Send email
        $mail_sent = mail($to, $subject, $email_content, $headers);
        
        if ($mail_sent) {
            // Redirect to thank you page or show success message
            header("Location: thank_you.html");
            exit;
        } else {
            $errors[] = "Failed to send email. Please try again later.";
        }
    }
}
?>