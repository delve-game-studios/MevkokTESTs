<?php
/*
 *
 *
 * Copyright (c) 2010 158, Ltd.
 * All Rights Reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification are not permitted.
 *
 * Neither the name of 158, Ltd. or the names of contributors
 * may be used to endorse or promote products derived from this software
 * without specific prior written permission.
 *
 * This software is provided "AS IS," without a warranty of any kind. ALL
 * EXPRESS OR IMPLIED CONDITIONS, REPRESENTATIONS AND WARRANTIES, INCLUDING
 * ANY IMPLIED WARRANTY OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE OR NON-INFRINGEMENT, ARE HEREBY EXCLUDED. 158 AND ITS LICENSORS
 * SHALL NOT BE LIABLE FOR ANY DAMAGES SUFFERED BY LICENSEE AS A RESULT OF
 * USING, MODIFYING OR DISTRIBUTING THE SOFTWARE OR ITS DERIVATIVES. IN NO
 * EVENT WILL 158 OR ITS LICENSORS BE LIABLE FOR ANY LOST REVENUE, PROFIT
 * OR DATA, OR FOR DIRECT, INDIRECT, SPECIAL, CONSEQUENTIAL, INCIDENTAL OR
 * PUNITIVE DAMAGES, HOWEVER CAUSED AND REGARDLESS OF THE THEORY OF
 * LIABILITY, ARISING OUT OF THE USE OF OR INABILITY TO USE SOFTWARE, EVEN
 * IF 158 HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.
 *
 * Any violation of the copyright rules above will be punished by the lay.
 */

/**
 * Helper class for sending email using php mail function 
 */
class Email {
    /**
     * Contains an array with all headers needed 
     * @var array 
     */
    private $headers;
    
    /**
     * Create an instance of Email
     * @param string $from The address that you will be sending emails from
     */
    public function __construct($from) {
        $this->setHeader('From', $from);
        $this->setHeader('Reply-To', $from);
        $this->setHeader('MIME-Version', '1.0');
        $this->setHeader('Content-Type', 'text/html; charset=UTF-8');
        $this->setHeader('Content-Transfer-Encoding', '8bit');
    }
    
    /**
     * Set an email header
     * @param string $header Email header name
     * @param string $value The value of the email header
     */
    public function setHeader($header, $value) {
        $this->headers[$header] = $value;
    }
    
    /**
     * Send an email
     * @param string $to the recipient email address
     * @param string $subject email subject
     * @param string $message email body/message
     * @return string 
     */
    public function send($to, $subject, $message) {
        return mail($to, $subject, $message, $this->buildHeaders());
    }
    
    /**
     * Builds the header array into a string 
     */
    private function buildHeaders() {
        $headers = '';
        foreach($this->headers as $header => $value) {
            $headers .= "$header: $value\r\n";
        }
        
        return $headers;
    }
}

?>
