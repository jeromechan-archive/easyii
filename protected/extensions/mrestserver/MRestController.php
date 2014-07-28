<?php
/**
 * Copyright © 2014 Jerome Chan. All rights reserved.
 * 
 * @author chenjinlong
 * @date 7/5/14
 * @time 9:30 PM
 * @description MRestBaseController.php
 */
class MRestController extends CController
{
    const C200_OK = 'HTTP/1.1 200 OK';
    const C201_CREATED = 'HTTP/1.1 201 Created';
    const C401_UNAUTHORIZED = 'HTTP/1.1 401 Unauthorized';
    const C404_NOT_FOUND = 'HTTP/1.1 404 Not Found';
    const C406_NOT_ACCEPTABLE = 'HTTP/1.1 406 Not Acceptable';
    const C500_INTERNAL_SERVER_ERROR = 'HTTP/1.1 500 Internal Server Error';

    private $_prefix = 'action';

    public $HTTPStatus = '';

    public function actionMRestGet($id, $var = null)
    {
        $this->HTTPStatus = $this->getHttpStatus(200);

        $method = $this->buildAction($id, 'Get');
        if (method_exists($this, $method)){
            $this->$method($var, $this->data());
        }else{
            throw new CHttpException(500, 'Method does not exist.');
        }
    }

    public function actionMRestPost($id)
    {
        $this->HTTPStatus = $this->getHttpStatus(201);

        $method = $this->buildAction($id, 'Post');
        if (method_exists($this, $method)){
            $this->$method($this->data());
        }else{
            throw new CHttpException(500, 'Method does not exist.');
        }
    }

    public function actionMRestPut($id)
    {
        $this->HTTPStatus = $this->getHttpStatus(201);

        $method = $this->buildAction($id, 'Put');
        if (method_exists($this, $method)){
            $this->$method($this->data());
        }else{
            throw new CHttpException(500, 'Method does not exist.');
        }
    }

    public function actionMRestDelete($id)
    {
        $this->HTTPStatus = $this->getHttpStatus(201);

        $method = $this->buildAction($id, 'Delete');
        if (method_exists($this, $method)){
            $this->$method($this->data());
        }else{
            throw new CHttpException(500, 'Method does not exist.');
        }
    }

    public function renderResponse($data)
    {
        $this->layout = 'ext.mrestserver.json';
        $data = $this->encode($data);
        $this->render('ext.mrestserver.output', array('data' => $data));
    }

    protected function buildAction($id, $httpMethod)
    {
        return $this->_prefix . $httpMethod . ucfirst($id);
    }

    protected function data()
    {
        if ($this->getRequestMethod() == 'GET') {
            $data = urldecode($_SERVER['QUERY_STRING']);
        } else {
            $data = file_get_contents('php://input');
        }
        return $this->decode($data);
    }

    protected function getRequestMethod()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])){
            $method = $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'];
        }
        if ($method == 'HEAD'){
            $method = 'GET';
        }
        return $method;
    }

    protected function decode($data)
    {
        $data = empty($data) ? '[]' : $data;
        return CJSON::decode($data);
    }

    protected function encode($data)
    {
        $data = empty($data) ? array() : $data;
        return CJSON::encode($data);
    }

    protected function getHttpStatus($statusCode)
    {
        switch ($statusCode) {
            case '200':
                return self::C200_OK;
                break;
            case '201':
                return self::C201_CREATED;
                break;
            case '401':
                return self::C401_UNAUTHORIZED;
                break;
            case '404':
                return self::C404_NOT_FOUND;
                break;
            case '406':
                return self::C406_NOT_ACCEPTABLE;
                break;
            case '500':
                return self::C500_INTERNAL_SERVER_ERROR;
                break;
            default:
                return self::C200_OK;
        }
    }
}