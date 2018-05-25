<?php

/**
 * Created by PhpStorm.
 * User: minh
 * Date: 5/25/18
 * Time: 11:37 PM
 */
require 'PasswordManager.php';

function main()
{
    $passwordManagerClass = new PasswordManager();
    $passwordManagerClass->setUserName('Huynh Van Minh');

    $list_passwords = [
        'in sadsa',
        'in',
        'inh@1234',
        'inh1234',
        'MJD1234',
        'Minh@1234'
    ];
    foreach ($list_passwords as $password){
        if ($passwordManagerClass->setNewPassword($password)) {
            $passwordManagerClass->store();
        }
    }
}

function verifyPassword()
{
    $passwordManagerClass = new PasswordManager();

    if($passwordManagerClass->load()){
        //password incorrect
        $passwordManagerClass->verifyPasswordPublic('Minh@123');
        //password correct
        $passwordManagerClass->verifyPasswordPublic('Minh@1234');
    }
}

main();
verifyPassword();


