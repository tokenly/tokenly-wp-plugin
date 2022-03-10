import * as React from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';
import AddressLink from './AddressLink';
import AddressInfo from './AddressInfo';
import AddressStatus from './AddressStatus';
import CardActions from '../CardActions';

import { 
	Card,
	CardHeader,
	CardBody,
	CardFooter,
	Flex,
} from '@wordpress/components';

interface AddressCardProps {
	address: any;
}

export default function AddressCard( props: AddressCardProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	function getCardActions(): Array<object> {
		const cardActions: Array<object> = [
			{
				title: 'View Details',
				href: `${ adminPageUrl }${ namespace }-token-address-show&address=${props.address.address}`,
			},
			{
				title: 'Edit Address',
				href: `${ adminPageUrl }${ namespace }-token-address-edit&address=${ props.address.address }`,
			}
		];
		return cardActions;
	}

	return (
		<Card size="extraSmall">
			<CardHeader>
				<Flex
					align="flex-end"
					justify="flex-start"
				>
				<AddressLink id={ props.address.address } label={ props.address.label } />
				<AddressStatus address={ props.address } />
				</Flex>
			</CardHeader>
			<CardBody style={ { width: '100%' } }>
				<AddressInfo address={ props.address } />
			</CardBody>
			<CardFooter>
				<CardActions actions={ getCardActions() } />
			</CardFooter>
		</Card>
	);
}
 



