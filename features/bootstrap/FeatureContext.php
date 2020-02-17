<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->bearerToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiYTk1ZmQwNDYwMDNlYjk3YzE1MzRmMjBlZWQ2Y2I4YzZiZjY0ZDU0YjYyN2ZkOGNmNWU5NTBlZGU1M2UzOTJiMDJmZjVhODlhMjZiYWJlMmUiLCJpYXQiOjE1ODE1ODk2NTYsIm5iZiI6MTU4MTU4OTY1NiwiZXhwIjoxNjEzMjEyMDU2LCJzdWIiOiI2Iiwic2NvcGVzIjpbXX0.OY7-RE0fEEcUGmijWtGx1Z59UHjmTUuB3sOUv8N_c0B_41CIjjJfLB1f33eBwiZhPZdc9jmw8S-TQUrjl5uh-nlRQZSUH4jjJCLJOJbWjUEVvRYUoZHKcg6ex1YaZWyZN4YJDEFrSBWPOp0fDRFSH5xRIegV34da370QyDhzJWce1MkM_KrpN6oRNHgxAvZ5Et1ZzrtgQS4ICwx4WFuVwnnIBEGdFJUTzN01TluuAJGvO5dIZFZrYmO5ykxzB2VhOcPE71oNVUcKZbLswZwppPx1qKokM5fBSW5_I8wRiX5u8TMZly6pnG5A17RoPjohGowgKAamxBintN8EZfAdq2im1enoFTme_o2UsS_K_Xm4Akg6knD4Z8X53rm8_jxDtiNzsnbY3QkJwOp-gJRqfnIFilsubj8L6Pt7sYW0zzihxQDrE0K2PM3TvrY_aufsZMKC_yBOK-RgLudiZvYns3lzF9JIXIniVY8efytzOYxJcrRr9osweSypx8_LvPmYD4YI7zwCcnC4bwIC4ovLi-rAewBNODBmgjQYNIE5G8OHs_ngeM7LnLdLkBXW07r5t2iGdY4NWqcCIfOledTo3DBHnrmDlyxcMnuT08YdxU3Z8k1-f2gJqjnINOGFGHqQ9hNpOO5xBCL6jnJuC4RJCmdStO3QpJwkSFjSOcX4Lxs\"";
    }

    public function  iHaveThePayload(PyStringNode $string)
    {
        $this->payload = $string;
    }

  /*
   * @When /^I request "(GET/PUT/POST/DELETE/PATCH) ([^"]*)"$/
   */

    public  function iRequest($httpMethod, $argument1)
    {
        $client = new GuzzleHttp\Client ();
        $this->response = $client->request(
            $httpMethod,
            'http://client-server.application' .$argument1,
            [
                'body' => $this->payload,
                'headers'=>[
                    "Authorization" =>"Bearer {$this->bearerToken}",
                    "Content-Type" => "application/json"
                ],
            ]

        );

        $this->responseBody = $this->response->getBody(true);
    }

    /*
     * @Then /^I get a response$/
     */

    public  function  iGetAResponse()
    {
        if(empty($this->responseBody)){
            throw new Exception("Did nit get a response from the API");
        }
    }

    /*
     * @Given /^the response is JSON$/
     */

    public  function  theResponseIsJson()
    {
        $data = json_decode($this->responseBody);

        if(empty($data)){
            throw new Exception("Response was not JSON\n" . $this->responseBody);
        }
    }

    /**
     * @Then the response contains  :arg1 records
     */
    public function theResponseContainsRecords($arg1)
    {
        $data = json_decode($this->responseBody);
        $question = $data[0];
        if (!property_exists($question, 'question')){
            throw new Exception('This is not a question');
        }

        /*$data = json_decode($this->responseBody);
        $count = count($data);
        return ($count === $arg1);
        //throw new PendingException();*/
    }

    /**
     * @Then the response contains  a title  of :arg1
     */
    public function theResponseContainsATitleOf($arg1)
    {
        $data = json_decode($this->responseBody);
        if ($data->title == $arg1){

        }else{

            throw new Exception('The title does not much');
        }
    }


}
