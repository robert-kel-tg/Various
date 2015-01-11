<?php

namespace test1\Src;

class LogDetails {

    public function getDetails(User $user, Log $log)
    {
        return "User name: {$user->getName()} and Log name: {$log->getName()} ";
    }

}