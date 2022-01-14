import * as React from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';
import CardActions from './../CardActions';

import { 
	Card,
	CardHeader,
	CardBody,
	CardFooter,
} from '@wordpress/components';

interface BalanceCardProps {
	balance: any;
}

export default function BalanceCard( props: BalanceCardProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );
	
	function getName() {
		let name = props.balance.asset;
		if ( props.balance?.meta?.name ) {
			name = props.balance.meta.name;
		}
		return name;
	}

	return (
		<Card size="extraSmall" style={ { width: '100%' } }>
			<CardHeader>
				<b title={ props?.balance?.asset }>{ getName() }</b>
			</CardHeader>
			<CardBody style={ { width: '100%' } }>
				{ props?.balance?.quantity?.value ?? 0 }
			</CardBody>
		</Card>
	);
}
 

