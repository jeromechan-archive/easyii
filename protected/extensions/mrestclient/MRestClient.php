<?php
/**
 * Copyright © 2014 Jerome Chan. All rights reserved.
 * 
 * @author chenjinlong
 * @date 7/5/14
 * @time 11:14 PM
 * @description MRestClient.php
 */
class MRestClient extends CComponent
{
    private $_supportedFormats = array(
        'xml' 				=> 'application/xml',
        'json' 				=> 'application/json',
        'serialize' 		=> 'application/vnd.php.serialized',
        'php' 				=> 'text/plain',
        'csv'				=> 'text/csv',
        'base64'			=> 'text/html'
    );

    private $_autoDetectFormats = array(
        'application/xml' 	=> 'xml',
        'text/xml' 			=> 'xml',
        'application/json' 	=> 'json',
        'text/json' 		=> 'json',
        'text/html' 	    => 'base64',
        'text/csv' 			=> 'csv',
        'application/csv' 	=> 'csv',
        'application/vnd.php.serialized' => 'serialize'
    );

    private $_curl;

    private $_format;

    private $_mimeType;

    public function __construct()
    {
        $this->_curl = new CURL();
    }

    public function get($uri, $params = array(), $format = null)
    {
        if ($params)
        {
            $uri .= '?'.(is_array($params) ? $this->_formatParameter($params) : $params);
        }
        return $this->_call('get', $uri, $params, $format);
    }

    public function post($uri, $params = array(), $format = null)
    {
        return $this->_call('post', $uri, $params, $format);
    }

    public function put($uri, $params = array(), $format = null)
    {
        return $this->_call('put', $uri, $params, $format);
    }

    public function delete($uri, $params = array(), $format = null)
    {
        return $this->_call('delete', $uri, $params, $format);
    }

    private function _call($method, $uri, $params = array(), $format = NULL)
    {
        $params = $this->_formatParameter($params);
        $this->_curl->create($uri);
        $this->_curl->option('failonerror', FALSE);
        $this->_curl->{'set' . ucfirst($method)}($params);
        $response = $this->_curl->execute();
        if ($format !== NULL)
        {
            $this->_format($format);
            return $this->_formatResponse($response);
        } else {
            return $response;
        }
    }

    private function _formatParameter($params)
    {
        if(is_array($params))
            return http_build_query($params);
        else
            return $params;
    }

    private function _format($format)
    {
        if (array_key_exists($format, $this->_supportedFormats)) {
            $this->_format = $format;
            $this->_mimeType = $this->_supportedFormats[$format];
        } else {
            $this->_mimeType = $format;
        }
    }

    private function _formatResponse($response)
    {
        if (array_key_exists($this->_format, $this->_supportedFormats)) {
            return $this->{"_" . $this->_format}($response);
        }

        $returnedMime = @$this->_curl->getCurlResponseInfo('content_type');

        if (strpos($returnedMime, ';')) {
            list($returnedMime) = explode(';', $returnedMime);
        }

        $returnedMime = trim($returnedMime);
        if (array_key_exists($returnedMime, $this->_autoDetectFormats)) {
            return $this->{'_' . $this->_autoDetectFormats[$returnedMime]}($response);
        }

        return $response;
    }

    private function _xml($string)
    {
        return $string ? (array)simplexml_load_string($string, 'SimpleXMLElement', LIBXML_NOCDATA) : array();
    }

    private function _csv($string)
    {
        $data = array();

        $rows = explode("\n", trim($string));
        $headings = explode(',', array_shift($rows));
        foreach ($rows as $row) {
            $data_fields = explode('","', trim(substr($row, 1, -1)));

            if (count($data_fields) == count($headings)) {
                $data[] = array_combine($headings, $data_fields);
            }

        }
        return $data;
    }

    private function _json($string)
    {
        return json_decode(trim($string), true);
    }

    private function _serialize($string)
    {
        return unserialize(trim($string));
    }

    private function _php($string)
    {
        $string = trim($string);
        $populated = array();
        eval("\$populated = \"$string\";");
        return $populated;
    }

    private function _base64($string)
    {
        return json_decode(base64_decode(trim($string)), true);
    }
}

class CURL extends CComponent
{
    const CURL_TIMEOUT_SEC = 10;

    private $_url;

    private $_session;

    private $_options;

    private $_response;

    private $_info;

    private $_errorCode;

    private $_errorString;

    public function getCurlResponseInfo($key)
    {
        if(isset($this->_info[$key])){
            return $this->_info[$key];
        }else{
            return '';
        }
    }

    public function create($url)
    {
        $this->_url = $url;
        $this->_session = curl_init($this->_url);
    }

    public function option($code, $value)
    {
        if (is_string($code) && !is_numeric($code))
        {
            $code = constant('CURLOPT_' . strtoupper($code));
        }

        $this->_options[$code] = $value;
    }

    public function setGet($params)
    {
        // Do nothing currently
    }

    public function setPost($params)
    {
        if (is_array($params))
        {
            $params = http_build_query($params, NULL, '&');
        }

        $this->option(CURLOPT_CUSTOMREQUEST, 'POST');
        $this->option(CURLOPT_POST, TRUE);
        $this->option(CURLOPT_POSTFIELDS, $params);
    }

    public function setPut($params)
    {
        if (is_array($params))
        {
            $params = http_build_query($params, NULL, '&');
        }

        $this->option(CURLOPT_CUSTOMREQUEST, 'PUT');
        $this->option(CURLOPT_POSTFIELDS, $params);
        $this->option(CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: PUT'));
    }

    public function setDelete($params)
    {
        if (is_array($params))
        {
            $params = http_build_query($params, NULL, '&');
        }

        $this->option(CURLOPT_CUSTOMREQUEST, 'DELETE');
        $this->option(CURLOPT_POSTFIELDS, $params);
    }

    public function execute()
    {
        $this->_options[CURLOPT_TIMEOUT] = self::CURL_TIMEOUT_SEC;
        $this->_options[CURLOPT_RETURNTRANSFER] = TRUE;
        $this->_options[CURLOPT_FAILONERROR] = TRUE;
        $this->_options[CURLOPT_FOLLOWLOCATION] = TRUE;
        $this->_options();

        $this->_response = curl_exec($this->_session);
        $this->_info = curl_getinfo($this->_session);

        if($this->_response === false){
            $this->_errorCode = curl_errno($this->_session);
            $this->_errorString = curl_error($this->_session);
            curl_close($this->_session);
            $this->setDefault();
            return false;
        }else{
            curl_close($this->_session);
            $response = $this->_response;
            $this->setDefault();
            return $response;
        }
    }

    private function _options()
    {
        curl_setopt_array($this->_session, $this->_options);
    }

    private function setDefault()
    {
        $this->_response = '';
        $this->_options = array();
        $this->_errorCode = NULL;
        $this->_errorString = '';
        $this->_session = NULL;
    }
}