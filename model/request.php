<?php

//include_once ("validation/requestValidator.php");
//include_once ("exception/requestException.php");

class Request
{

    private $method;
    private $protocol;
    private $host;
    private $uri;
    private $queryString;
    private $body;
    private $resource;
    private $operation;
    private $rv;

    public function __construct($method, $protocol, $host, $uri = null, $queryString = null, $body = null)
    {
        $this->rv = new RequestValidator();

        $this->setMethod($method);
        $this->setProtocol($protocol);
        $this->host = $host;
        $this->setUri($uri);
        $this->setQueryString($queryString);
        $this->body = $body;
        $this->setResource();
        $this->setOperation();

    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function getOperation()
    {
        return $this->operation;
    }

    public function getQueryString()
    {
        return $this->queryString;
    }

    private function setMethod($method)
    {
        if (!$this->rv->isMethodValid($method))
            throw new RequestException("405", "Method not allowed");
        $this->method = $method;
    }

    private function setProtocol($protocol)
    {
        if (!$this->rv->isProtocolValid($protocol))
            throw new RequestException("505", "HTTP Version Not Supported");
        $this->protocol = $protocol;
    }

    private function setUri($uri)
    {
        $cleanUri = explode('?', $uri);
        $arrayUri = explode('/', $cleanUri[0]);

        if (!$this->rv->isUriValid($arrayUri, $this->method))
            throw new RequestException("400", "Bad request");

        $this->uri = $cleanUri[0];
    }

    private function setQueryString($queryString)
    {
        $finalQueryString = Array();

        if (strlen($queryString) > 0) {
            $queryArray = explode('&', $queryString);

            foreach ($queryArray as $value) {
                $a = explode('=', $value);
                if (!$this->rv->isQueryStringValid($a))
                    throw new RequestException("400", "Bad request");
                $finalQueryString[$a[0]] = $a[1];
            }
        }

        $this->queryString = $finalQueryString;
    }

    private function setResource()
    {
        $uri = explode("/", $this->uri);
        $this->resource = $uri[2];
    }

    private function setOperation()
    {
        $op = '';
        $uri = explode("/", $this->uri);
        if (!empty($uri[3]))
            $op = $uri[3];

        $this->operation = $op;
    }


}
