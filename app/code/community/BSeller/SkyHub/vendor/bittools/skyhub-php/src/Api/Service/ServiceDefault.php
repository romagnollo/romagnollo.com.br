<?php
/**
 * B2W Digital - Companhia Digital
 *
 * Do not edit this file if you want to update this SDK for future new versions.
 * For support please contact the e-mail bellow:
 *
 * sdk@e-smart.com.br
 *
 * @category  SkuHub
 * @package   SkuHub
 *
 * @copyright Copyright (c) 2018 B2W Digital - BSeller Platform. (http://www.bseller.com.br).
 *
 * @author    Tiago Sampaio <tiago.sampaio@e-smart.com.br>
 */

namespace SkyHub\Api\Service;

use SkyHub\Api\Handler\Response\HandlerInterfaceException;
use SkyHub\Api\Handler\Response\HandlerInterfaceSuccess;

class ServiceDefault extends ServiceAbstract
{
    /**
     * @param string       $uri
     * @param array|string $body
     * @param array        $options
     *
     * @return HandlerInterfaceException|HandlerInterfaceSuccess
     */
    public function post($uri, $body = null, array $options = [])
    {
        return $this->request(self::REQUEST_METHOD_POST, $uri, $body, $options);
    }

    /**
     * @param string $uri
     * @param string $body
     * @param array  $options
     *
     * @return HandlerInterfaceException|HandlerInterfaceSuccess
     */
    public function put($uri, $body = null, array $options = [])
    {
        return $this->request(self::REQUEST_METHOD_PUT, $uri, $body, $options);
    }


    /**
     * @param string $uri
     * @param string $body
     * @param array  $options
     *
     * @return HandlerInterfaceException|HandlerInterfaceSuccess
     */
    public function patch($uri, $body = null, array $options = [])
    {
        return $this->request(self::REQUEST_METHOD_PATCH, $uri, $body, $options);
    }

    /**
     * @param string $uri
     * @param array  $options
     *
     * @return HandlerInterfaceException|HandlerInterfaceSuccess
     */
    public function get($uri, array $options = [])
    {
        return $this->request(self::REQUEST_METHOD_GET, $uri, null, $options);
    }


    /**
     * @param string $uri
     * @param string $body
     * @param array  $options
     *
     * @return HandlerInterfaceException|HandlerInterfaceSuccess
     */
    public function delete($uri, $body = null, array $options = [])
    {
        return $this->request(self::REQUEST_METHOD_DELETE, $uri, $body, $options);
    }

    /**
     * @param $uri
     * @param $options
     *
     * @return HandlerInterfaceException|HandlerInterfaceSuccess
     */
    public function head($uri, array $options = [])
    {
        return $this->request(self::REQUEST_METHOD_HEAD, $uri, null, $options);
    }
}
