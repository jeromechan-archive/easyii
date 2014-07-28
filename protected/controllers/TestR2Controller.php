<?php

class TestR2Controller extends RestServer
{
    public function actionGetDemo($urlVar, $getData)
    {
        $mrestclient = new MRestClient();
        $result = $mrestclient->get('', array());
        var_dump($result);

        //var_dump($urlVar, $getData);
        $this->returnRest($getData);
    }

    public function actionPostDemo($postData)
    {
        $this->returnRest($postData);
    }
} 