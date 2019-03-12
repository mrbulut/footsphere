<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 15.02.2019
 * Time: 09:21
 */


interface IUserService
{

    function getUser($UserId);

    function createUser(User $user, $capability);

    function deleteUser($UserId);

    function updateUser(User $user, $UserId);

}