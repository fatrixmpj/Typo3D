<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Product
 */


namespace Aimeos\MShop\Product\Manager;


/**
 * Default product manager.
 *
 * @package MShop
 * @subpackage Product
 */
class Standard
	extends \Aimeos\MShop\Common\Manager\ListRef\Base
	implements \Aimeos\MShop\Product\Manager\Iface, \Aimeos\MShop\Common\Manager\Factory\Iface
{
	use \Aimeos\MShop\Common\Manager\PropertyRef\Traits;


	private $searchConfig = array(
		'product.siteid' => array(
			'code' => 'product.siteid',
			'internalcode' => 'mpro."siteid"',
			'label' => 'Site ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'product.typeid' => array(
			'code' => 'product.typeid',
			'internalcode' => 'mpro."typeid"',
			'label' => 'Type ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'product.label' => array(
			'code' => 'product.label',
			'internalcode' => 'mpro."label"',
			'label' => 'Label',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'product.code' => array(
			'code' => 'product.code',
			'internalcode' => 'mpro."code"',
			'label' => 'SKU',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'product.id' => array(
			'code' => 'product.id',
			'internalcode' => 'mpro."id"',
			'label' => 'ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'product.datestart' => array(
			'code' => 'product.datestart',
			'internalcode' => 'mpro."start"',
			'label' => 'Start date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'product.dateend' => array(
			'code' => 'product.dateend',
			'internalcode' => 'mpro."end"',
			'label' => 'End date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'product.status' => array(
			'code' => 'product.status',
			'internalcode' => 'mpro."status"',
			'label' => 'Status',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'product.config' => array(
			'code' => 'product.config',
			'internalcode' => 'mpro."config"',
			'label' => 'Config',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'product.target' => array(
			'code' => 'product.target',
			'internalcode' => 'mpro."target"',
			'label' => 'URL target',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'product.ctime' => array(
			'code' => 'product.ctime',
			'internalcode' => 'mpro."ctime"',
			'label' => 'Create date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'product.mtime' => array(
			'code' => 'product.mtime',
			'internalcode' => 'mpro."mtime"',
			'label' => 'Modify date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'product.editor' => array(
			'code' => 'product.editor',
			'internalcode' => 'mpro."editor"',
			'label' => 'Editor',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'product:has' => array(
			'code' => 'product:has()',
			'internalcode' => '( SELECT mpro_has."id" FROM mshop_product AS mpro_has
				WHERE mpro."id" = mpro_has."id" AND (
					SELECT COUNT(DISTINCT mproli_has."parentid")
					FROM "mshop_product_list" AS mproli_has
					JOIN "mshop_product_list_type" AS mprolity_has ON mproli_has."typeid" = mprolity_has."id"
					WHERE mpro."id" = mproli_has."parentid" AND :site
						AND mproli_has."domain" = $1 AND mprolity_has."code" = $2 AND mproli_has."refid" = $3
				) = 1
			)',
			'label' => 'Product list item, parameter(<domain>,<list type>,<reference ID>)',
			'type' => 'null',
			'internaltype' => 'null',
			'public' => false,
		),
		'product:prop' => array(
			'code' => 'product:prop()',
			'internalcode' => '( SELECT mpro_has."id" FROM mshop_product AS mpro_has
				WHERE mpro."id" = mpro_has."id" AND (
					SELECT COUNT(DISTINCT mpropr_prop."parentid")
					FROM "mshop_product_property" AS mpropr_prop
					JOIN "mshop_product_property_type" AS mproprty_prop ON mpropr_prop."typeid" = mproprty_prop."id"
					WHERE mpro."id" = mpropr_prop."parentid" AND :site
						AND mproprty_prop."code" = $1 AND mpropr_prop."value" = $3
						AND ( mpropr_prop."langid" = $2 OR mpropr_prop."langid" IS NULL )
				) = 1
			)',
			'label' => 'Product has property item, parameter(<property type>,<language code>,<property value>)',
			'type' => 'null',
			'internaltype' => 'null',
			'public' => false,
		),
		// @deprecated 2019.01, use product:has()
		'product.contains' => array(
			'code' => 'product.contains()',
			'internalcode' => '( SELECT COUNT(mproli_cs."parentid")
				FROM "mshop_product_list" AS mproli_cs
				WHERE mpro."id" = mproli_cs."parentid" AND :site
					AND mproli_cs."domain" = $1 AND mproli_cs."refid" IN ( $3 ) AND mproli_cs."typeid" = $2
					AND ( mproli_cs."start" IS NULL OR mproli_cs."start" <= \':date\' )
					AND ( mproli_cs."end" IS NULL OR mproli_cs."end" >= \':date\' ) )',
			'label' => 'Number of product list items, parameter(<domain>,<list type ID>,<reference IDs>)',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
	);

	private $date;


	/**
	 * Creates the product manager that will use the given context object.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object with required objects
	 */
	public function __construct( \Aimeos\MShop\Context\Item\Iface $context )
	{
		parent::__construct( $context );
		$this->setResourceName( 'db-product' );

		$locale = $context->getLocale();
		$this->date = $context->getDateTime();

		$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;
		$level = $context->getConfig()->get( 'mshop/product/manager/sitemode', $level );

		$siteIds = [$locale->getSiteId()];

		if( $level & \Aimeos\MShop\Locale\Manager\Base::SITE_PATH ) {
			$siteIds = array_merge( $siteIds, $locale->getSitePath() );
		}

		if( $level & \Aimeos\MShop\Locale\Manager\Base::SITE_SUBTREE ) {
			$siteIds = array_merge( $siteIds, $locale->getSiteSubTree() );
		}

		$this->replaceSiteMarker( $this->searchConfig['product:has'], 'mproli_has."siteid"', $siteIds, ':site' );
		$this->replaceSiteMarker( $this->searchConfig['product:prop'], 'mpropr_prop."siteid"', $siteIds, ':site' );
		$this->replaceSiteMarker( $this->searchConfig['product.contains'], 'mproli_cs."siteid"', $siteIds, ':site' );
		$this->searchConfig['product.contains'] = str_replace( ':date', $this->date, $this->searchConfig['product.contains'] );
	}


	/**
	 * Removes old entries from the storage.
	 *
	 * @param integer[] $siteids List of IDs for sites whose entries should be deleted
	 */
	public function cleanup( array $siteids )
	{
		$path = 'mshop/product/manager/submanagers';
		$default = ['lists', 'property', 'type'];

		foreach( $this->getContext()->getConfig()->get( $path, $default ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->cleanup( $siteids );
		}

		$this->cleanupBase( $siteids, 'mshop/product/manager/standard/delete' );
	}


	/**
	 * Creates a new empty item instance
	 *
	 * @param string|null Type the item should be created with
	 * @param string|null Domain of the type the item should be created with
	 * @param array $values Values the item should be initialized with
	 * @return \Aimeos\MShop\Product\Item\Iface New product item object
	 */
	public function createItem( $type = null, $domain = null, array $values = [] )
	{
		$values['product.siteid'] = $this->getContext()->getLocale()->getSiteId();

		if( $type !== null )
		{
			$values['product.typeid'] = $this->getTypeId( $type, 'product' );
			$values['product.type'] = $type;
		}

		return $this->createItemBase( $values );
	}


	/**
	 * Adds a new product to the storage.
	 *
	 * @param \Aimeos\MShop\Common\Item\Iface $item Product item that should be saved to the storage
	 * @param boolean $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Common\Item\Iface $item Updated item including the generated ID
	 */
	public function saveItem( \Aimeos\MShop\Common\Item\Iface $item, $fetch = true )
	{
		self::checkClass( '\\Aimeos\\MShop\\Product\\Item\\Iface', $item );

		if( !$item->isModified() )
		{
			$item = $this->savePropertyItems( $item, 'product', $fetch );
			return $this->saveListItems( $item, 'product', $fetch );
		}

		$context = $this->getContext();

		$dbm = $context->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );

		try
		{
			$id = $item->getId();

			if( $id === null )
			{
				/** mshop/product/manager/standard/insert/mysql
				 * Inserts a new product record into the database table
				 *
				 * @see mshop/product/manager/standard/insert/ansi
				 */

				/** mshop/product/manager/standard/insert/ansi
				 * Inserts a new product record into the database table
				 *
				 * Items with no ID yet (i.e. the ID is NULL) will be created in
				 * the database and the newly created ID retrieved afterwards
				 * using the "newid" SQL statement.
				 *
				 * The SQL statement must be a string suitable for being used as
				 * prepared statement. It must include question marks for binding
				 * the values from the product item to the statement before they are
				 * sent to the database server. The number of question marks must
				 * be the same as the number of columns listed in the INSERT
				 * statement. The order of the columns must correspond to the
				 * order in the saveItems() method, so the correct values are
				 * bound to the columns.
				 *
				 * The SQL statement should conform to the ANSI standard to be
				 * compatible with most relational database systems. This also
				 * includes using double quotes for table and column names.
				 *
				 * @param string SQL statement for inserting records
				 * @since 2014.03
				 * @category Developer
				 * @see mshop/product/manager/standard/update/ansi
				 * @see mshop/product/manager/standard/newid/ansi
				 * @see mshop/product/manager/standard/delete/ansi
				 * @see mshop/product/manager/standard/search/ansi
				 * @see mshop/product/manager/standard/count/ansi
				 */
				$path = 'mshop/product/manager/standard/insert';
			}
			else
			{
				/** mshop/product/manager/standard/update/mysql
				 * Updates an existing product record in the database
				 *
				 * @see mshop/product/manager/standard/update/ansi
				 */

				/** mshop/product/manager/standard/update/ansi
				 * Updates an existing product record in the database
				 *
				 * Items which already have an ID (i.e. the ID is not NULL) will
				 * be updated in the database.
				 *
				 * The SQL statement must be a string suitable for being used as
				 * prepared statement. It must include question marks for binding
				 * the values from the product item to the statement before they are
				 * sent to the database server. The order of the columns must
				 * correspond to the order in the saveItems() method, so the
				 * correct values are bound to the columns.
				 *
				 * The SQL statement should conform to the ANSI standard to be
				 * compatible with most relational database systems. This also
				 * includes using double quotes for table and column names.
				 *
				 * @param string SQL statement for updating records
				 * @since 2014.03
				 * @category Developer
				 * @see mshop/product/manager/standard/insert/ansi
				 * @see mshop/product/manager/standard/newid/ansi
				 * @see mshop/product/manager/standard/delete/ansi
				 * @see mshop/product/manager/standard/search/ansi
				 * @see mshop/product/manager/standard/count/ansi
				 */
				$path = 'mshop/product/manager/standard/update';
			}

			$stmt = $this->getCachedStatement( $conn, $path );

			$stmt->bind( 1, $item->getTypeId(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( 2, $item->getCode() );
			$stmt->bind( 3, $item->getLabel() );
			$stmt->bind( 4, $item->getStatus(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( 5, $item->getDateStart() );
			$stmt->bind( 6, $item->getDateEnd() );
			$stmt->bind( 7, json_encode( $item->getConfig() ) );
			$stmt->bind( 8, $item->getTarget() );
			$stmt->bind( 9, $context->getEditor() );
			$stmt->bind( 10, date( 'Y-m-d H:i:s' ) ); // mtime
			$stmt->bind( 11, $item->getTimeCreated() );
			$stmt->bind( 12, $context->getLocale()->getSiteId(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );

			if( $id !== null )
			{
				$stmt->bind( 13, $id, \Aimeos\MW\DB\Statement\Base::PARAM_INT );
				$item->setId( $id ); //so item is no longer modified
			}

			$stmt->execute()->finish();

			if( $id === null )
			{
				/** mshop/product/manager/standard/newid/mysql
				 * Retrieves the ID generated by the database when inserting a new record
				 *
				 * @see mshop/product/manager/standard/newid/ansi
				 */

				/** mshop/product/manager/standard/newid/ansi
				 * Retrieves the ID generated by the database when inserting a new record
				 *
				 * As soon as a new record is inserted into the database table,
				 * the database server generates a new and unique identifier for
				 * that record. This ID can be used for retrieving, updating and
				 * deleting that specific record from the table again.
				 *
				 * For MySQL:
				 *  SELECT LAST_INSERT_ID()
				 * For PostgreSQL:
				 *  SELECT currval('seq_mpro_id')
				 * For SQL Server:
				 *  SELECT SCOPE_IDENTITY()
				 * For Oracle:
				 *  SELECT "seq_mpro_id".CURRVAL FROM DUAL
				 *
				 * There's no way to retrive the new ID by a SQL statements that
				 * fits for most database servers as they implement their own
				 * specific way.
				 *
				 * @param string SQL statement for retrieving the last inserted record ID
				 * @since 2014.03
				 * @category Developer
				 * @see mshop/product/manager/standard/insert/ansi
				 * @see mshop/product/manager/standard/update/ansi
				 * @see mshop/product/manager/standard/delete/ansi
				 * @see mshop/product/manager/standard/search/ansi
				 * @see mshop/product/manager/standard/count/ansi
				 */
				$path = 'mshop/product/manager/standard/newid';
				$item->setId( $this->newId( $conn, $path ) );
			}

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}

		$item = $this->savePropertyItems( $item, 'product', $fetch );
		return $this->saveListItems( $item, 'product', $fetch );
	}


	/**
	 * Removes multiple items specified by ids in the array.
	 *
	 * @param array $ids List of IDs
	 */
	public function deleteItems( array $ids )
	{
		/** mshop/product/manager/standard/delete/mysql
		 * Deletes the items matched by the given IDs from the database
		 *
		 * @see mshop/product/manager/standard/delete/ansi
		 */

		/** mshop/product/manager/standard/delete/ansi
		 * Deletes the items matched by the given IDs from the database
		 *
		 * Removes the records specified by the given IDs from the product database.
		 * The records must be from the site that is configured via the
		 * context item.
		 *
		 * The ":cond" placeholder is replaced by the name of the ID column and
		 * the given ID or list of IDs while the site ID is bound to the question
		 * mark.
		 *
		 * The SQL statement should conform to the ANSI standard to be
		 * compatible with most relational database systems. This also
		 * includes using double quotes for table and column names.
		 *
		 * @param string SQL statement for deleting items
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/product/manager/standard/insert/ansi
		 * @see mshop/product/manager/standard/update/ansi
		 * @see mshop/product/manager/standard/newid/ansi
		 * @see mshop/product/manager/standard/search/ansi
		 * @see mshop/product/manager/standard/count/ansi
		 */
		$path = 'mshop/product/manager/standard/delete';
		$this->deleteItemsBase( $ids, $path );
	}


	/**
	 * Returns the item specified by its code and domain/type if necessary
	 *
	 * @param string $code Code of the item
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param string|null $domain Domain of the item if necessary to identify the item uniquely
	 * @param string|null $type Type code of the item if necessary to identify the item uniquely
	 * @param boolean $default True to add default criteria
	 * @return \Aimeos\MShop\Common\Item\Iface Item object
	 */
	public function findItem( $code, array $ref = [], $domain = null, $type = null, $default = false )
	{
		return $this->findItemBase( array( 'product.code' => $code ), $ref, $default );
	}


	/**
	 * Returns the product item for the given product ID.
	 *
	 * @param integer $id Unique ID of the product item
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param boolean $default Add default criteria
	 * @return \Aimeos\MShop\Product\Item\Iface Returns the product item of the given id
	 * @throws \Aimeos\MShop\Exception If item couldn't be found
	 */
	public function getItem( $id, array $ref = [], $default = false )
	{
		return $this->getItemBase( 'product.id', $id, $ref, $default );
	}


	/**
	 * Search for products based on the given criteria.
	 *
	 * @param \Aimeos\MW\Criteria\Iface $search Search criteria object
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param integer|null &$total Number of items that are available in total
	 * @return array List of products implementing \Aimeos\MShop\Product\Item\Iface
	 */
	public function searchItems( \Aimeos\MW\Criteria\Iface $search, array $ref = [], &$total = null )
	{
		$map = $typeIds = [];
		$context = $this->getContext();

		$dbm = $context->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );

		try
		{
			$required = array( 'product' );

			/** mshop/product/manager/sitemode
			 * Mode how items from levels below or above in the site tree are handled
			 *
			 * By default, only items from the current site are fetched from the
			 * storage. If the ai-sites extension is installed, you can create a
			 * tree of sites. Then, this setting allows you to define for the
			 * whole product domain if items from parent sites are inherited,
			 * sites from child sites are aggregated or both.
			 *
			 * Available constants for the site mode are:
			 * * 0 = only items from the current site
			 * * 1 = inherit items from parent sites
			 * * 2 = aggregate items from child sites
			 * * 3 = inherit and aggregate items at the same time
			 *
			 * You also need to set the mode in the locale manager
			 * (mshop/locale/manager/standard/sitelevel) to one of the constants.
			 * If you set it to the same value, it will work as described but you
			 * can also use different modes. For example, if inheritance and
			 * aggregation is configured the locale manager but only inheritance
			 * in the domain manager because aggregating items makes no sense in
			 * this domain, then items wil be only inherited. Thus, you have full
			 * control over inheritance and aggregation in each domain.
			 *
			 * @param integer Constant from Aimeos\MShop\Locale\Manager\Base class
			 * @category Developer
			 * @since 2018.01
			 * @see mshop/locale/manager/standard/sitelevel
			 */
			$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;
			$level = $context->getConfig()->get( 'mshop/product/manager/sitemode', $level );

			/** mshop/product/manager/standard/search/mysql
			 * Retrieves the records matched by the given criteria in the database
			 *
			 * @see mshop/product/manager/standard/search/ansi
			 */

			/** mshop/product/manager/standard/search/ansi
			 * Retrieves the records matched by the given criteria in the database
			 *
			 * Fetches the records matched by the given criteria from the product
			 * database. The records must be from one of the sites that are
			 * configured via the context item. If the current site is part of
			 * a tree of sites, the SELECT statement can retrieve all records
			 * from the current site and the complete sub-tree of sites.
			 *
			 * As the records can normally be limited by criteria from sub-managers,
			 * their tables must be joined in the SQL context. This is done by
			 * using the "internaldeps" property from the definition of the ID
			 * column of the sub-managers. These internal dependencies specify
			 * the JOIN between the tables and the used columns for joining. The
			 * ":joins" placeholder is then replaced by the JOIN strings from
			 * the sub-managers.
			 *
			 * To limit the records matched, conditions can be added to the given
			 * criteria object. It can contain comparisons like column names that
			 * must match specific values which can be combined by AND, OR or NOT
			 * operators. The resulting string of SQL conditions replaces the
			 * ":cond" placeholder before the statement is sent to the database
			 * server.
			 *
			 * If the records that are retrieved should be ordered by one or more
			 * columns, the generated string of column / sort direction pairs
			 * replaces the ":order" placeholder. In case no ordering is required,
			 * the complete ORDER BY part including the "\/*-orderby*\/...\/*orderby-*\/"
			 * markers is removed to speed up retrieving the records. Columns of
			 * sub-managers can also be used for ordering the result set but then
			 * no index can be used.
			 *
			 * The number of returned records can be limited and can start at any
			 * number between the begining and the end of the result set. For that
			 * the ":size" and ":start" placeholders are replaced by the
			 * corresponding values from the criteria object. The default values
			 * are 0 for the start and 100 for the size value.
			 *
			 * The SQL statement should conform to the ANSI standard to be
			 * compatible with most relational database systems. This also
			 * includes using double quotes for table and column names.
			 *
			 * @param string SQL statement for searching items
			 * @since 2014.03
			 * @category Developer
			 * @see mshop/product/manager/standard/insert/ansi
			 * @see mshop/product/manager/standard/update/ansi
			 * @see mshop/product/manager/standard/newid/ansi
			 * @see mshop/product/manager/standard/delete/ansi
			 * @see mshop/product/manager/standard/count/ansi
			 */
			$cfgPathSearch = 'mshop/product/manager/standard/search';

			/** mshop/product/manager/standard/count/mysql
			 * Counts the number of records matched by the given criteria in the database
			 *
			 * @see mshop/product/manager/standard/count/ansi
			 */

			/** mshop/product/manager/standard/count/ansi
			 * Counts the number of records matched by the given criteria in the database
			 *
			 * Counts all records matched by the given criteria from the product
			 * database. The records must be from one of the sites that are
			 * configured via the context item. If the current site is part of
			 * a tree of sites, the statement can count all records from the
			 * current site and the complete sub-tree of sites.
			 *
			 * As the records can normally be limited by criteria from sub-managers,
			 * their tables must be joined in the SQL context. This is done by
			 * using the "internaldeps" property from the definition of the ID
			 * column of the sub-managers. These internal dependencies specify
			 * the JOIN between the tables and the used columns for joining. The
			 * ":joins" placeholder is then replaced by the JOIN strings from
			 * the sub-managers.
			 *
			 * To limit the records matched, conditions can be added to the given
			 * criteria object. It can contain comparisons like column names that
			 * must match specific values which can be combined by AND, OR or NOT
			 * operators. The resulting string of SQL conditions replaces the
			 * ":cond" placeholder before the statement is sent to the database
			 * server.
			 *
			 * Both, the strings for ":joins" and for ":cond" are the same as for
			 * the "search" SQL statement.
			 *
			 * Contrary to the "search" statement, it doesn't return any records
			 * but instead the number of records that have been found. As counting
			 * thousands of records can be a long running task, the maximum number
			 * of counted records is limited for performance reasons.
			 *
			 * The SQL statement should conform to the ANSI standard to be
			 * compatible with most relational database systems. This also
			 * includes using double quotes for table and column names.
			 *
			 * @param string SQL statement for counting items
			 * @since 2014.03
			 * @category Developer
			 * @see mshop/product/manager/standard/insert/ansi
			 * @see mshop/product/manager/standard/update/ansi
			 * @see mshop/product/manager/standard/newid/ansi
			 * @see mshop/product/manager/standard/delete/ansi
			 * @see mshop/product/manager/standard/search/ansi
			 */
			$cfgPathCount = 'mshop/product/manager/standard/count';

			$results = $this->searchItemsBase( $conn, $search, $cfgPathSearch, $cfgPathCount, $required, $total, $level );

			while( ( $row = $results->fetch() ) !== false )
			{
				$config = $row['product.config'];

				if( $config && ( $row['product.config'] = json_decode( $config, true ) ) === null )
				{
					$msg = sprintf( 'Invalid JSON as result of search for ID "%2$s" in "%1$s": %3$s', 'mshop_product.config', $row['product.id'], $config );
					$this->getContext()->getLogger()->log( $msg, \Aimeos\MW\Logger\Base::WARN );
				}

				$map[$row['product.id']] = $row;
				$typeIds[$row['product.typeid']] = null;
			}

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}

		if( !empty( $typeIds ) )
		{
			$typeManager = $this->getObject()->getSubManager( 'type' );
			$typeSearch = $typeManager->createSearch();
			$typeSearch->setConditions( $typeSearch->compare( '==', 'product.type.id', array_keys( $typeIds ) ) );
			$typeSearch->setSlice( 0, $search->getSliceSize() );
			$typeItems = $typeManager->searchItems( $typeSearch );

			foreach( $map as $id => $row )
			{
				if( isset( $typeItems[$row['product.typeid']] ) )
				{
					$map[$id]['product.type'] = $typeItems[$row['product.typeid']]->getCode();
					$map[$id]['product.typename'] = $typeItems[$row['product.typeid']]->getName();
				}
			}
		}

		$propItems = [];
		if( in_array( 'product/property', $ref, true ) ) {
			$propItems = $this->getPropertyItems( array_keys( $map ), 'product' );
		}

		return $this->buildItems( $map, $ref, 'product', $propItems );
	}


	/**
	 * Returns the available manager types
	 *
	 * @param boolean $withsub Return also the resource type of sub-managers if true
	 * @return array Type of the manager and submanagers, subtypes are separated by slashes
	 */
	public function getResourceType( $withsub = true )
	{
		$path = 'mshop/product/manager/submanagers';
		$default = ['lists', 'property', 'type'];

		return $this->getResourceTypeBase( 'product', $path, $default, $withsub );
	}


	/**
	 * Returns the attributes that can be used for searching.
	 *
	 * @param boolean $withsub Return also attributes of sub-managers if true
	 * @return array Returns a list of attribtes implementing \Aimeos\MW\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( $withsub = true )
	{
		/** mshop/product/manager/submanagers
		 * List of manager names that can be instantiated by the product manager
		 *
		 * Managers provide a generic interface to the underlying storage.
		 * Each manager has or can have sub-managers caring about particular
		 * aspects. Each of these sub-managers can be instantiated by its
		 * parent manager using the getSubManager() method.
		 *
		 * The search keys from sub-managers can be normally used in the
		 * manager as well. It allows you to search for items of the manager
		 * using the search keys of the sub-managers to further limit the
		 * retrieved list of items.
		 *
		 * @param array List of sub-manager names
		 * @since 2014.03
		 * @category Developer
		 */
		$path = 'mshop/product/manager/submanagers';
		$default = ['lists', 'property', 'type'];

		return $this->getSearchAttributesBase( $this->searchConfig, $path, $default, $withsub );
	}


	/**
	 * Returns a new manager for product extensions.
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return \Aimeos\MShop\Common\Manager\Iface Submanager, e.g. type, property, etc.
	 */
	public function getSubManager( $manager, $name = null )
	{
		return $this->getSubManagerBase( 'product', $manager, $name );
	}


	/**
	 * Creates a search object and optionally sets base criteria.
	 *
	 * @param boolean $default Add default criteria
	 * @return \Aimeos\MW\Criteria\Iface Criteria object
	 */
	public function createSearch( $default = false )
	{
		if( $default === true )
		{
			$object = $this->createSearchBase( 'product' );

			$expr = array( $object->getConditions() );

			$temp = array(
				$object->compare( '==', 'product.datestart', null ),
				$object->compare( '<=', 'product.datestart', $this->date ),
			);
			$expr[] = $object->combine( '||', $temp );

			$temp = array(
				$object->compare( '==', 'product.dateend', null ),
				$object->compare( '>=', 'product.dateend', $this->date ),
			);
			$expr[] = $object->combine( '||', $temp );

			$object->setConditions( $object->combine( '&&', $expr ) );

			return $object;
		}

		return parent::createSearch();
	}


	/**
	 * Create new product item object initialized with given parameters.
	 *
	 * @param array $values Associative list of key/value pairs
	 * @param array $listItems List of items implementing \Aimeos\MShop\Common\Item\Lists\Iface
	 * @param array $refItems List of items implementing \Aimeos\MShop\Common\Item\Iface
	 * @param array $propertyItems List of items implementing \Aimeos\MShop\Common\Item\Property\Iface
	 * @return \Aimeos\MShop\Product\Item\Iface New product item
	 */
	protected function createItemBase( array $values = [], array $listItems = [],
		array $refItems = [], array $propertyItems = [] )
	{
		$values['date'] = $this->date;

		return new \Aimeos\MShop\Product\Item\Standard( $values, $listItems, $refItems, $propertyItems );
	}
}
