<?php
namespace App\Http\Middleware;

use Core\Http\Middleware\BasicAuthentication as Middleware;

class BasicAuthentication extends Middleware
{
    /**
     * Put list of users who can access
     *
     * @example ['admin' => 'password']
     * @var array
     */
    protected $users = [
        'admin' => '123',
    ];
}
