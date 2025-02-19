<?php

namespace Component\magfa;

use Exception;
use SoapClient;
use soapval;

class WebServiceSample
{

    // your username (fill it with your username)
    private  $USERNAME = "rameshgaran_75148";

    // your password (fill it with your password)
    private  $PASSWORD = "SteFvvWDIYWAiRJq";

    // your domain (fill it with your domain - usually: "magfa")
    private  $DOMAIN = "magfa";

    private $NUMBER = '300075148';

    // base webservice url
    // private  $BASE_WEBSERVICE_URL = "http://sms.magfa.com/services/urn:SOAPSmsQueue?wsdl";
    // private  $BASE_WEBSERVICE_URL = "https://sms.magfa.com/api/soap/sms/v1/server?wsdl";
    // private  $BASE_WEBSERVICE_URL = "https://sms.magfa.com/api/http/sms/v2/send";
    private  $BASE_WEBSERVICE_URL    = 'https://sms.magfa.com/api/soap/sms/v2/server?wsdl';

    private $client; // nusoap client object

    private  $ERROR_MAX_VALUE = 1000;
    private $errors;





    /**
     * method : constructor
     * the constructor method of the class
     * @return void
     */
    public function __construct()
    {

        include_once(ROOT_DIR . 'component/magfa/errors.php');
        $this->errors = $errors;

        require_once(ROOT_DIR . 'component/magfa/nusoap/nusoap.php'); // including the nosoap library

        try {

            // $this->client = new nusoap_client($this->BASE_WEBSERVICE_URL); // creating an instance of nusoap client object
            // // set the character set to utf-8 (inorder to prevent corrupting persian messages sending via webservice )

            // $this->client->soap_defencoding = 'UTF-8';
            // $this->client->decode_utf8 = false;
            // $this->client->setCredentials($this->USERNAME, $this->PASSWORD, "basic"); // authentication


            $options = [
                'login' => "$this->USERNAME/$this->DOMAIN",
                'password' => $this->PASSWORD, // -Credientials
                'cache_wsdl' => 'WSDL_CACHE_NONE', // -No WSDL Cache
                'compression' => ('SOAP_COMPRESSION_ACCEPT' | 'SOAP_COMPRESSION_GZIP' | 5), // -Compression *
                'trace' => false // -Optional (debug)
            ];

            // $options = [
            //     'login' => $this->USERNAME, 'password' => $this->PASSWORD, // -Credientials
            //     'cache_wsdl' => WSDL_CACHE_NONE, // -No WSDL Cache
            //     'trace' => false // -Optional (debug)
            // ];


            $this->client = new SoapClient($this->BASE_WEBSERVICE_URL, $options);
        } catch (Exception $e) {
            $this->client = null;
        }
    }



    public function send($mobile, string $message)
    {
        return $this->client->send(
            [$message], // messages
            [$this->NUMBER], // short numbers can be 1 or same count as recipients (mobiles)
            [$mobile], // recipients
            [123], // Encodings are optional, The system will guess it, itself ;)
            [], // Encodings are optional, The system will guess it, itself ;)
            [], // UDHs, Please read Magfa UDH Documnet
            [] // Message priorities (unused).
        );
    }



    /**
     * method : simpleEnqueueSample
     * this method provides a sample usage of "enqueue" service in the simplest format (one receiver)
     * @return void
     */
    public function simpleEnqueueSample($recipientNumber, $message)
    {

        return $this->send($recipientNumber, $message);

        // change algorithm

        $method = "enqueue"; // name of the service
        //$message = "MAGFA webservice-enqueue test"; // [FILL] your message to send
        //$senderNumber = "300075148"; // [FILL] sender number; which is your 3000xxx number
        //$recipientNumber = "09XXXXXXXXX"; // [FILL] recipient number; the mobile number which will receive the message (e.g 0912XXXXXXX)
        // creating the parameter array
        $params = array(
            'domain' => $this->DOMAIN,
            'messageBodies' => array($message),
            'recipientNumbers' => array($recipientNumber),
            'senderNumbers' => array($this->NUMBER)
        );


        // sending the request via webservice
        $response = $this->call($method, $params);

        // Error soap
        if (isset($response['result']) and $response['result'] != -1) {
            $result = $response[0];
            // compare the response with the ERROR_MAX_VALUE
            if ($result <= $this->ERROR_MAX_VALUE) {
                //echo "An error occured <br> ";
                //echo "Error Code : $result ; Error Title : " . $this->errors[$result]['title'] . ' {' . $this->errors[$result]['desc'] . '}';
                return false;
            } else {
                //echo "Message has been successfully sent ; MessageId : $result";
                return true;
            }
        } else {
            return false;
        }
    }





    /**
     * method : enqueueSample
     * this method provides a sample usage of "enqueue" service
     * @see simpleEnqueueSample()
     * @return void
     */
    public function enqueueSample($number, $text)
    {
        $method = "enqueue"; // name of the service
        //$message = "MAGFA webservice-enqueue test"; // [FILL] your message to send
        //$senderNumber = "3000XXX"; // [FILL] sender number; which is your 3000xxx number
        // [FILL] recipient number; here we have multiple recipients (2)
        $recipientNumbers = array(
            new soapval('item1', 'string', '09XXXXXXXXX'), // [FILL]
            new soapval('item2', 'string', '09XXXXXXXXX') // FILL
            // you can add more items here ...
        );

        // creating the parameter array
        $params = array(
            'domain' => $this->DOMAIN,
            'messageBodies' => array($message),
            'recipientNumbers' => $recipientNumbers,
            'senderNumbers' => array($senderNumber)
        );

        // sending the request via webservice
        $response = $this->call($method, $params);

        foreach ($response as $result) {
            // compare the response with the ERROR_MAX_VALUE
            if ($result <= $this->ERROR_MAX_VALUE) {
                echo "An error occured <br> ";
                echo "Error Code : $result ; Error Title : " . $this->errors[$result]['title'] . ' {' . $this->errors[$result]['desc'] . '}';
            } else {
                echo "Message has been successfully sent ; MessageId : $result";
            }
            echo "<br>";
        }
    }





    /**
     * method : getAllMessagesSample
     * this method provides a sample usage of "getAllMessages" service
     * @return void
     */
    public function getAllMessagesSample()
    {
        $method = "getAllMessages"; // name of the service
        $numberOfMessasges = 10; // [FILL] number of the messages to fetch

        // creating the parameter array
        $params = array(
            'domain' => $this->DOMAIN,
            'numberOfMessages' => $numberOfMessasges
        );

        // sending the request via webservice
        $response = $this->call($method, $params);

        if (count($response) == 0) {
            echo "nothing returned ";
        } else {
            // display the incoming message(s)
            foreach ($response as $result) {
                echo "Message : " . var_dump($result);
                echo "<br>";
            }
        }
    }





    /**
     * method : getAllMessagesWithNumberSample
     * this method provides a sample usage of "getAllMessagesWithNumber" service
     * @return void
     */
    public function getAllMessagesWithNumberSample()
    {
        $method = "getAllMessagesWithNumber"; // name of the service
        $numberOfMessages = 10; // [FILL] number of the messages to fetch
        $destinationNumber = "983000XXX"; // [FILL] the 983000xxx number

        // creating the parameter array
        $params = array(
            'domain' => $this->DOMAIN,
            'numberOfMessages' => $numberOfMessages,
            'destNumber' => $destinationNumber
        );

        // sending the request via webservice
        $response = $this->call($method, $params);

        if (count($response) == 0) {
            echo "nothing returned ";
        } else {
            // display the incoming message(s)
            foreach ($response as $result) {
                echo "Message : " . var_dump($result);
                echo "<br>";
            }
        }
    }






    /**
     * method : getCreditSample
     * this method provides a sample usage of "getCredit" service
     * @return void
     */
    public function getCreditSample()
    {
        $method = "getCredit"; // name of the service

        // creating the parameter array
        $params = array(
            'domain' => $this->DOMAIN
        );

        // sending the request via webservice
        $response = $this->call($method, $params);

        // display the result
        echo 'Your Credit : ' . $response;
    }






    /**
     * method : getMessageIdSample
     * this method provides a sample usage of "getMessageId" service
     * @return void
     */
    public function getMessageIdSample()
    {
        $method = "getMessageId"; // name of the service
        $checkingMessageId = 17; // [FILL] your checkingMessageId

        // creating the parameter array
        $params = array(
            'domain' => $this->DOMAIN,
            'checkingMessageId' => new soapval('arg1', 'long', $checkingMessageId)
        );

        // sending the request via webservice
        $result = $this->call($method, $params);

        // compare the response with the ERROR_MAX_VALUE
        if ($result <= $this->ERROR_MAX_VALUE) {
            echo "An error occured <br> ";
            echo "Error Code : $result ; Error Title : " . $this->errors[$result]['title'] . ' {' . $this->errors[$result]['desc'] . '}';
        } else {
            echo " MessageId : $result";
        }
    }



    /**
     * method : getMessageStatusSample
     * this method provides a sample usage of "getMessageStatus" service
     * @return void
     */
    public function getMessageStatusSample()
    {
        $method = 'getMessageStatus'; // name of the service
        $messageId = 718570969; // [FILL] your messageId

        // creating the parameter array
        $params = array(
            'messageId' => new soapval('arg0', 'long', $messageId)
        );

        //sending request via webservice
        $result = $this->call($method, $params);

        // checking the response
        if ($result == -1) {
            echo "An error occured <br> ";
            echo "Error Code : $result ; Error Title : " . $this->errors[$result]['title'] . ' {' . $this->errors[$result]['desc'] . '}';
        } else {
            echo " Message Status : $result";
        }
    }






    /**
     * method : getMessageStatusesSample
     * this method provides a sample usage of "getMessageStatuses" service
     * @return void
     */
    public function getMessageStatusesSample()
    {
        $method = 'getMessageStatuses'; // name of the service
        // [FILL] an array of messageIds to check
        $messageIds = array(
            new soapval('item1', 'long', 718570968), // [FILL] your messageID here
            new soapval('item2', 'long', 718570969) //  [FILL] your messageID here
        );

        // creating the parameter array
        $params = array(
            'messagesId' => $messageIds
        );

        // sending the request via webservice
        $response = $this->call($method, $params);

        // checking the response
        foreach ($response as $result) {
            if ($result == -1) {
                echo "An error occured <br> ";
                echo "Error Code : $result ; Error Title : " . $this->errors[$result]['title'] . ' {' . $this->errors[$result]['desc'] . '}';
            } else {
                echo " Message Status : $result";
            }
            echo "<br>";
        }
    }





    /**
     * method : getRealMessageStatuses
     * this method provides a sample usage of "getRealMessageStatuses" service
     * @return void
     */
    public function getRealMessageStatusesSample()
    {
        $method = 'getRealMessageStatuses'; // name of the service
        // [FILL] an array of messageIds to check
        $messageIds = array(
            new soapval('item1', 'long', 718570968), // [FILL] your messageID here
            new soapval('item2', 'long', 718570969) // [FILL] your messageID here
        );

        // creating the parameter array
        $params = array(
            'arg0' => $messageIds
        );

        // sending the request via webservice
        $response = $this->call($method, $params);

        // checking the response
        foreach ($response as $result) {
            if ($result == -1) {
                echo "An error occured <br> ";
                echo "Error Code : $result ; Error Title : " . $this->errors[$result]['title'] . ' {' . $this->errors[$result]['desc'] . '}';
            } else {
                echo " Message Status : $result";
            }
            echo "<br>";
        }
    }




    private function call($method, $params)
    {
        if ($this->client == null) return array('result' => -1, 'msg' => 'soap error');

        $result = $this->client->call($method, $params);

        if ($this->client->fault || ((bool)$this->client->getError())) {
            echo '<br>';
            echo "nusoap error: " . $this->client->getError();
            echo '<br>';
        }
        //var_dump($result); echo "<br>";
        return $result;
    }
}
