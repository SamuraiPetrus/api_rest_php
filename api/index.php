<?php

require_once "../classe/produto.php";

class Rest {

    public static function erro ($code, $e=null) {
        
        $http_status = 200;
        $response = [
            "status" => $http_status,
            "descricao" => "Código de erro não existe."
        ];

        switch ($code) {
            case "url" :
                $http_status = 404;
                $response = [
                    "status" => $http_status,
                    "detalhes" => "Não há dados de requisição" 
                ];
                break;
            case "classe" :
                $http_status = 404;
                $response = [
                    "status" => $http_status,
                    "detalhes" => "A classe da requisição não existe" 
                ];
                break;
        }

        http_response_code($http_status);
        return json_encode($response);
    }

    public static function open ($request) {
        if (!$request) return Rest::erro("url");

        $_tree = explode("/", $request);

        $classe = ucfirst($_tree[0]);

        if (class_exists($classe)) {
            $method = $_SERVER["REQUEST_METHOD"];
            return json_encode($method);
        }else{
            return Rest::erro("classe");
        }
    }

}

if (isset($_REQUEST["url"])) {
    echo Rest::open($_REQUEST["url"]);
}else{
    echo Rest::erro("url");
}