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

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\CartTotalRepositoryInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mageplaza\ExtraFee\Helper\Data;

/**
 * Class SelectOptions
 * @package Mageplaza\ExtraFeeGraphQl\Model\Resolver
 */
class Segments implements ResolverInterface
{
    /**
     * Cart total repository.
     *
     * @var CartTotalRepositoryInterface
     */
    protected $cartTotalRepository;

    /**
     * @var Data
     */
    protected $helperData;

    /**
     * Segments constructor.
     * @param CartTotalRepositoryInterface $cartTotalRepository
     * @param Data $helperData
     */
    public function __construct(
        CartTotalRepositoryInterface $cartTotalRepository,
        Data $helperData
    ) {
        $this->cartTotalRepository = $cartTotalRepository;
        $this->helperData          = $helperData;
    }

    /**
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|\Magento\Framework\GraphQl\Query\Resolver\Value|mixed
     * @throws LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!isset($value['model'])) {
            throw new LocalizedException(__('"model" value should be specified'));
        }

        $segments = [];

        if ($this->helperData->isEnabled()) {
            /** @var Quote $quote */
            $quote  = $value['model'];
            $totals = $this->cartTotalRepository->get($quote->getId());

            $currencyCode = $quote->getQuoteCurrencyCode();

            foreach ($totals->getTotalSegments() as $segment) {
                if (strpos($segment->getCode(), 'mp_extra_fee_rule') !== false) {
                    $data             = $segment->getData();
                    $data['currency'] = $currencyCode;
                    $segments[]       = $data;
                }
            }
        }

        return $segments;
    }
}
