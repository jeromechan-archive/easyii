<?php
/**
 * Coypright (C) Jerome Chan 2014 All rights reserved
 * Author: jeromechan
 * Date: 8/13/14
 * Time: 3:11 PM
 * Description: XmlUtils.php
 */
class XmlUtils
{
    /**
     * XML格式转成Array数组形式
     *
     * @param $xml_str
     * @return array|SimpleXMLElement
     */
    public function xml2Array($xml_str)
    {
        $this->xmlClean($xml_str);
        $xml_obj = @simplexml_load_string($xml_str, null, LIBXML_NOCDATA);
        if (is_object($xml_obj)) {
            $this->obj2Array($xml_obj);
            return $xml_obj;
        }
        return array();
    }

    private function xmlClean(&$str)
    {
        $str = preg_replace('/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/', '', $str);
    }

    private function obj2Array(&$obj)
    {
        if (is_object($obj)) {
            if (!empty($obj)) {
                $properties = get_object_vars($obj); //获取对象所有属性返回一数组 其中包括了 xml 节点的 属性 和 子节点
                $attributes = $properties['@attributes']; //备份属性数组
                unset($properties['@attributes']); //unset 属性中的 属性数组
                if ($properties) {
                    $obj = $properties;
                } else if ($attributes) {
                    $obj = $attributes;
                } else {
                    $obj = '';
                }
            } else {
                $obj = '';
            }
        }

        if (is_array($obj)) {
            foreach ($obj as $k => $v) {
                $this->obj2Array($obj[$k]);
            }
        }
    }
}

