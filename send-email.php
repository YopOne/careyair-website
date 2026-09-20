<?php
// 1. Load PHPMailer classes (Adjust these file paths if your host uses a custom vendor folder)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Attempt to load natively via standard host paths, otherwise download PHPMailer files to your directory
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
} else {
    // If your host doesn't use composer, manually require the core files 
    // (You can download these 3 files from GitHub and put them in a folder named 'PHPMailer')
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2. Gather form inputs
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $project = strip_tags(trim($_POST["project-type"]));
    $message = trim($_POST["message"]);

    $mail = new PHPMailer(true);

    try {
        // 3. Google Workspace SMTP Server Configurations
        $mail->isSMTP();
        $mail->Host       = '://gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jim@careyair.com';            // Your full Google Workspace Email Address
        $mail->Password   = 'wniwonczrywiqxca';          // Paste your 16-character Google App Password here
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Secure TLS encryption
        $mail->Port       = 587;                            // TLS Port

        // 4. Recipients
        $mail->setFrom('jim@careyair.com', 'CareyAir Website'); 
        $mail->addAddress('jim@careyair.com');             // Where you want the notification sent
        $mail->addReplyTo($email, $name);                   // Let's you hit 'Reply' in Gmail directly to the lead

        // 5. Content Configuration
        $mail->isHTML(false);                               // Plain text is best for simple contact notifications
        $mail->Subject = "New CareyAir Builder Consultation from $name";
        
        $mail_body = "Name: $name\n";
        $mail_body .= "Email: $email\n";
        $mail_body .= "Project Focus: $project\n\n";
        $mail_body .= "Message:\n$message\n";
        
        $mail->Body = $mail_body;

        // 6. Execute Send
        $mail->send();
        http_response_code(200);
        echo "Thank you! Your message has been safely sent to CareyAir.";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission.";
}
?>
