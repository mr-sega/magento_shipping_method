<?php

namespace Meetanshi\Extension\Block\Adminhtml\Block\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;


class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get button data
     *
     * @return array
     */
        public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
//        return [
//            'label'          => __('Save'),
//            'class'          => 'save primary',
//            'data_attribute' => [
//                'mage-init'  => [
//                    'button' => [
//                        'event'  => 'save',
//                        'target' => '#edit_form',
//                    ],
//                ],
//                'form-role' => 'save',
//            ],
//            'sort_order'     => 90,
//        ];

}
