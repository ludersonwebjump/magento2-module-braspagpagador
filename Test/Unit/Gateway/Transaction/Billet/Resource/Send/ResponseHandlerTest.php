<?php

namespace Webjump\BraspagPagador\Test\Unit\Gateway\Transaction\Billet\Resource\Send;

use Webjump\BraspagPagador\Gateway\Transaction\Billet\Resource\Send\ResponseHandler;

class ResponseHandlerTest extends \PHPUnit_Framework_TestCase
{
	private $handler;

    public function setUp()
    {
    	$this->handler = new ResponseHandler();
    }

    public function tearDown()
    {

    }

    public function testHandle()
    {
    	$responseMock = $this->getMock('Webjump\Braspag\Pagador\Transaction\Api\Billet\Send\ResponseInterface');

    	$responseMock->expects($this->once())
    	    ->method('getPaymentPaymentId')
    	    ->will($this->returnValue(123));

    	$paymentMock = $this->getMockBuilder('Magento\Sales\Model\Order\Payment')
    		->disableOriginalConstructor()
    	    ->getMock();


    	$paymentDataObjectMock = $this->getMockBuilder('Magento\Payment\Gateway\Data\PaymentDataObjectInterface')
    		->setMethods(['getOrder', 'getShippingAddress', 'getPayment'])
    		->getMock();

    	$paymentDataObjectMock->expects($this->once())
    	    ->method('getPayment')
    	    ->will($this->returnValue($paymentMock));

    	$paymentMock->expects($this->once())
    	    ->method('setTransactionId')
    	    ->with(123);

    	$handlingSubject = ['payment' => $paymentDataObjectMock];
    	$response = ['response' => $responseMock];

    	$this->handler->handle($handlingSubject, $response);
    }
}