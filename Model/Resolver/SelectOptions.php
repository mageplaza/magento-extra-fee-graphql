<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_ExtraFeeGraphQl
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

declare(strict_types=1);

namespace Mageplaza\ExtraFeeGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\QuoteGraphQl\Model\Cart\GetCartForUser;
use Mageplaza\ExtraFee\Helper\Data;
use Mageplaza\ExtraFee\Model\Api\RuleManagement;

/**
 * Class SelectOptions
 * @package Mageplaza\ExtraFeeGraphQl\Model\Resolver
 */
class SelectOptions implements ResolverInterface
{
    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @var RuleManagement
     */
    protected $ruleManagement;

    /**
     * @var GetCartForUser
     */
    private $getCartForUser;

    /**
     * SelectOptions constructor.
     * @param Data $helperData
     * @param RuleManagement $ruleManagement
     * @param GetCartForUser $getCartForUser
     */
    public function __construct(
        Data $helperData,
        RuleManagement $ruleManagement,
        GetCartForUser $getCartForUser
    ) {
        $this->helperData     = $helperData;
        $this->ruleManagement = $ruleManagement;
        $this->getCartForUser = $getCartForUser;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        try {
            if (!$this->helperData->isEnabled()) {
                throw new GraphQlNoSuchEntityException(__('Extra Fee is disabled.'));
            }

            if ($this->helperData->versionCompare('2.3.3')) {
                $store = $context->getExtensionAttributes()->getStore();
                $quote = $this->getCartForUser->execute($args['cart_id'], $context->getUserId(), (int)$store->getId());
            } else {
                $quote = $this->getCartForUser->execute($args['cart_id'], $context->getUserId());
            }

            $totals = $this->ruleManagement->collectTotal($quote->getId(), $args['formData'], $args['area']);

            return $totals->getTotalSegments();
        } catch (\Exception $exception) {
            throw new GraphQlInputException(__($exception->getMessage()));
        }
    }
}
