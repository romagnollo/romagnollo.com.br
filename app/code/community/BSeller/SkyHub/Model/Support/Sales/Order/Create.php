<?php
/**
 * BSeller Platform | B2W - Companhia Digital
 *
 * Do not edit this file if you want to update this module for future new versions.
 *
 * @category  BSeller
 * @package   BSeller_SkyHub
 *
 * @copyright Copyright (c) 2018 B2W Digital - BSeller Platform. (http://www.bseller.com.br)
 *
 * Access https://ajuda.skyhub.com.br/hc/pt-br/requests/new for questions and other requests.
 */

class BSeller_SkyHub_Model_Support_Sales_Order_Create
{

    use BSeller_SkyHub_Trait_Data,
        BSeller_SkyHub_Trait_Config,
        BSeller_SkyHub_Trait_Customer,
        BSeller_SkyHub_Trait_Address;


    const CARRIER_PREFIX = 'bseller_skyhub_';

    /** @var Mage_Core_Model_Store */
    private $store;

    /** @var array */
    private $data = array();

    /** @var BSeller_SkyHub_Model_Adminhtml_Sales_Order_Create */
    protected $creator;

    const CODE_REGION_EMPTY = 'N/A';

    const CODE_REGION_DEFAULT = 'SP';

    const CODE_COUNTRY_DEFAULT = 'BR';
    /**
     * BSeller_SkyHub_Model_Support_Sales_Order_Create constructor.
     *
     * @param null|Mage_Core_Model_Store $store
     *
     * @throws Mage_Core_Model_Store_Exception
     */
    public function __construct($store = null)
    {
        $data = array(
            'session' => array(
                'store_id' => $this->getStore($store)->getId(),
            ),
            'order'   => array(
                'currency' => $this->getStore($store)->getCurrentCurrencyCode(),
            ),
        );

        $this->merge($data);
    }


    /**
     * @param Varien_Object $order
     * @return $this
     */
    public function setOrderInfo(Varien_Object $order)
    {
        $data = array(
            'order' => array(
                'increment_id'      => $order->getData('increment_id'),
                'send_confirmation' => $order->getData('send_confirmation')
            ),
        );

        $this->merge($data);

        return $this;
    }


    /**
     * @param array $customData
     * @return $this
     */
    public function setCustomData(array $customData)
    {
        $data   = array(
            'custom' => $customData
        );

        $this->merge($data);

        return $this;
    }

    
    /**
     * @param null|string $comment
     *
     * @return $this
     */
    public function setComment($comment = null)
    {
        $data = array(
            'order' => array(
                'comment' => array(
                    'customer_note' => $comment,
                )
            ),
        );

        $this->merge($data);

        return $this;
    }


    /**
     * @param BSeller_SkyHub_Model_Catalog_Product $product
     *
     * @return $this
     */
    public function addProduct(array $data)
    {
        $productId = (int)  $this->arrayExtract($data, 'product_id');
        $qty       = (float) $this->arrayExtract($data, 'qty');

        if (!$productId) {
            return $this;
        }

        $data = array(
            'products' => array(
                array(
                    'product' => $data,
                    'config'  => array(
                        'qty' => $qty ? $qty : 1,
                    ),
                )
            )
        );

        $this->merge($data);

        return $this;
    }


    /**
     * @param string $method
     *
     * @return $this
     */
    public function setPaymentMethod($method = 'checkmo')
    {
        $data = array(
            'payment' => array(
                'method' => $method,
            )
        );

        $this->merge($data);

        return $this;
    }


    /**
     * @param float $discount
     *
     * @return $this
     */
    public function setDiscountAmount($discount)
    {
        $data = array(
            'order' => array(
                'discount_amount' => (float) $discount,
            )
        );

        $this->merge($data);

        return $this;
    }


    /**
     * @param float $discount
     *
     * @return $this
     */
    public function setInterestAmount($discount)
    {
        $data = array(
            'order' => array(
                'interest' => (float) $discount,
            )
        );

        $this->merge($data);

        return $this;
    }


    /**
     * @param string $title
     * @param float  $cost
     *
     * @return $this
     */
    public function setShippingMethod($title = null, $carrier = null, $cost = 0.0000)
    {
        /** @var string $title */
        $title = $this->getShippingTitle($title, $carrier);

        /** @var string $methodCode */
        $methodCode = $this->helper()->normalizeString($title);

        $data = array(
            'order' => array(
                'shipping_method'        => self::CARRIER_PREFIX.$methodCode,
                'shipping_method_code'   => $methodCode,
                'shipping_title'         => $title,
                'shipping_carrier'       => $carrier,
                'shipping_cost'          => (float) $cost,
            )
        );

        $this->merge($data);

        return $this;
    }

    /**
     * @param $title
     * @param $carrier
     *
     * @return string
     */
    protected function getShippingTitle($title, $carrier)
    {
        /**
         * Comparing string to a specific marketplace (Magazine Luiza)
         */
        if(!$title || $this->helper()->normalizeString($title) == 'nao_informado'){
            $title = $carrier;
        }

        if (!$title) {
            return 'Standard';
        }

        return "{$carrier} - {$title}";
    }


    /**
     * @param Mage_Customer_Model_Customer $customer
     *
     * @return $this
     */
    public function setCustomer(Mage_Customer_Model_Customer $customer)
    {
        $data = array(
            'order' => array(
                'account' => array(
                    'group_id' => $customer->getGroupId(),
                    'email'    => $customer->getEmail()
                )
            ),
            'session' => array(
                'customer_id' => $customer->getId()
            )
        );

        $this->merge($data);

        return $this;
    }


    /**
     * @param string        $type
     * @param Varien_Object $address
     *
     * @return $this
     */
    public function addOrderAddress($type, Varien_Object $address, $channel = null)
    {
        $fullname = trim($address->getData('full_name'));

        /** @var Varien_Object $nameObject */
        $nameObject = $this->breakName($fullname);

        $addressSize = $this->getAddressSizeConfig();

        $this->treatAddressByChannel($address, $channel);

        $simpleAddressData = $this->formatAddress($address, $addressSize);

        $data = array(
            'order' => array(
                "{$type}_address" => array(
                    'customer_address_id' => $address->getData('customer_address_id'),
                    'prefix'              => '',
                    'firstname'           => $nameObject->getData('firstname'),
                    'middlename'          => $nameObject->getData('middlename'),
                    'lastname'            => $nameObject->getData('lastname'),
                    'suffix'              => '',
                    'company'             => '',
                    'street'              => $simpleAddressData,
                    'city'                => $address->getData('city'),
                    'country_id'          => $address->getData('country'),
                    'region'              => $this->getRegion($address),
                    'region_id'           => '',
                    'postcode'            => $address->getData('postcode'),
                    'telephone'           => $this->formatPhone($address->getData('phone')),
                    'fax'                 => $address->getData('secondary_phone'),
                )
            )
        );

        $this->merge($data);

        return $this;
    }

    /**
     * @param Varien_Object $address
     *
     * @return mixed|string
     */
    public function getRegion(Varien_Object $address)
    {
        if ($this->_prepareString($address->getData('region')) == $this->_prepareString(self::CODE_REGION_EMPTY)) {
            return self::CODE_REGION_DEFAULT;
        }

        return $address->getData('region');
    }

    /**
     * @param Varien_Object $address
     *
     * @return mixed
     */
    public function getRegionId(Varien_Object $address)
    {
        /** @var Mage_Directory_Model_Region $directory */
        $directory = Mage::getModel("directory/region");
        $directory->loadByCode($this->getRegion($address), self::CODE_COUNTRY_DEFAULT);
        if (!$directory->hasData()) {
            $directory->loadByCode(self::CODE_REGION_DEFAULT, self::CODE_COUNTRY_DEFAULT);
        }

        return $directory->getRegionId();
    }

    /**
     * @param $value
     * @return string
     */
    protected function _prepareString($value)
    {
        return strtolower(trim($value));
    }

    /**
     * @return $this
     */
    public function reset()
    {
        $this->creator = null;
        $this->data    = array();
        $this->store   = null;

        return $this;
    }


    /**
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote()
    {
        return $this->getOrderCreator()->getQuote();
    }


    /**
     * @return $this
     */
    protected function resetQuote()
    {
        $this->getQuote()
             ->setTotalsCollectedFlag(false);

        return $this;
    }


    /**
     * @return BSeller_SkyHub_Model_Adminhtml_Session_Quote
     */
    protected function getSession()
    {
        /** @var BSeller_SkyHub_Model_Adminhtml_Session_Quote $session */
        $session = Mage::getSingleton('bseller_skyhub/adminhtml_session_quote');
        return $session;
    }


    /**
     * Retrieve order create model
     *
     * @return  BSeller_SkyHub_Model_Adminhtml_Sales_Order_Create
     */
    protected function getOrderCreator()
    {
        if (!$this->creator) {
            $this->creator = Mage::getModel('bseller_skyhub/adminhtml_sales_order_create');
        }

        return $this->creator;
    }


    /**
     * Initialize order creation session data
     *
     * @param array $data
     *
     * @return $this
     */
    protected function initSession($data)
    {
        /* Get/identify customer */
        if (!empty($data['customer_id'])) {
            $this->getSession()->setCustomerId((int) $this->arrayExtract($data, 'customer_id'));
        }

        /* Get/identify store */
        if (!empty($data['store_id'])) {
            $this->getSession()->setStoreId((int) $this->arrayExtract($data, 'store_id'));
        }

        return $this;
    }


    /**
     * Create order.
     *
     * @return Mage_Sales_Model_Order|null
     *
     * @throws Mage_Core_Exception
     * @throws Mage_Core_Model_Store_Exception
     */
    public function create()
    {
        $orderData = $this->data;
        $order     = null;

        if (!empty($orderData)) {
            $this->initSession($this->arrayExtract($orderData, 'session'));

            $this->processQuote($orderData);
            $payment = $this->arrayExtract($orderData, 'payment');

            if (!empty($payment)) {
                $this->getOrderCreator()
                     ->setPaymentData($payment);

                $this->getQuote()
                     ->getPayment()
                     ->addData($payment);
            }

            /** This can be necessary. */
            // $this->processProductOptions();

            Mage::app()->getStore()->setConfig(Mage_Sales_Model_Order::XML_PATH_EMAIL_ENABLED, "0");

            Mage::dispatchEvent(
                'bseller_skyhub_order_import_before',
                array(
                    'order'      => $order,
                    'order_data' => $orderData,
                    'creator'    => $this,
                )
            );

            /** @var Mage_Sales_Model_Order $order */
            $order = $this->getOrderCreator()
                          ->importPostData($this->arrayExtract($orderData, 'order'))
                          ->createOrder();

            Mage::dispatchEvent(
                'bseller_skyhub_order_import_success',
                array(
                    'order'      => $order,
                    'order_data' => $orderData,
                )
            );

            $this->clearSessionQuote();

            Mage::unregister('rule_data');
        }

        return $order;
    }


    /**
     * @return $this
     */
    protected function processProductOptions()
    {
        /**
         * @var int                        $productId
         * @var Mage_Catalog_Model_Product $product
         */
        $products = $this->arrayExtract($this->data, 'products');

        foreach ($products as $productId => $product) {
            $item = $this->getOrderCreator()->getQuote()->getItemByProduct($product);

            $options = array(
                array(
                    'product' => $product,
                    'code'    => 'option_ids',
                    'value'   => '5',
                    // Option id goes here. If more options, then comma separate
                ),
                array(
                    'product' => $product,
                    'code'    => 'option_5',
                    'value'   => 'Some value here',
                )
            );

            /** @var array $option */
            foreach ($options as $option) {
                $item->addOption(new Varien_Object($option));
            }
        }

        return $this;
    }


    /**
     * @param array $data
     *
     * @return $this
     *
     * @throws Mage_Core_Exception
     */
    protected function processQuote($data = array())
    {
        $order  = (array) $this->arrayExtract($data, 'order', array());
        $custom = (array) $this->arrayExtract($data, 'custom', array());
        
        /* Saving order data */
        if (!empty($order)) {
            $this->getOrderCreator()->importPostData($order);
            $this->getQuote()
                 ->setReservedOrderId($this->arrayExtract($order, 'increment_id'));
        }

        // adds custom data to quote
        if (!empty($custom)) {
            $this->getQuote()->addData($custom);
        }
        
        // $this->getOrderCreator()->getBillingAddress();
        // $this->getOrderCreator()->getShippingAddress();

        /* Just like adding products from Magento admin grid */
        $products = (array) $this->arrayExtract($data, 'products', array());

        /** @var array $product */
        foreach ($products as $item) {
            $this->getOrderCreator()->addProductByData($item);
        }

        $this->registerDiscount($order);
        $this->registerInterest($order);

        $shippingMethod       = (string) $this->arrayExtract($data, 'order/shipping_method');
        $shippingMethodCode   = (string) $this->arrayExtract($data, 'order/shipping_method_code');
        $shippingCarrier      = (string) $this->arrayExtract($data, 'order/shipping_carrier');
        $shippingTitle        = (string) $this->arrayExtract($data, 'order/shipping_title');
        $shippingAmount       = (float) $this->arrayExtract($data, 'order/shipping_cost');

        $this->getQuote()
             ->setFixedShippingAmount($shippingAmount)
             ->setFixedShippingMethod($shippingMethod)
             ->setFixedShippingMethodCode($shippingMethodCode)
             ->setFixedShippingCarrier($shippingCarrier)
             ->setFixedShippingTitle($shippingTitle);

        /* Collect shipping rates */
        $this->resetQuote()
             ->getOrderCreator()
             ->collectShippingRates();

        /* Add payment data */
        $payment = $this->arrayExtract($data, 'payment', array());
        if (!empty($payment)) {
            $this->getOrderCreator()
                 ->getQuote()
                 ->getPayment()
                 ->addData($payment);
        }

        $this->getOrderCreator()
             ->initRuleData()
             ->saveQuote();

        if (!empty($payment)) {
            $this->getOrderCreator()
                 ->getQuote()
                 ->getPayment()
                 ->addData($payment);
        }

        return $this;
    }

    /**
     * Remove quote from session
     *
     * @return bool
     */
    public function removeSessionQuote()
    {
        try {
            $quote = $this->getSession()->getQuote();
            $this->clearSessionQuote();

            if (!$quote->getId()) {
                return false;
            }

            $quote->delete();
        } catch (Mage_Exception $e) {
            Mage::logException($e);
            return false;
        }

        return true;
    }


    /**
     * Reset session quote data
     */
    public function clearSessionQuote()
    {
        $this->getSession()->clear();
    }
    

    /**
     * @param array $data
     *
     * @return $this
     * @throws Mage_Core_Exception
     */
    protected function registerDiscount(array $data)
    {
        $key = 'bseller_skyhub_discount_amount';
        if (Mage::registry($key)) {
            Mage::unregister($key);
        }

        $discount = (float) $this->arrayExtract($data, 'discount_amount');

        if (!$discount) {
            return $this;
        }

        Mage::register($key, $discount, true);

        return $this;
    }


    /**
     * @param array $data
     *
     * @return $this
     * @throws Mage_Core_Exception
     */
    protected function registerInterest(array $data)
    {
        $key = 'bseller_skyhub_interest';
        if (Mage::registry($key)) {
            Mage::unregister($key);
        }

        $interest = (float) $this->arrayExtract($data, 'interest');

        if (!$interest) {
            return $this;
        }

        Mage::register($key, $interest, true);

        return $this;
    }


    /**
     * @param array $data
     *
     * @return $this
     */
    protected function merge(array $data = array())
    {
        $this->data = array_merge_recursive($this->data, $data);

        return $this;
    }


    /**
     * @return Mage_Core_Model_Store
     *
     * @throws Mage_Core_Model_Store_Exception
     */
    protected function getStore($store = null)
    {
        if (empty($store)) {
            $store = null;
        }

        if (!$this->store) {
            $this->store = Mage::app()->getStore($store);
        }

        if ($this->store->isAdmin()) {
            $this->store = Mage::app()->getDefaultStoreView();
        }

        return $this->store;
    }


    /**
     * @return BSeller_SkyHub_Helper_Data
     */
    protected function helper()
    {
        /** @var BSeller_SkyHub_Helper_Data $helper */
        $helper = Mage::helper('bseller_skyhub');
        return $helper;
    }
}
