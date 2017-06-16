<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/mns/mns-autoloader.php';
use AliyunMNS\Client;
use AliyunMNS\Topic;
use AliyunMNS\Constants;
use AliyunMNS\Model\MailAttributes;
use AliyunMNS\Model\SmsAttributes;
use AliyunMNS\Model\BatchSmsAttributes;
use AliyunMNS\Model\MessageAttributes;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Requests\PublishMessageRequest;
class PublishBatchSMSMessageDemo
{
    private $endPoint;
    private $accessId;
    private $accessKey;

    private $topicName;
    private $SMSSignName;
    private $SMSTemplateCode;
    private $param = array();

    private $receivePhoneNumber;
    private $result;

    public function __construct($endPoint,$accessId, $accessKey,$topicName,$SMSSignName,$SMSTemplateCode,$param,$receivePhoneNumber)
    {
        /**
         * Step 1. 初始化Client
         */
        $this->endPoint = $endPoint; // eg. http://1234567890123456.mns.cn-shenzhen.aliyuncs.com
        $this->accessId = $accessId;
        $this->accessKey = $accessKey;
        $this->client = new Client($this->endPoint, $this->accessId, $this->accessKey);

        $this->topicName = $topicName;
        $this->SMSSignName = $SMSSignName;
        $this->SMSTemplateCode = $SMSTemplateCode;
        $this->param = $param;
        $this->receivePhoneNumber = $receivePhoneNumber;
    }

    public function run()
    {

        /**
         * Step 2. 获取主题引用
         */
        $topic = $this->client->getTopicRef($this->topicName);
        /**
         * Step 3. 生成SMS消息属性
         */
        // 3.1 设置发送短信的签名（SMSSignName）和模板（SMSTemplateCode）
        $batchSmsAttributes = new BatchSmsAttributes($this->SMSSignName, $this->SMSTemplateCode);
        // 3.2 （如果在短信模板中定义了参数）指定短信模板中对应参数的值
        $batchSmsAttributes->addReceiver($this->receivePhoneNumber, $this->param);
//        $batchSmsAttributes->addReceiver("YourReceiverPhoneNumber2", array("YourSMSTemplateParamKey1" => "value1"));
        $messageAttributes = new MessageAttributes(array($batchSmsAttributes));
        /**
         * Step 4. 设置SMS消息体（必须）
         *
         * 注：目前暂时不支持消息内容为空，需要指定消息内容，不为空即可。
         */
        $messageBody = "smsmessage";
        /**
         * Step 5. 发布SMS消息
         */
        $request = new PublishMessageRequest($messageBody, $messageAttributes);
        try
        {
            $res = $topic->publishMessage($request);
//            echo $res->isSucceed();
//            echo "\n";
//            echo $res->getMessageId();
//            echo "\n";
            $this->result = $res->isSucceed();
            $this->result .= ';'.$res->getMessageId();
        }
        catch (MnsException $e)
        {
//            echo $e;
//            echo "\n";
            $this->result['res'] = $e;
        }
    }
    public function getRes(){
        return $this->result;
    }
}

$accessId = 'LTAIyoekJd2GiOtG';
$accessKey = 'jFenx3guLBB6KXhz45DEGJf9duKpdE';
$endPoint = 'http://1348793002340978.mns.cn-qingdao.aliyuncs.com';
$topicName = 'sms.topic-cn-qingdao';
$SMSSignName = '联创优学';
$SMSTemplateCode = 'SMS_63400491';
$code = strval(mt_rand(1000,9999));
$param = array('code'=>$code);
$receivePhoneNumber = $_POST['phone'];




$instance = new PublishBatchSMSMessageDemo($endPoint,$accessId, $accessKey,$topicName,$SMSSignName,$SMSTemplateCode,$param,$receivePhoneNumber);
$instance->run();
$result['res'] = $instance->getRes();
$result['code'] = $code;
$result['phone']=$receivePhoneNumber;
echo json_encode($result);

?>
