<?php
/**
 * Copyright © 2014 Jerome Chan. All rights reserved.
 * 
 * @author chenjinlong
 * @date 7/22/14
 * @time 7:58 PM
 * @description ErrorCodeDict.php
 *
 * 错误码范围 01-10
 * (SYS) 01-05
 * (SERVICE) 06-10
 */
class ErrorCodeDict
{
    /**
     * System Codes
     */
    const ERROR_SUCCESS = 01;
    const ERROR_INVALID_PARAM = 02;
    const ERROR_ACCESS_DENIED = 03;
    const ERROR_INVALID_HANDLE = 04;

    /**
     * Service Codes
     */
    const ERROR_REMOTE_SERVICE_FAIL = 06;

    /**
     * 错误码映射字典
     *
     * @var array
     */
    public static $_errCodeDict = array(
        /*SYSTEM CODES*/
        '01' => 'The operation completed successfully',
        '02' => 'The parameter is invalid',
        '03' => 'Access is denied',
        '04' => 'The handle is invalid',
        /*SERVICE CODES*/
        '06' => 'Remote service error',
    );

    /**
     * 查询ErrorCode的文本描述
     *
     * @param $errorCode
     * @return mixed
     * @throws Exception
     */
    public static function getErrorCodeDescription($errorCode)
    {
        if(isset(self::$_errCodeDict[$errorCode])){
            return self::$_errCodeDict[$errorCode];
        }else{
            throw new Exception("The error code is undefined");
        }
    }
}