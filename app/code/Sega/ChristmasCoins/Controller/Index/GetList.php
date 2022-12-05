<?php

namespace Sega\ChristmasCoins\Controller\Index;

use Sega\ChristmasCoins\Helper\Data;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class GetList implements HttpGetActionInterface
{

    private  $helper;
    private  $resultFactory;

    public function __construct(
        Data $helper,
        ResultFactory $resultFactory
    ) {
        $this->resultFactory = $resultFactory;
        $this->helper = $helper;
    }

    public function execute()
    {
        try {
            $response['userName'] = $this->helper->getCustomerName();
            $response['data'] = $this->helper->getList();
            $response['totalCoins'] = $this->helper->getCurrentCustomerTotalCoins();
            $response['success'] = true;
        } catch (\Exception $e) {
            $response['success'] = false;
            $response['errorMsg'] = __('Something wrong. Data not received.');
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($response);
    }
}
