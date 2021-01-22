<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Ui\Component\Control;

use Magento\Framework\AuthorizationInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Ui\Component\Control\Container;

/**
 * Represents split-button with pre-configured options
 * Provide an ability to show drop-down list with options clicking on the "Save" button
 *
 * @api
 */
class SaveSplitButton implements ButtonProviderInterface
{
    /**
     * Authorization
     *
     * @var AuthorizationInterface
     */
    private $authorization;

    /**
     * Target name
     *
     * @var string
     */
    private $targetName;

    /**
     * Acl resource
     *
     * @var string
     */
    private $aclResource;

    /**
     * Initialize button provider
     *
     * @param AuthorizationInterface $authorization
     * @param string $targetName
     * @param string $aclResource
     * @return void
     */
    public function __construct(
        AuthorizationInterface $authorization,
        string $targetName,
        string $aclResource
    ) {
        $this->authorization = $authorization;
        $this->targetName = $targetName;
        $this->aclResource = $aclResource;
    }

    /**
     * Retrieve button-specified settings
     *
     * @return mixed
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save &amp; Continue'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => $this->targetName,
                                'actionName' => 'save',
                                'params' => [
                                    // first param is redirect flag
                                    false,
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'class_name' => Container::SPLIT_BUTTON,
            'options' => $this->getOptions(),
            'sort_order' => 40,
            'disabled' => !$this->isAllowed()
        ];
    }

    /**
     * Retrieve button options
     *
     * @return mixed[]
     */
    private function getOptions(): array
    {
        $options = [
            [
                'label' => __('Save &amp; Close'),
                'data_attribute' => [
                    'mage-init' => [
                        'buttonAdapter' => [
                            'actions' => [
                                [
                                    'targetName' => $this->targetName,
                                    'actionName' => 'save',
                                    'params' => [
                                        // first param is redirect flag
                                        true,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'sort_order' => 10,
            ],
            [
                'label' => __('Save &amp; New'),
                'data_attribute' => [
                    'mage-init' => [
                        'buttonAdapter' => [
                            'actions' => [
                                [
                                    'targetName' => $this->targetName,
                                    'actionName' => 'save',
                                    'params' => [
                                        // first param is redirect flag, second is data that will be added to post
                                        // request
                                        true,
                                        [
                                            'redirect_to_new' => 1,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'sort_order' => 20,
            ],
        ];
        return $options;
    }

    /**
     * Check current user permission on resource and privilege
     *
     * @return  bool
     */
    private function isAllowed(): bool
    {
        return $this->authorization->isAllowed($this->aclResource);
    }
}
