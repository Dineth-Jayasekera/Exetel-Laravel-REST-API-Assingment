<?php

namespace App\Helpers;

class Errors
{
    public static $TOKEN_UNAUTHORIZED = "Invalid session.";
    public static $TOKEN_FORBIDDEN = "Access denied";
    public static $COMMON_DB_ERROR = "Something went wrong.";
    public static $INVALID_LOGIN_CREDENTIALS = "Invalid credentials.";
    public static $CUSTOMER_CREATION_ERROR = "Something Went Wrong on customer creation.";
    public static $CUSTOMER_ALL_DATA_ERROR = "Something Went Wrong on customer data receiving.";
    public static $CUSTOMER_UPDATING_ERROR = "Something Went Wrong on customer data updating.";
    public static $CUSTOMER_DELETION_ERROR = "Something Went Wrong on customer data deletion.";

}
