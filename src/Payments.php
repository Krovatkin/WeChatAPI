<?
namespace Utao\WeChat;

class Payments {
    public $key;

    function __construct($appid, $mchid, $key) {
        $this->appid = $appid;
        $this->mchid = $mchid;
        $this->key = $key;
    }
    
    function sign($preorder)
    {
        $digest = "";
        array_walk($preorder, function($v, $k) use (&$digest) {
            $digest .= "{$k}={$v}&";
        });
        $digest .= "key={$this->key}";
        return strtoupper(md5($digest));
    }

    private static function _formatXml($simpleXMLElement)
    {
        $xmlDocument = new \DOMDocument('1.0');
        $xmlDocument->preserveWhiteSpace = false;
        $xmlDocument->formatOutput = true;
        $xmlDocument->loadXML($simpleXMLElement->asXML());
        return implode("\n", array_slice(explode("\n", $xmlDocument->saveXML()), 1));
    }

    function xml($preorder) {
        $preorder["appid"] = $this->appid;
        $preorder["mch_id"] = $this->mchid;
        ksort($preorder);
        $signature = sign($preorder);
        $xml = new \SimpleXMLElement('<xml/>');
        array_walk($preorder, function($k, $v) use (&$xml) {
            $xml->addChild($v, $k); 
        });
        $xml->addChild("sign", $signature);
        $xml_str = $this->_formatXml($xml);
        return $xml_str;
    }
}

?>