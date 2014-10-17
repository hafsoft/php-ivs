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

namespace org\haf\ivs;

use org\haf\ivs\tool\Json;
use org\haf\ivs\voter\IVoter;

/**
 * Class IvsService
 *
 * @package org\haf\ivs
 */
class IvsService extends Ivs
{
    /** @var  string */
    private $sessionId;

    /** @var  IVoter */
    private $currentVoter;

    /**
     *
     */
    public function handleRequest()
    {
        $this->remoteCall = true;

        try {
            header('Content-type: application/json');
            $raw_input = file_get_contents('php://input');
        } catch (\Exception $e) {
            header('HTTP/1.0 500 Internal Server Error');
            echo 'Unable to read request';
            return;
        }

        /** @var IvsServiceRequest $request */
        $request          = IvsServiceRequest::fromArray(Json::unSerializeFromJson($raw_input));
        $this->sessionId  = $request->getSessionId();
        $respond          = $this->processRequest($request);
        $respondTxt       = Json::serializeToJson($respond);
        echo $respondTxt;
    }

    /**
     *
     * @param IvsServiceRequest $request
     * @return IvsServiceRespond
     */
    private function processRequest($request)
    {
        /** @var mixed $result */
        $result = null;

        /** @var IvsException $error */
        $error = null;

        if ($request->isValid()) {
            $manager = $this->getManager($request->getManagerName());

            if ($manager->isRemoteAllowed($request->getMethodName())) {
                try {
                    ENABLE_LOG && Ivs::log('calling %s->%s()',
                        $request->getManagerName(),
                        $request->getMethodName()
                    );

                    $result = call_user_func_array(array(&$manager, $request->getMethodName()), $request->getArguments());
                } catch (IvsException $e) {
                    $error = $e;
                } catch (\Exception $e) {
                    $error = new IvsException(IvsException::ERROR_UNKNOWN, $e->getMessage());
                }
            } else {
                $error = new IvsException(IvsException::ACCESS_DENIED, 'can not call "%s::%s()"',
                    $request->getManagerName(), $request->getMethodName());
            }
        } else {
            $error = new IvsException(IvsException::INVALID_REQUEST, 'Invalid Request');
        }

        $respond = new IvsServiceRespond();
        $respond->setVersion($this->getVersion());
        $respond->setId($request->getId());
        $respond->setResult($result);
        $respond->setError($error);
        return $respond;
    }

    /**
     * @return string
     */
    protected function getSessionId() {
        return $this->sessionId;
    }

    /**
     * @return IVoter
     */
    public function &getCurrentVoter() {
        if ($this->currentVoter === NULL) {
            $this->currentVoter = $this->getVoterManager()->getFromSessionId($this->getSessionId());
        }
        return $this->currentVoter;
    }

}
