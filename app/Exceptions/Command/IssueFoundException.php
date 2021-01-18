<?php
namespace App\Exceptions\Command;

use Exception;

class IssueFoundException extends Exception {
    protected const HTTP_STATUS = 400;
}