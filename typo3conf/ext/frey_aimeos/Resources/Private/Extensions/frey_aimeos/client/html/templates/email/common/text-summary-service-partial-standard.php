<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017
 */

/** Available data
 * - service : List of order service items (delivery or payment)
 * - type : Service type (delivery or payment)
 */


foreach( $this->service as $service )
{
	echo strip_tags( $service->getName() ) . "\n";

	foreach( $service->getAttributes() as $attribute )
	{
		if( $attribute->getType() === $this->type )
		{
			$name = ( $attribute->getName() != '' ? $attribute->getName() : $this->translate( 'client/code', $attribute->getCode() ) );

			switch( $attribute->getValue() )
			{
				case 'array':
				case 'object':
					$value = join( ', ', (array) $attribute->getValue() );
					break;
				default:
					switch( $attribute->getCode() )
					{
						case 'freyversand.datum':
							$value = date_create( $attribute->getValue() )->format( $this->translate( 'client', 'Y-m-d' ) );
							break;
						default:
							$value = $attribute->getValue();
					}
			}

			echo '- ' . strip_tags( $name ) . ': ' . strip_tags( $value ) . "\n";
		}
	}
}
