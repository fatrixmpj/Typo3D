<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2018
 * @package Admin
 * @subpackage JQAdm
 */


namespace Aimeos\Admin\JQAdm\Customer;

sprintf( 'customer' ); // for translation


/**
 * Default implementation of customer JQAdm client.
 *
 * @package Admin
 * @subpackage JQAdm
 */
class Standard
	extends \Aimeos\Admin\JQAdm\Common\Admin\Factory\Base
	implements \Aimeos\Admin\JQAdm\Common\Admin\Factory\Iface
{
	/**
	 * Copies a resource
	 *
	 * @return string HTML output
	 */
	public function copy()
	{
		$view = $this->getView();
		$context = $this->getContext();

		try
		{
			if( ( $id = $view->param( 'id' ) ) === null ) {
				throw new \Aimeos\Admin\JQAdm\Exception( sprintf( 'Required parameter "%1$s" is missing', 'id' ) );
			}

			$manager = \Aimeos\MShop\Factory::createManager( $context, 'customer' );
			$view->item = $manager->getItem( $id, $this->getDomains() );

			$view->itemData = $this->toArray( $view->item, true );
			$view->itemSubparts = $this->getSubClientNames();
			$view->itemGroups = $this->getGroupItems();
			$view->itemBody = '';

			foreach( $this->getSubClients() as $idx => $client )
			{
				$view->tabindex = ++$idx + 1;
				$view->itemBody .= $client->copy();
			}
		}
		catch( \Aimeos\MShop\Exception $e )
		{
			$error = array( 'customer-item' => $context->getI18n()->dt( 'mshop', $e->getMessage() ) );
			$view->errors = $view->get( 'errors', [] ) + $error;
			$this->logException( $e );
		}
		catch( \Exception $e )
		{
			$error = array( 'customer-item' => $e->getMessage() . ', ' . $e->getFile() . ':' . $e->getLine() );
			$view->errors = $view->get( 'errors', [] ) + $error;
			$this->logException( $e );
		}

		return $this->render( $view );
	}


	/**
	 * Creates a new resource
	 *
	 * @return string HTML output
	 */
	public function create()
	{
		$view = $this->getView();
		$context = $this->getContext();

		try
		{
			$data = $view->param( 'item', [] );

			if( !isset( $view->item ) ) {
				$view->item = \Aimeos\MShop\Factory::createManager( $context, 'customer' )->createItem();
			}

			$data['customer.siteid'] = $view->item->getSiteId();

			$view->itemSubparts = $this->getSubClientNames();
			$view->itemGroups = $this->getGroupItems();
			$view->itemData = $data;
			$view->itemBody = '';

			foreach( $this->getSubClients() as $idx => $client )
			{
				$view->tabindex = ++$idx + 1;
				$view->itemBody .= $client->create();
			}
		}
		catch( \Aimeos\MShop\Exception $e )
		{
			$error = array( 'customer-item' => $context->getI18n()->dt( 'mshop', $e->getMessage() ) );
			$view->errors = $view->get( 'errors', [] ) + $error;
			$this->logException( $e );
		}
		catch( \Exception $e )
		{
			$error = array( 'customer-item' => $e->getMessage() . ', ' . $e->getFile() . ':' . $e->getLine() );
			$view->errors = $view->get( 'errors', [] ) + $error;
			$this->logException( $e );
		}

		return $this->render( $view );
	}


	/**
	 * Deletes a resource
	 *
	 * @return string|null HTML output
	 */
	public function delete()
	{
		$view = $this->getView();
		$context = $this->getContext();

		$manager = \Aimeos\MShop\Factory::createManager( $context, 'customer' );
		$manager->begin();

		try
		{
			if( ( $id = $view->param( 'id' ) ) === null ) {
				throw new \Aimeos\Admin\JQAdm\Exception( sprintf( 'Required parameter "%1$s" is missing', 'id' ) );
			}

			$view->item = $manager->getItem( $id, $this->getDomains() );

			foreach( $this->getSubClients() as $client ) {
				$client->delete();
			}

			$manager->saveItem( $view->item );
			$manager->deleteItem( $id );
			$manager->commit();

			$this->nextAction( $view, 'search', 'customer', null, 'delete' );
			return;
		}
		catch( \Aimeos\MShop\Exception $e )
		{
			$error = array( 'customer-item' => $context->getI18n()->dt( 'mshop', $e->getMessage() ) );
			$view->errors = $view->get( 'errors', [] ) + $error;
			$this->logException( $e );
		}
		catch( \Exception $e )
		{
			$error = array( 'customer-item' => $e->getMessage() . ', ' . $e->getFile() . ':' . $e->getLine() );
			$view->errors = $view->get( 'errors', [] ) + $error;
			$this->logException( $e );
		}

		$manager->rollback();

		return $this->search();
	}


	/**
	 * Returns a single resource
	 *
	 * @return string HTML output
	 */
	public function get()
	{
		$view = $this->getView();
		$context = $this->getContext();

		try
		{
			if( ( $id = $view->param( 'id' ) ) === null ) {
				throw new \Aimeos\Admin\JQAdm\Exception( sprintf( 'Required parameter "%1$s" is missing', 'id' ) );
			}

			$manager = \Aimeos\MShop\Factory::createManager( $context, 'customer' );

			$view->item = $manager->getItem( $id, $this->getDomains() );
			$view->itemGroups = $this->getGroupItems( $view->item );
			$view->itemSubparts = $this->getSubClientNames();
			$view->itemData = $this->toArray( $view->item );
			$view->itemBody = '';

			foreach( $this->getSubClients() as $idx => $client )
			{
				$view->tabindex = ++$idx + 1;
				$view->itemBody .= $client->get();
			}
		}
		catch( \Aimeos\MShop\Exception $e )
		{
			$error = array( 'customer-item' => $context->getI18n()->dt( 'mshop', $e->getMessage() ) );
			$view->errors = $view->get( 'errors', [] ) + $error;
			$this->logException( $e );
		}
		catch( \Exception $e )
		{
			$error = array( 'customer-item' => $e->getMessage() . ', ' . $e->getFile() . ':' . $e->getLine() );
			$view->errors = $view->get( 'errors', [] ) + $error;
			$this->logException( $e );
		}

		return $this->render( $view );
	}


	/**
	 * Saves the data
	 *
	 * @return string HTML output
	 */
	public function save()
	{
		$view = $this->getView();
		$context = $this->getContext();

		$manager = \Aimeos\MShop\Factory::createManager( $context, 'customer' );
		$manager->begin();

		try
		{
			$item = $this->fromArray( $view->param( 'item', [] ) );
			$view->item = $item->getId() ? $item : $manager->saveItem( $item );
			$view->itemBody = '';

			foreach( $this->getSubClients() as $client ) {
				$view->itemBody .= $client->save();
			}

			$manager->saveItem( clone $view->item );
			$manager->commit();

			$this->nextAction( $view, $view->param( 'next' ), 'customer', $view->item->getId(), 'save' );
			return;
		}
		catch( \Aimeos\Admin\JQAdm\Exception $e )
		{
			// fall through to create
		}
		catch( \Aimeos\MShop\Exception $e )
		{
			$error = array( 'customer-item' => $context->getI18n()->dt( 'mshop', $e->getMessage() ) );
			$view->errors = $view->get( 'errors', [] ) + $error;
			$this->logException( $e );
		}
		catch( \Exception $e )
		{
			$error = array( 'customer-item' => $e->getMessage() . ', ' . $e->getFile() . ':' . $e->getLine() );
			$view->errors = $view->get( 'errors', [] ) + $error;
			$this->logException( $e );
		}

		$manager->rollback();

		return $this->create();
	}


	/**
	 * Returns a list of resource according to the conditions
	 *
	 * @return string HTML output
	 */
	public function search()
	{
		$view = $this->getView();
		$context = $this->getContext();

		try
		{
			$total = 0;
			$params = $this->storeSearchParams( $view->param(), 'customer' );
			$manager = \Aimeos\MShop\Factory::createManager( $context, 'customer' );
			$search = $this->initCriteria( $manager->createSearch(), $params );

			$view->items = $manager->searchItems( $search, $this->getDomains(), $total );
			$view->filterAttributes = $manager->getSearchAttributes( true );
			$view->filterOperators = $search->getOperators();
			$view->total = $total;
			$view->itemBody = '';

			foreach( $this->getSubClients() as $client ) {
				$view->itemBody .= $client->search();
			}
		}
		catch( \Aimeos\MShop\Exception $e )
		{
			$error = array( 'customer-item' => $context->getI18n()->dt( 'mshop', $e->getMessage() ) );
			$view->errors = $view->get( 'errors', [] ) + $error;
			$this->logException( $e );
		}
		catch( \Exception $e )
		{
			$error = array( 'customer-item' => $e->getMessage() . ', ' . $e->getFile() . ':' . $e->getLine() );
			$view->errors = $view->get( 'errors', [] ) + $error;
			$this->logException( $e );
		}

		/** admin/jqadm/customer/template-list
		 * Relative path to the HTML body template for the customer list.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the result shown in the body of the frontend. The
		 * configuration string is the path to the template file relative
		 * to the templates directory (usually in admin/jqadm/templates).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating the HTML code
		 * @since 2016.04
		 * @category Developer
		 */
		$tplconf = 'admin/jqadm/customer/template-list';
		$default = 'customer/list-standard.php';

		return $view->render( $view->config( $tplconf, $default ) );
	}


	/**
	 * Returns the sub-client given by its name.
	 *
	 * @param string $type Name of the client type
	 * @param string|null $name Name of the sub-client (Default if null)
	 * @return \Aimeos\Admin\JQAdm\Iface Sub-client object
	 */
	public function getSubClient( $type, $name = null )
	{
		/** admin/jqadm/customer/decorators/excludes
		 * Excludes decorators added by the "common" option from the customer JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to remove a decorator added via
		 * "client/jqadm/common/decorators/default" before they are wrapped
		 * around the JQAdm client.
		 *
		 *  admin/jqadm/customer/decorators/excludes = array( 'decorator1' )
		 *
		 * This would remove the decorator named "decorator1" from the list of
		 * common decorators ("\Aimeos\Admin\JQAdm\Common\Decorator\*") added via
		 * "client/jqadm/common/decorators/default" to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2017.07
		 * @category Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/customer/decorators/global
		 * @see admin/jqadm/customer/decorators/local
		 */

		/** admin/jqadm/customer/decorators/global
		 * Adds a list of globally available decorators only to the customer JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap global decorators
		 * ("\Aimeos\Admin\JQAdm\Common\Decorator\*") around the JQAdm client.
		 *
		 *  admin/jqadm/customer/decorators/global = array( 'decorator1' )
		 *
		 * This would add the decorator named "decorator1" defined by
		 * "\Aimeos\Admin\JQAdm\Common\Decorator\Decorator1" only to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2017.07
		 * @category Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/customer/decorators/excludes
		 * @see admin/jqadm/customer/decorators/local
		 */

		/** admin/jqadm/customer/decorators/local
		 * Adds a list of local decorators only to the customer JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap local decorators
		 * ("\Aimeos\Admin\JQAdm\Customer\Decorator\*") around the JQAdm client.
		 *
		 *  admin/jqadm/customer/decorators/local = array( 'decorator2' )
		 *
		 * This would add the decorator named "decorator2" defined by
		 * "\Aimeos\Admin\JQAdm\Customer\Decorator\Decorator2" only to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2017.07
		 * @category Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/customer/decorators/excludes
		 * @see admin/jqadm/customer/decorators/global
		 */
		return $this->createSubClient( 'customer/' . $type, $name );
	}


	/**
	 * Returns the domain names whose items should be fetched too
	 *
	 * @return string[] List of domain names
	 */
	protected function getDomains()
	{
		/** admin/jqadm/customer/domains
		 * List of domain items that should be fetched along with the customer
		 *
		 * If you need to display additional content, you can configure your own
		 * list of domains (attribute, media, price, customer, text, etc. are
		 * domains) whose items are fetched from the storage.
		 *
		 * @param array List of domain names
		 * @since 2017.07
		 * @category Developer
		 */
		$domains = ['customer/address', 'customer/group', 'customer/property'];

		return $this->getContext()->getConfig()->get( 'admin/jqadm/customer/domains', $domains );
	}


	/**
	 * Returns the available group items
	 *
	 * @param \Aimeos\MShop\Customer\Item\Iface|null $item Customer item that should be updated
	 * @return \Aimeos\MShop\Customer\Item\Group\Iface[] Associative list of group IDs as keys and group items as values
	 */
	protected function getGroupItems( \Aimeos\MShop\Customer\Item\Iface $item = null )
	{
		$list = [];
		$context = $this->getContext();

		$isSuper = $this->getView()->access( ['super'] );
		$isAdmin = $this->getView()->access( ['admin'] );
		$isEditor = $this->getView()->access( ['editor'] );

		$manager = \Aimeos\MShop\Factory::createManager( $this->getContext(), 'customer/group' );
		$search = $manager->createSearch();
		$search->setSortations( [$search->sort( '+', 'customer.group.label' )] );

		foreach( $manager->searchItems( $search ) as $groupId => $groupItem )
		{
			if( !$isSuper && $groupItem->getCode() === 'super' ) {
				continue;
			}

			if( !$isSuper && !$isAdmin && $groupItem->getCode() === 'admin' ) {
				continue;
			}

			if( !$isSuper && !$isAdmin && $groupItem->getCode() === 'editor'
				&& ( !$isEditor || $item === null || (string) $context->getUserId() !== (string) $item->getId() )
			) {
				continue;
			}

			$list[$groupId] = $groupItem;
		}

		return $list;
	}


	/**
	 * Returns the list of sub-client names configured for the client.
	 *
	 * @return array List of JQAdm client names
	 */
	protected function getSubClientNames()
	{
		/** admin/jqadm/customer/standard/subparts
		 * List of JQAdm sub-clients rendered within the customer section
		 *
		 * The output of the frontend is composed of the code generated by the JQAdm
		 * clients. Each JQAdm client can consist of serveral (or none) sub-clients
		 * that are responsible for rendering certain sub-parts of the output. The
		 * sub-clients can contain JQAdm clients themselves and therefore a
		 * hierarchical tree of JQAdm clients is composed. Each JQAdm client creates
		 * the output that is placed inside the container of its parent.
		 *
		 * At first, always the JQAdm code generated by the parent is printed, then
		 * the JQAdm code of its sub-clients. The order of the JQAdm sub-clients
		 * determines the order of the output of these sub-clients inside the parent
		 * container. If the configured list of clients is
		 *
		 *  array( "subclient1", "subclient2" )
		 *
		 * you can easily change the order of the output by reordering the subparts:
		 *
		 *  admin/jqadm/<clients>/subparts = array( "subclient1", "subclient2" )
		 *
		 * You can also remove one or more parts if they shouldn't be rendered:
		 *
		 *  admin/jqadm/<clients>/subparts = array( "subclient1" )
		 *
		 * As the clients only generates structural JQAdm, the layout defined via CSS
		 * should support adding, removing or reordering content by a fluid like
		 * design.
		 *
		 * @param array List of sub-client names
		 * @since 2017.07
		 * @category Developer
		 */
		return $this->getContext()->getConfig()->get( 'admin/jqadm/customer/standard/subparts', [] );
	}



	/**
	 * Creates new and updates existing items using the data array
	 *
	 * @param string[] Data array
	 * @return \Aimeos\MShop\Customer\Item\Iface New customer item object
	 */
	protected function fromArray( array $data )
	{
		$data['customer.label'] = $data['customer.firstname'] . ' ' . $data['customer.lastname'];
		$data['customer.code'] = $data['customer.email'];

		$manager = \Aimeos\MShop\Factory::createManager( $this->getContext(), 'customer' );

		if( isset( $data['customer.id'] ) && $data['customer.id'] != '' ) {
			$item = $manager->getItem( $data['customer.id'], $this->getDomains() );
		} else {
			$item = $manager->createItem();
		}

		$item->fromArray( $data );
		$item->setGroups( array_intersect( array_keys( $this->getGroupItems( $item ) ), $item->getGroups() ) );

		return $item;
	}


	/**
	 * Constructs the data array for the view from the given item
	 *
	 * @param \Aimeos\MShop\Customer\Item\Iface $item Customer item object
	 * @return string[] Multi-dimensional associative list of item data
	 */
	protected function toArray( \Aimeos\MShop\Customer\Item\Iface $item, $copy = false )
	{
		$data = $item->toArray( true );

		if( $copy === true )
		{
			$data['customer.siteid'] = $this->getContext()->getLocale()->getSiteId();
			$data['customer.email'] = '';
			$data['customer.id'] = '';
		}

		return $data;
	}


	/**
	 * Returns the rendered template including the view data
	 *
	 * @param \Aimeos\MW\View\Iface $view View object with data assigned
	 * @return string HTML output
	 */
	protected function render( \Aimeos\MW\View\Iface $view )
	{
		/** admin/jqadm/customer/template-item
		 * Relative path to the HTML body template for the customer item.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the result shown in the body of the frontend. The
		 * configuration string is the path to the template file relative
		 * to the templates directory (usually in admin/jqadm/templates).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating the HTML code
		 * @since 2016.04
		 * @category Developer
		 */
		$tplconf = 'admin/jqadm/customer/template-item';
		$default = 'customer/item-standard.php';

		return $view->render( $view->config( $tplconf, $default ) );
	}
}
