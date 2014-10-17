<?php
/**
 * HafSoft Integrated Voting System
 * Copyright (c) 2013 Abi Hafshin Alfarouq
 * < abi [dot] hafshin [at] ui [dot] ac [dot] id >
 *
 * php-ivs is php wrapper for HafSoft Integrated Voting System.
 * more info: http://github.com/hafsoft/php-ivs
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

namespace org\haf\ivs\voter;
use org\haf\ivs\IvsException;

/**
 * Class VoterException
 *
 * @package org\haf\ivs\voter
 */
class VoterException extends IvsException
{
    const WRONG_USER_NAME          = 'voter:wrongUserName';
    const WRONG_PASSWORD           = 'voter:wrongPassword';
    const WRONG_USER_NAME_PASSWORD = 'voter:wrongUserNamePassword';
    const INFO_NOT_COMPLETE        = 'voter:authNotComplete';
    const AUTH_FAILED = 'voter:authFailed';

    const INVALID_SESSION = 'voter:invalidSession';
}
