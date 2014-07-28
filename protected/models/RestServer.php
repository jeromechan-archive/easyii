<?php
/**
 * Copyright © 2014 Jerome Chan. All rights reserved.
 *
 * @author chenjinlong
 * @date 7/5/14
 * @time 11:14 PM
 * @description RestServer.php
 */
class RestServer extends MRestController
{
    private $_response = array(
        'status' => '',
        'code' => '',
        'msg' => '',
        'data' => array(),
    );

    public function returnRest($data, $status = TRUE, $code = 0, $msg = 'success')
    {
        $this->_response['status'] = $status;
        $this->_response['code'] = $code;
        $this->_response['msg'] = $msg;
        $this->_response['data'] = $data;
        $this->renderResponse($this->_response);
    }
}