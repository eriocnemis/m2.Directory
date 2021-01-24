<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Ui\Component\Control;

use Magento\Framework\AuthorizationInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Represents add button with pre-configured options
 *
 * @api
 */
class AddButton implements ButtonProviderInterface
{
    /**
     * Url builder
     *
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * Authorization
     *
     * @var AuthorizationInterface
     */
    private $authorization;

    /**
     * Add route path
     *
     * @var string
     */
    private $addRoutePath;

    /**
     * Sort order
     *
     * @var int
     */
    private $sortOrder;

    /**
     * Acl resource
     *
     * @var string
     */
    private $aclResource;

    /**
     * Initialize button provider
     *
     * @param UrlInterface $urlBuilder
     * @param AuthorizationInterface $authorization
     * @param string $aclResource
     * @param string $addRoutePath
     * @param int $sortOrder
     */
    public function __construct(
        UrlInterface $urlBuilder,
        AuthorizationInterface $authorization,
        string $aclResource,
        string $addRoutePath = '*/*/new',
        int $sortOrder = 0
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->authorization = $authorization;
        $this->addRoutePath = $addRoutePath;
        $this->aclResource = $aclResource;
        $this->sortOrder = $sortOrder;
    }

    /**
     * Retrieve button-specified settings
     *
     * @return mixed
     */
    public function getButtonData()
    {
        $data = [
            'label' => __('Add New'),
            'class' => 'primary',
            'url' => $this->urlBuilder->getUrl($this->addRoutePath),
            'sort_order' => $this->sortOrder,
            'disabled' => !$this->isAllowed()
        ];
        return $data;
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
