<?php
function getConnection(): PDO {
    return new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
}