<?php


namespace App\Service;


use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SendMail extends AbstractController
{
    /**
     * @var string
     * @var string
     * @var string
     */
    private $emailHost;
    private $emailUsername;
    private $emailPassword;

    public function __construct(string $emailHost, string $emailUsername, string $emailPassword)
    {
        $this->emailHost = $emailHost;
        $this->emailUsername = $emailUsername;
        $this->emailPassword = $emailPassword;
    }

    public function appInvite(string $emailAddress, string $firstName, string $token)
    {



        $mail = new PHPMailer(true);
        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = $this->emailHost;                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $this->emailUsername;                     // SMTP username
            $mail->Password   = $this->emailPassword;                            // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587; // TCP port to connect to

            //Recipients
            $mail->setFrom('pwsteven13@gmail.com', 'BA Group Action');
            //$mail->addAddress('psteven13@outlook.com', $firstName);     // Testing Purposes only
            $mail->addAddress($emailAddress, $firstName);     // Add a recipient
            $mail->addReplyTo('pwsteven13@gmail.com', 'Paul Steven');
            $mail->addBCC('aman.johal@me.com');
            $mail->addBCC('matthew.p@yourlawyers.co.uk');
            $mail->addBCC('matthew@yourlawyers.co.uk');
            $mail->addBCC('jonathan@yourlawyers.co.uk');

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Invitation To Join BA Data Breach App';
            $mail->Body    = $this->render('email/app_invite_new.html.twig', [
                'first_name' => $firstName,
                'token' => $token,
            ]);

            $alt_message = 'Hi '.$firstName.', \n\n';
            $alt_message .= 'As part of your claim against British Airways, Your Lawyers Ltd would like to invite you to participate in joining the BA Data Breach app. \n\n';
            $alt_message .= 'This is a secure area where we gather evidence from yourself to help with your claim. The whole process should take no longer than 10 minutes. \n\n';
            $alt_message .= 'Please click on the link below to gain access to your own personal account that\'s been created for you on our BA Data Breach app... \n\n';
            $alt_message .= 'Access Your Account:  https://127.0.0.1:8000/api/account?token='.$token.' \n\n';
            $alt_message .= 'Thanks, \n';
            $alt_message .= 'Your Lawyers Ltd \n\n';
            $alt_message .= 'This email was submitted from https://ba.yourlawyers.co.uk';
            $mail->AltBody = $alt_message;

            $mail->send();

        } catch (Exception $exception){
            $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
