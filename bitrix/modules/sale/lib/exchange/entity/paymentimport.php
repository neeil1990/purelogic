<?php
namespace Bitrix\Sale\Exchange\Entity;

use Bitrix\Sale;
use Bitrix\Sale\Internals;
use Bitrix\Sale\Order;
use Bitrix\Sale\Payment;
use Bitrix\Sale\Exchange;
use Bitrix\Sale\Exchange\EntityType;
use Bitrix\Main;
use Bitrix\Main\Error;

class PaymentImport extends EntityImport
{
    /**
     * @param Internals\Entity $entity
     * @throws Main\ArgumentException
     */
    public function setEntity(Internals\Entity $entity)
    {
        if(!($entity instanceof Payment))
            throw new Main\ArgumentException("Entity must be instanceof Payment");

        $this->entity = $entity;
    }

    /**
     * @param array $fields
     * @return Sale\Result
     */
    protected function checkFields(array $fields)
    {
        $result = new Sale\Result();

        if(intval($fields['ORDER_ID'])<=0 && !$this->isLoadedParentEntity())
        {
            $result->addError(new Error('ORDER_ID is not defined',''));
        }

        return $result;
    }

    /**
     *
     */
    public function save()
    {
        /** @var Order $parentEntity */
        $parentEntity = $this->getParentEntity();
        $parentEntity->save();
    }

    /**
     * @param array $params
     * @return Sale\Result
     * @throws Main\ArgumentException
     */
    public function add(array $params)
    {
        if(!$this->isLoadedParentEntity())
        {
            throw new Main\ArgumentException("order is not loaded");
        }

        /** @var Order $parentEntity */
        $parentEntity = $this->getParentEntity();

        $paySystemId = $this->settings->paySystemIdFor($this->getOwnerTypeId());
        $paySystem = Sale\PaySystem\Manager::getObjectById($paySystemId);

        $paymentCollection = $parentEntity->getPaymentCollection();

        /** @var Sale\PaymentCollection $paymentCollection */
        $payment = $paymentCollection->createItem($paySystem);

        $fields = $params['TRAITS'];
        /** @var Payment $payment */
		$result = $payment->setFields($fields);

        if($result->isSuccess())
        {
            $this->setEntity($payment);
        }

        return $result;
    }

    /**
     * @param array $params
     * @return Sale\Result
     */
    public function update(array $params)
    {
    	/** @var Sale\Payment $payment*/
        $payment = $this->getEntity();

        $criterion = $this->getCurrentCriterion($this->getEntity());

        $fields = $params['TRAITS'];
        if(!$criterion->equals($fields))
        {
            unset(
                $fields['SUM'],
                $fields['COMMENTS'],
                $fields['PAY_VOUCHER_DATE'],
                $fields['PAY_VOUCHER_NUM']
            );
        }
        $result = $payment->setFields($fields);

        return $result;
    }

    /**
     * @param array|null $params
     * @return Sale\Result
     */
    public function delete(array $params = null)
    {
        /** @var Payment $entity */
        $entity = $this->getEntity();
        $result = $entity->delete();
        if($result->isSuccess())
        {
            $this->setCollisions(Exchange\EntityCollisionType::OrderPaymentDeleted, $this->getParentEntity());
        }
        else
        {
            $this->setCollisions(Exchange\EntityCollisionType::OrderPaymentDeletedError, $this->getParentEntity(), implode(',', $result->getErrorMessages()));
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function getExternalFieldName()
    {
        return 'EXTERNAL_PAYMENT';
    }

    public function load(array $fields)
    {
        $r = $this->checkFields($fields);
        if(!$r->isSuccess())
        {
            throw new Main\ArgumentException('ORDER_ID is not defined');
        }

        if(!$this->isLoadedParentEntity() && !empty($fields['ORDER_ID']))
        {
            $this->setParentEntity(Order::load($fields['ORDER_ID']));
        }

        if($this->isLoadedParentEntity())
        {
            /** @var Order $parentEntity */
            $parentEntity = $this->getParentEntity();

            if(!empty($fields['ID']))
            {
                $payment = $parentEntity->getPaymentCollection()->getItemById($fields['ID']);
            }

            /** @var Payment $payment*/
            if(!empty($payment))
            {
                $this->setEntity($payment);
            }
            else
            {
                $this->setExternal();
            }
        }
    }

    /**
     * @param array $fields
     */
    public function refreshData(array $fields)
    {
        /** @var Sale\Payment $entity */
        $entity = $this->getEntity();
        if(!empty($entity) && $entity->isPaid())
        {
            if($fields['PAID'] == 'N')
                $entity->setField('PAID', 'N');
        }
    }

    /**
     * @param Internals\Entity $payment
     * @return int
     * @throws Main\ArgumentException
     */
    public static function resolveEntityTypeId(Internals\Entity $payment)
    {
        if(!($payment instanceof Payment))
            throw new Main\ArgumentException("Entity must be instanceof Payment");

        $paySystem = $payment->getPaySystem();
        $type = $paySystem->getField('IS_CASH');
        switch($type)
        {
            case 'Y':
                $resolveType = EntityType::PAYMENT_CASH;
                break;
            case 'N':
                $resolveType = EntityType::PAYMENT_CASH_LESS;
                break;
            case 'A':
                $resolveType = EntityType::PAYMENT_CARD_TRANSACTION;
                break;
            default;
                $resolveType = EntityType::UNDEFINED;
        }
        return $resolveType;
    }

    /**
     * @param Exchange\ICriterionOrder|Exchange\ICriterionPayment|Exchange\ICriterionProfile|Exchange\ICriterionShipment $criterion
     * @throws Main\ArgumentException
     */
    public function loadCriterion($criterion)
    {
        if(!($criterion instanceof Exchange\ICriterionPayment))
            throw new Main\ArgumentException("Criterion must be instanceof ICriterionPayment");

        $this->loadCriterion = $criterion;
    }

    /**
     * @param Exchange\ICollisionPayment $collision
     * @throws Main\ArgumentException
     */
    public function loadCollision($collision)
    {
        if(!($collision instanceof Exchange\ICollisionPayment))
            throw new Main\ArgumentException("Collision must be instanceof ICollisionPayment");

        $this->loadCollision = $collision;
    }
}

class PaymentCashImport extends PaymentImport
{
    public function __construct($parentEntityContext = null)
    {
        parent::__construct($parentEntityContext);
    }

    public function getOwnerTypeId()
    {
        return EntityType::PAYMENT_CASH;
    }
}

class PaymentCashLessImport extends PaymentImport
{
    public function __construct($parentEntityContext = null)
    {
        parent::__construct($parentEntityContext);
    }

    public function getOwnerTypeId()
    {
        return EntityType::PAYMENT_CASH_LESS;
    }
}

class PaymentCardImport extends PaymentImport
{
    public function __construct($parentEntityContext = null)
    {
        parent::__construct($parentEntityContext);
    }

    public function getOwnerTypeId()
    {
        return EntityType::PAYMENT_CARD_TRANSACTION;
    }
}