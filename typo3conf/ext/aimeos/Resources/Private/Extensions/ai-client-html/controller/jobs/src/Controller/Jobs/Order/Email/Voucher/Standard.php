<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018
 * @package Controller
 * @subpackage Order
 */


namespace Aimeos\Controller\Jobs\Order\Email\Voucher;


/**
 * Order voucher e-mail job controller.
 *
 * @package Controller
 * @subpackage Order
 */
class Standard
	extends \Aimeos\Controller\Jobs\Base
	implements \Aimeos\Controller\Jobs\Iface
{
	private $couponId;


	/**
	 * Returns the localized name of the job.
	 *
	 * @return string Name of the job
	 */
	public function getName()
	{
		return $this->getContext()->getI18n()->dt( 'controller/jobs', 'Voucher related e-mails' );
	}


	/**
	 * Returns the localized description of the job.
	 *
	 * @return string Description of the job
	 */
	public function getDescription()
	{
		return $this->getContext()->getI18n()->dt( 'controller/jobs', 'Sends the e-mail with the voucher to the customer' );
	}


	/**
	 * Executes the job.
	 *
	 * @throws \Aimeos\Controller\Jobs\Exception If an error occurs
	 */
	public function run()
	{
		$context = $this->getContext();
		$config = $context->getConfig();

		/** controller/jobs/order/email/voucher/standard/limit-days
		 * Only send voucher e-mails of orders that were created in the past within the configured number of days
		 *
		 * The voucher e-mails are normally send immediately after the voucher
		 * has been ordered. This option prevents e-mails for old orders from
		 * being send in case anything went wrong or an update failed to avoid
		 * confusion of customers.
		 *
		 * @param integer Number of days
		 * @since 2018.07
		 * @category User
		 * @category Developer
		 * @see controller/jobs/order/email/voucher/standard/status
		 */
		$limit = $config->get( 'controller/jobs/order/email/voucher/standard/limit-days', 30 );
		$limitDate = date( 'Y-m-d H:i:s', time() - $limit * 86400 );

		$default = array(
			\Aimeos\MShop\Order\Item\Base::PAY_AUTHORIZED,
			\Aimeos\MShop\Order\Item\Base::PAY_RECEIVED,
		);

		/** controller/jobs/order/email/voucher/standard/status
		 * Only send e-mails containing voucher for these payment status values
		 *
		 * E-mail containing vouchers can be sent for these payment status values:
		 * * 0: deleted
		 * * 1: canceled
		 * * 2: refused
		 * * 3: refund
		 * * 4: pending
		 * * 5: authorized
		 * * 6: received
		 *
		 * @param integer Payment status constant
		 * @since 2018.07
		 * @category User
		 * @category Developer
		 * @see controller/jobs/order/email/voucher/standard/limit-days
		 */
		$status = (array) $config->get( 'controller/jobs/order/email/voucher/standard/status', $default );


		$client = \Aimeos\Client\Html\Email\Voucher\Factory::createClient( $context );
		$orderManager = \Aimeos\MShop\Factory::createManager( $context, 'order' );

		$orderSearch = $orderManager->createSearch();

		$param = array( \Aimeos\MShop\Order\Item\Status\Base::EMAIL_VOUCHER, '1' );
		$orderFunc = $orderSearch->createFunction( 'order.containsStatus', $param );

		$expr = array(
			$orderSearch->compare( '>=', 'order.mtime', $limitDate ),
			$orderSearch->compare( '==', 'order.statuspayment', $status ),
			$orderSearch->compare( '==', 'order.base.product.type', 'voucher' ),
			$orderSearch->compare( '==', $orderFunc, 0 ),
		);
		$orderSearch->setConditions( $orderSearch->combine( '&&', $expr ) );

		$start = 0;

		do
		{
			$items = $orderManager->searchItems( $orderSearch );

			$this->process( $client, $items, 1 );

			$count = count( $items );
			$start += $count;
			$orderSearch->setSlice( $start );
		}
		while( $count >= $orderSearch->getSliceSize() );
	}


	/**
	 * Saves the given coupon codes
	 *
	 * @param array $map Associative list of coupon codes as keys and reference Ids as values
	 */
	protected function addCouponCodes( array $map )
	{
		$couponId = $this->getCouponId();
		$manager = \Aimeos\MShop\Factory::createManager( $this->getContext(), 'coupon/code' );

		foreach( $map as $code => $ref )
		{
			$item = $manager->createItem()->setParentId( $couponId )
				->setCode( $code )->setRef( $ref )->setCount( null ); // unlimited

			$manager->saveItem( $item );
		}
	}


	/**
	 * Adds the status of the delivered e-mail for the given order ID
	 *
	 * @param string $orderId Unique order ID
	 * @param integer $value Status value
	 */
	protected function addOrderStatus( $orderId, $value )
	{
		$orderStatusManager = \Aimeos\MShop\Factory::createManager( $this->getContext(), 'order/status' );

		$statusItem = $orderStatusManager->createItem()->setParentId( $orderId )->setValue( $value )
			->setType( \Aimeos\MShop\Order\Item\Status\Base::EMAIL_VOUCHER );

		$orderStatusManager->saveItem( $statusItem );
	}


	/**
	 * Returns the delivery address item of the order
	 *
	 * @param \Aimeos\MShop\Order\Item\Base\Iface $orderBaseItem Order including address items
	 * @return \Aimeos\MShop\Order\Item\Base\Address\Iface Delivery or voucher address item
	 * @throws \Aimeos\MShop\Order\Exception If no address item is available
	 */
	protected function getAddressItem( \Aimeos\MShop\Order\Item\Base\Iface $orderBaseItem )
	{
		try
		{
			$addr = $orderBaseItem->getAddress( \Aimeos\MShop\Order\Item\Base\Address\Base::TYPE_DELIVERY );

			if( $addr->getEmail() == '' )
			{
				$payAddr = $orderBaseItem->getAddress( \Aimeos\MShop\Order\Item\Base\Address\Base::TYPE_PAYMENT );
				$addr->setEmail( $payAddr->getEmail() );
			}
		}
		catch( \Exception $e )
		{
			$addr = $orderBaseItem->getAddress( \Aimeos\MShop\Order\Item\Base\Address\Base::TYPE_PAYMENT );
		}

		return $addr;
	}


	/**
	 * Returns the coupon ID for the voucher coupon
	 *
	 * @return string Unique ID of the coupon item
	 */
	protected function getCouponId()
	{
		if( !isset( $this->couponId ) )
		{
			$manager = \Aimeos\MShop\Factory::createManager( $this->getContext(), 'coupon' );

			$search = $manager->createSearch()->setSlice( 0, 1 );
			$search->setConditions( $search->compare( '=~', 'coupon.provider', 'Voucher' ) );

			$items = $manager->searchItems( $search );

			if( ( $item = reset( $items ) ) === false ) {
				throw new \Aimeos\Controller\Jobs\Exception( 'No coupon provider "Voucher" available' );
			}

			$this->couponId = $item->getId();
		}

		return $this->couponId;
	}


	/**
	 * Returns an initialized view object
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context item
	 * @param string $site Site code
	 * @param string $currencyId Three letter ISO currency code
	 * @param string $langId ISO language code, maybe country specific
	 * @return \Aimeos\MW\View\Iface Initialized view object
	 */
	protected function getView( \Aimeos\MShop\Context\Item\Iface $context, $site, $currencyId, $langId )
	{
		$view = $context->getView();
		$params = ['locale' => $langId, 'site' => $site, 'currency' => $currencyId];

		$helper = new \Aimeos\MW\View\Helper\Param\Standard( $view, $params );
		$view->addHelper( 'param', $helper );

		$helper = new \Aimeos\MW\View\Helper\Config\Standard( $view, $context->getConfig() );
		$view->addHelper( 'config', $helper );

		$helper = new \Aimeos\MW\View\Helper\Translate\Standard( $view, $context->getI18n( $langId ) );
		$view->addHelper( 'translate', $helper );

		return $view;
	}


	/**
	 * Sends the voucher e-mail for the given orders
	 *
	 * @param \Aimeos\Client\Html\Iface $client HTML client object for rendering the voucher e-mails
	 * @param \Aimeos\MShop\Order\Item\Iface[] $items Associative list of order items with their IDs as keys
	 * @param integer $status Delivery status value
	 */
	protected function process( \Aimeos\Client\Html\Iface $client, array $items, $status )
	{
		$context = $this->getContext();
		$orderBaseManager = \Aimeos\MShop\Factory::createManager( $context, 'order/base' );

		foreach( $items as $id => $item )
		{
			try
			{
				$orderBaseItem = $orderBaseManager->load( $item->getBaseId() );
				$orderBaseItem->__sleep();

				$orderBaseItem = $this->createCoupons( $orderBaseItem );
				$orderBaseManager->store( $orderBaseItem );

				$this->sendEmails( $orderBaseItem, $client );
				$this->addOrderStatus( $id, $status );

				$str = sprintf( 'Sent voucher e-mails for order ID "%1$s"', $item->getId() );
				$context->getLogger()->log( $str, \Aimeos\MW\Logger\Base::INFO );
			}
			catch( \Exception $e )
			{
				$str = 'Error while trying to send voucher e-mail for order ID "%1$s": %2$s';
				$msg = sprintf( $str, $item->getId(), $e->getMessage() );
				$context->getLogger()->log( $msg );
			}
		}
	}


	/**
	 * Creates coupon codes for the bought vouchers
	 *
	 * @param \Aimeos\MShop\Order\Item\Base\Iface $orderBaseItem Complete order including addresses, products, services
	 */
	protected function createCoupons( \Aimeos\MShop\Order\Item\Base\Iface $orderBaseItem )
	{
		$map = [];
		$manager = \Aimeos\MShop\Factory::createManager( $this->getContext(), 'order/base/product/attribute' );

		foreach( $orderBaseItem->getProducts() as $pos => $orderProductItem )
		{
			if( $orderProductItem->getType() === 'voucher'
				&& $orderProductItem->getAttribute( 'coupon-code', 'coupon' ) === null
			) {
				$codes = [];

				for( $i = 0; $i < $orderProductItem->getQuantity(); $i++ )
				{
					$str = $i . getmypid() . microtime( true ) . $orderProductItem->getId();
					$code = substr( strtoupper( sha1( $str ) ), -8 );
					$map[$code] = $orderProductItem->getId();
					$codes[] = $code;
				}

				$item = $manager->createItem()->setCode( 'coupon-code' )->setType( 'coupon' )->setValue( $codes );
				$orderProductItem->setAttributeItem( $item );
			}
		}

		$this->addCouponCodes( $map );
		return $orderBaseItem;
	}


	/**
	 * Sends the voucher related e-mail for a single order
	 *
	 * @param \Aimeos\MShop\Order\Item\Base\Iface $orderBaseItem Complete order including addresses, products, services
	 * @param \Aimeos\Client\Html\Iface $client HTML client object for rendering the voucher e-mails
	 */
	protected function sendEmails( \Aimeos\MShop\Order\Item\Base\Iface $orderBaseItem, \Aimeos\Client\Html\Iface $client )
	{
		$context = $this->getContext();
		$addrItem = $this->getAddressItem( $orderBaseItem );
		$currencyId = $orderBaseItem->getPrice()->getCurrencyId();
		$langId = ( $addrItem->getLanguageId() ?: $orderBaseItem->getLocale()->getLanguageId() );

		$view = $this->getView( $context, $orderBaseItem->getSiteCode(), $currencyId, $langId );

		foreach( $orderBaseItem->getProducts() as $orderProductItem )
		{
			if( $orderProductItem->getType() === 'voucher'
				&& ( $codes = $orderProductItem->getAttribute( 'coupon-code', 'coupon' ) ) !== null
			) {
				foreach( (array) $codes as $code )
				{
					$message = $context->getMail()->createMessage();
					$view->addHelper( 'mail', new \Aimeos\MW\View\Helper\Mail\Standard( $view, $message ) );

					$view->extOrderProductItem = $orderProductItem;
					$view->extAddressItem = $addrItem;
					$view->extVoucherCode = $code;

					$client->setView( $view );
					$client->getHeader();
					$client->getBody();

					$context->getMail()->send( $view->mail() );
				}
			}
		}
	}
}
