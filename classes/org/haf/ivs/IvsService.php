<?php

/**
 * Description of IvsService
 *
 * @author abie
 */

namespace org\haf\ivs;

use org\haf\ivs\tool\Json;
use org\haf\ivs\voter\IVoter;

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

            if ($manager->isMethodAllowed($request->getMethodName())) {
                try {
                    ENABLE_LOG && Ivs::log('calling %s->%s(%s)',
                        $request->getManagerName(),
                        $request->getMethodName(),
                        substr(Json::serializeToJson($request->getArguments()), 1, -1)
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

        return new IvsServiceRespond($request->getId(), $result, $error);
    }

    /**
     * @return IVoter
     */
    public function &getCurrentVoter() {
        if ($this->currentVoter === NULL) {
            $this->currentVoter = $this->getVoterManager()->getFromSessionId($this->sessionId);
        }
        return $this->currentVoter;
    }

}
