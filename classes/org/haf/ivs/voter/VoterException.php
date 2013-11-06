<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace org\haf\ivs\voter;
use org\haf\ivs\IvsException;

/**
 * Description of VoterAuthenticationException
 *
 * @author abie
 */
class VoterException extends IvsException
{
    const WRONG_USER_NAME          = 'voter:wrongUserName';
    const WRONG_PASSWORD           = 'voter:wrongPassword';
    const WRONG_USER_NAME_PASSWORD = 'voter:wrongUserNamePassword';
    const INFO_NOT_COMPLETE        = 'voter:authNotComplete';

}
