<?php

namespace Meetanshi\Extension\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder;

class Actions extends Column
{
    /** Url path */
    const URL_PATH_EDIT = 'extension/post/edit';
    const URL_PATH_DELETE = 'extension/post/delete';

    /** @var UrlBuilder */
    protected $actionUrlBuilder;

    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;


    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlBuilder $actionUrlBuilder,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }


    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');

                $item[$name]['edit'] = [
                    'href' => $this->urlBuilder->getUrl($this->editUrl, ['id' => $item['id']]),
                    'label' => __('Edit')
                ];
                $item[$name]['delete'] = [
                    'href' => $this->urlBuilder->getUrl(self::URL_PATH_DELETE, ['id' => $item['id']]),
                    'label' => __('Delete'),
                    'confirm' => [
                        'title' => __('Delete this item?'),
                        'message' => __('Are you sure you wan\'t to delete this item record?')
                    ]
                ];

            }
        }

        return $dataSource;
    }
}
