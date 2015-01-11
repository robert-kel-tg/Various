<?php
/**
 * Created by PhpStorm.
 * User: robertas
 * Date: 11/01/15
 * Time: 01:23
 */

class LogDetails {

    public function getDetails(User $user, Log $log)
    {
        return "User name: {$user->getName()} and Log name: {$log->getName()} ";
    }

}   