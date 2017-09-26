<?php

//include_once "IrequestValidator.php";

class RequestValidator implements IRequestValidator
{
    private $allowedMethods = Array('GET', 'PUT', 'POST');

    private $allowedProtocols = Array('HTTP/1.1', 'HTTPS/1.1');

    private $allowedUris = Array('product', 'provider', 'employee', 'users', 'function', 'section', 'sale', 'purchase', 'bonus', 'expense', 'productLost', 'saleItem', 'purchaseItem');

    public function isUriValid($arrayUri, $method)
    {
        //verificar se arrayUri[2] é chave
        if (!in_array($arrayUri[2], $this->allowedUris))
            return false;

        switch ($method) {
            case 'POST':
                if (isset($arrayUri[3])) {
                    if (!empty($arrayUri[3]))
                        return false;
                }
                break;
            case 'PUT':
                if (isset($arrayUri[3])) {
                    if ($arrayUri[3] != 'disable' && $arrayUri[3] != '')
                        return false;
                }
                break;
            case 'GET':
                if (isset($arrayUri[3])) {
                    if (!empty($arrayUri[3]))
                        return false;
                }
                break;
        }

        return true;
    }

    public function isMethodValid($method)
    {

        if (!in_array($method, $this->allowedMethods))
            return false;

        return true;
    }

    public function isProtocolValid($protocol)
    {
        if (!in_array($protocol, $this->allowedProtocols))
            return false;

        return true;
    }


    public function isQueryStringValid($qs)
    {
        if (isset($qs[0]) && $qs[0] != "") {
            if (isset($qs[1]) && $qs[1] != "")
                return true;
        }

        return false;
    }

    public function isBodyValid($body)
    {

    }
}