<?php
session_start();

If(isset($_SESSION['user_id'])){
    echo 200;
}else{
    echo 419;
}