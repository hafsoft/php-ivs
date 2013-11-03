<?php

/**
 * Description of IvsService
 *
 * @author abie
 */

namespace org\haf\ivs;

use org\haf\ivs\tool\Json;

class IvsService extends Ivs
{
    protected $configuration;

    protected $privLevel;

    /**
     *
     */
    public function run()
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
                    $result = call_user_func_array(array(&$manager, $request->getMethodName()), $request->getArguments());
                } catch (IvsException $e) {
                    $error = $e;
                } catch (\Exception $e) {
                    $error = new IvsException(IvsException::ERROR_UNKNOWN, $e->getMessage());
                }
            } else {
                $error = new IvsException(IvsException::METHOD_NOT_SUPPORTED, 'Action Not Supported');
            }
        } else {
            $error = new IvsException(IvsException::INVALID_REQUEST, 'Invalid Request');
        }

        return new IvsServiceRespond($request->getId(), $result, $error);
    }

    /**
     * @param string $name
     * @return IManager
     * @throws IvsException
     */
    protected function createManager($name)
    {
        if (isset($this->config['manager'][$name])) {
            $args = $this->config['manager'][$name];
            if (is_array($args)) {
                $className = $args['class'];
            } else {
                $className = $args;
                $args      = null;
            }
            $manager = new $className($this, $args);
            return $manager;
        }
        throw new IvsException(IvsException::MANAGER_NOT_DEFINED, "Manager $name not defined");
    }
}
