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

    public function appInvite(string $emailAddress, string $firstName)
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
            $mail->setFrom('pwsteven13@gmail.com', 'Paul Steven');
            $mail->addAddress('psteven13@outlook.com', $firstName);     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo('pwsteven13@gmail.com', 'Paul Steven');
            //$mail->addCC('cc@example.com');
            $mail->addBCC('aman.johal@me.com');
            $mail->addBCC('matthew.p@yourlawyers.co.uk');
            $mail->addBCC('matthew@yourlawyers.co.uk');
            $mail->addBCC('jonathan@yourlawyers.co.uk');

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Invitation To Join BA OnBoarding App';
            $mail->Body    = $this->render('email/app_invite.html.twig', [
                'first_name' => $firstName,

            ]);

            $alt_message = 'Hi '.$firstName.', \n\n';
            $alt_message .= 'As part of your claim against British Airways, Your Lawyers Ltd would like to invite you to participate in joining our BA OnBoarding app. \n\n';
            $alt_message .= 'This is a secure site where we gather evidence from yourself to help with your claim. \n\n';
            $alt_message .= 'The whole process should take no longer than 10 minutes and it\'s crucial that we gather as much information as possible in order to pursue your claim for compensation. \n\n';
            $alt_message .= 'Please click on the below link to gain access to the BA OnBoarding app... \n\n';
            $alt_message .= 'Access Your Account:  https://ba.yourlawyers.co.uk \n\n';
            $alt_message .= 'Thanks, \n';
            $alt_message .= 'Your Lawyers Ltd \n\n';
            $alt_message .= 'This email was submitted from ba.yourlawyers.co.uk';
            $mail->AltBody = $alt_message;

            $mail->send();

        } catch (Exception $exception){
            $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
