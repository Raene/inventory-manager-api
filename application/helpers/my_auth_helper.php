<?php
use \Firebase\JWT\JWT;
function isLoggedIn($authHeader, $key){
    if(!$authHeader)
    {
        throw new Exception("Access Denied", 500);
    }
    $tokenArr = explode(" ", $authHeader);
    $jwt = $tokenArr[1];
    $decoded = JWT::decode($jwt, $key, array('HS256'));

    return (array) $decoded;
}