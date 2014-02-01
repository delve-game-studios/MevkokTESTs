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

class Http {
    
    /**
     * @var resource a CURL resource
     */
    private $ch;
    
    /**
     * Creates a Http instance
     */
    public function __construct() {
        $this->ch = curl_init();
        // init default curl options
        curl_setopt($this->ch, CURLOPT_HEADER, true);
        curl_setopt($this->ch, CURLOPT_NOBODY, true);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }
    
    /**
     * Sets an http option
     * @param int $option the option key
     * @param bool $value the option value
     */
    public function setOption($option, $value){
        curl_setopt($this->ch, $option, $value);
    }
    
    /**
     * Retrievs the information about the web page
     * @param int $infoOption option key
     * @return mixed the retrieved information 
     */
    public function info($infoOption = 0) {
        return curl_getinfo($this->ch, $infoOption);
    }
    
    /**
     * Perform an http get reques
     * @param string $url url to page
     * @return string the response from the remote web page
     */
    public function get($url) {
        $this->setOption(CURLOPT_URL, $url);
        return $this->exec();
    }
    
    /**
     * Perform an http post reques
     * @param string $url url to page
     * @param array $params http post parameters
     * @return string the response from the remote web page
     */
    public function post($url, array $params) {
        $this->setOption(CURLOPT_URL, $url);
        $this->setOption(CURLOPT_POST, count($params));
        $this->setOption(CURLOPT_POSTFIELDS, $this->buildPostString($params));
        
        return $this->exec();
    }
    
    /**
     * 
     * @param type $urlurl to page
     * @param string $data data to send via http post
     * @return @return string the response from the remote web page
     */
    public function postData($url, $data) {
        $this->setOption(CURLOPT_URL, $url);
        $this->setOption(CURLOPT_POST, strlen($data));
        $this->setOption(CURLOPT_POSTFIELDS, $data);
        
        return $this->exec();
    }
    
    /**
     * Exec the http request
     * @return string the response from the remote web page
     */
    private function exec() {
        return curl_exec($this->ch);
    }
    
    /**
     * Builds a post string from an array
     * @param array $params the parameters array
     * @return string the concatinated post string
     */
    private function buildPostString(array $params) {
        $postData = '';
        foreach($params as $key => $param) {
            $postData .= $key . '=' . $param . '&';
        }
        
        return rtrim($postData, '&');
    }
}

?>
