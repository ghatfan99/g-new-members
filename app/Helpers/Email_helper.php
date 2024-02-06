<?php
if (!function_exists('send_email')) {
    function send_email($to, $subject, $message, $attachmentPath = null)
    {
        $email = \Config\Services::email();

        // Set recipient info
        $email->setTo($to);

        // Set email subject and message
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->setMailType('html');

        // Attach the file if provided
        if ($attachmentPath !== null && is_file($attachmentPath)) {
            $email->attach($attachmentPath);
        }

        try {
            if ($email->send()) {
                // Clear the attachments for the next mail
                $email->clear(true);
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}