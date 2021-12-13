<?php 

namespace Bluethink\CustomApi\Model\Response;

use Bluethink\CustomApi\Api\Response\ResponseInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class Response extends AbstractExtensibleModel implements ResponseInterface 
{
    /*
    * @var string
    */
    protected $message;

    /*
    * @var bool
    */
    protected $error;

    /**
    * {@inheritdoc}
    */
    public function getMessage()
    {
        return $this->getData(self::DATA_MESSAGE);
    }

    /**
    * {@inheritdoc}
    */
    public function setMessage($message)
    {
        return $this->setData(self::DATA_MESSAGE, $message);
    }

    /**
    * {@inheritdoc}
    */
    public function getError()
    {
        return $this->getData(self::DATA_ERROR);
    }

    /**
    * {@inheritdoc}
    */
    public function setError($error)
    {
        return $this->setData(self::DATA_ERROR, $error);
    }
}