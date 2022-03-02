import * as React from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';
import { 
	Button,
	Flex,
} from '@wordpress/components';

export default function VendorActions() {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	return (
		<Flex
			justify="flex-start"
			style={ { width: '100%' } }
		>
			<Button
				isPrimary
				href={ `${adminPageUrl}${namespace}-credit-transaction-store` }
			>
				Make Transaction
			</Button>
			<Button
				isPrimary
				href={ `${adminPageUrl}${namespace}-credit-group-store` }
			>
				Register Group
			</Button>
		</Flex>
	);
}
 

