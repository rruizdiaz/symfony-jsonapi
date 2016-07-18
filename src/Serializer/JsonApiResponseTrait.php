<?php

namespace NilPortugues\Symfony\JsonApiBundle\Serializer;

use NilPortugues\Api\JsonApi\Http\Response\BadRequest;
use NilPortugues\Api\JsonApi\Http\Response\ResourceCreated;
use NilPortugues\Api\JsonApi\Http\Response\ResourceDeleted;
use NilPortugues\Api\JsonApi\Http\Response\ResourceNotFound;
use NilPortugues\Api\JsonApi\Http\Response\ResourceProcessing;
use NilPortugues\Api\JsonApi\Http\Response\ResourceUpdated;
use NilPortugues\Api\JsonApi\Http\Response\Response;
use NilPortugues\Api\JsonApi\Http\Response\UnprocessableEntity;
use NilPortugues\Api\JsonApi\Http\Response\UnsupportedAction;
use NilPortugues\Api\JsonApi\Server\Errors\Error;
use NilPortugues\Api\JsonApi\Server\Errors\ErrorBag;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;

trait JsonApiResponseTrait
{
    /**
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    protected function addHeaders(ResponseInterface $response)
    {
        return $response;
    }

    /**
     * @param string $message
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function errorResponse($message)
    {
        $error = new Error('Bad Request', $message);

        return $this->createResponse(new BadRequest(new ErrorBag([$error])));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourceCreatedResponse($json)
    {
        return $this->createResponse(new ResourceCreated($json));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourceDeletedResponse($json)
    {
        return $this->createResponse(new ResourceDeleted($json));
    }

    /**
     * @param string $message
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourceNotFoundResponse($message)
    {
    	$error = new Error('Not Found', $message);
    	
        return $this->createResponse(new ResourceNotFound(new ErrorBag([$error])));
    }

    /**
     * @param string $message
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourcePatchErrorResponse($message)
    {
    	$error = new Error('Unprocessable Entity', $message);    	 

        return $this->createResponse(new UnprocessableEntity(new ErrorBag([$error])));
    }

    /**
     * @param string $message
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourcePostErrorResponse($message)
    {
        $error = new Error('Unprocessable Entity', $message);

        return $this->createResponse(new UnprocessableEntity(new ErrorBag([$error])));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourceProcessingResponse($json)
    {
        return $this->createResponse(new ResourceProcessing($json));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourceUpdatedResponse($json)
    {
        return $this->createResponse(new ResourceUpdated($json));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function response($json)
    {
        return $this->createResponse(new Response($json));
    }

    /**
     * @param string $message
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unsupportedActionResponse($message)
    {
        $error = new Error('Unsupported Action', $message);

        return $this->createResponse(new UnsupportedAction(new ErrorBag([$error])));
    }

    /**
     * @param $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function createResponse($data)
    {
        return (new HttpFoundationFactory())->createResponse($this->addHeaders($data));
    }
}
