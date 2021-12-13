<?php 

namespace Bluethink\CustomApi\Api\Response;

interface ResponseInterface
{
    const DATA_MESSAGE = 'message';
    const DATA_ERROR = 'error';

    /**
     * GET Message
     * @return string
     */
    public function getMessage();

    /**
     * SET Message
     * @param int $message
     * @return string
     */
    public function setMessage($message);

    /**
     * GET Error
     * @return bool
     */
    public function getError();

    /**
     * SET Error
     * @param bool $error
     * @return bool
     */
    public function setError($error);
}