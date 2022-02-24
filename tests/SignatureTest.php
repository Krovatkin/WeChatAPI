<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class SignatureTest extends TestCase
{
    public function testAssertBasic(): void
    {

        // Note, these are just an example
        $key = "192006250b4c09247ec02edce69f6a2d";
        $appid = "wxd930ea5d5a258f4f";
        $mch_id = "10000100";

        $preorder = array(
            "nonce_str" => "1add1a30ac87aa2db72f57a2375d8fec",
            "body" => "NATIVE registration fee",
            "out_trade_no" => "1415659990",
            "total_fee" => "1",
            "spbill_create_ip" => "14.23.150.211",
            "trade_type" => "NATIVE"
        );

        $preorder["appid"] = $this->appid;
        $preorder["mch_id"] = $this->mchid;
        ksort($preorder);

        $payments = new \Utao\WeChat\Payments($appid, $mch_id, $key);
        $signature = $payments->sign($preorder);
        $this->assertEquals(
            $signature,
            '15B187A3F33F1026793F642ED7CF2FDA'
        );
    }
}
