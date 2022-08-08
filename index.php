<?php
//Константы на поключение
const AUTH_LOGIN = 'affiliate@example.com';
const AUTH_PASS = '\)}%?FgqX<Af5~DI';
const BASE_URL = 'https://google.com';
//Массив данных для запроса
$params = [];
//Наполнение массива
$params = [
    'base_url' => BASE_URL,
    'auth_login' => AUTH_LOGIN,
    'auth_password' => AUTH_PASS,
    'request_data' => [
        'firstName' => 'TestFirstName',
        'lastName' => 'TestLastName',
        'country' => 'UA',
        'gender' => 'MALE',
        'email' => 'test@mail.com',
        'password' => '!ds81jKKKkdsd',
        'phone' => '+380000000000',
        'language' => 'en',
        'source' => 'test source',
        'referral' => 'id91827777',
        'ip' => '192.168.0.1',
        'city' => 'Kyiv',
        'address' => '',
        'postCode' => '',
        'birthday' => date('m-d-Y'),
    ]
];
//Отправка курла и вывод результата
sendCurl($params);

function sendCurl(array $paramsCurl = []){
    $ch = curl_init($paramsCurl['base_url']);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_HEADER,1);
    curl_setopt($ch, CURLOPT_USERPWD, $paramsCurl['auth_login'] . ":" . $paramsCurl['auth_password']);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paramsCurl['request_data']));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $serverOutput = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // получить статус код
    curl_close($ch);
    curlResult([
        'result' => json_decode($serverOutput, true),
        'code' => $httpCode,
    ]);
}

function curlResult(array $response){
    if($response['code'] == 200){
        //если ответ 200 обрабатываем данные с колбека
        echo $response['result']['profileUUID'];
    } else{
        //если другой, получаем ответ ошибки из сервера
        if($response['result']['message']){
            echo $response['result']['message'];
        } else {
            //Если что-то непонятное произошло
            echo 'BAD REQUEST!';
        }
    }
}
