<?php

//require_once ("model/request.php");
//require_once ("validation/requestValidator.php");
//require_once ("controller/usercontroller.php");

class RequestTreater
{

    private $controllers = Array(
        "users" => "UserController",

        'product' => 'ProductControler', 'provider' => 'ProviderControler', 'employee' => 'EmployeeControler', 'user' => 'UserControler',
        'function' => 'FunctionControler', 'section' => 'SectionControler', 'sale' => 'SaleControler', 'purchase' => 'PurchaseControler',
        'bonus' => 'BonusControler',
        'expense' => 'ExpenseControler', 'productLost' => 'ProductLostControler', 'saleItem' => 'SaleItemControler', 'purchaseItem' => 'PurchaseItemControler'
    );

    public function start()
    {
        try {

            $request = new Request($_SERVER['REQUEST_METHOD'],
                $_SERVER['SERVER_PROTOCOL'],
                $_SERVER['HTTP_HOST'],
                $_SERVER['REQUEST_URI'],
                $_SERVER['QUERY_STRING'],
                file_get_contents('php://input'));

//            return $request;

            $controller = new $this->controllers[$request->getResource()]($request);

            return $controller->routeOperation();

        } catch (RequestException $re) {
            return $re->toJson();
        }


    }
}

/*
{
  "name": "joao",
  "email": "joao@email.com",
  "pass": "a",
  "bdate": "01/01/2001"
}
*/















