<?php

namespace App\Controllers;

use Phalcon\DI\Injectable;

/**
 * Class AbstractController
 *
 * @property \Phalcon\Http\Request              $request
 * @property \Phalcon\Http\Response             $htmlResponse
 * @property \Phalcon\Db\Adapter\Pdo\Mysql      $db
 * @property \Phalcon\Config                    $config
 * @property \App\Services\UsersService         $usersService
 * @property \App\Models\Users                  $user
 */
abstract class AbstractController extends Injectable
{
    /**
     * Route not found. HTTP 404 Error
     */
    const ERROR_NOT_FOUND = 404;

    /**
     * Invalid Request. HTTP 400 Error.
     */
    const ERROR_INVALID_REQUEST = 400;
}
