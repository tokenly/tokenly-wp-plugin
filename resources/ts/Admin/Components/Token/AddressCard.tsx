import * as React from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';
import AddressLink from './AddressLink';
import AddressInfo from './AddressInfo';
import CardActions from './../CardActions';

import { 
	Card,
	CardHeader,
	CardBody,
	CardFooter,
	Flex,
	Dashicon,
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
		if ( !props.address.verified ) {
			cardActions.push( {
				title: 'Verify Address',
				href: `${ adminPageUrl }${ namespace }-token-address-verify&address=${props.address.address}`,
				isPrimary: true,
			} );
		}
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
				{ !props?.address?.verified &&
					<span title="Not Verified" style={{display: 'inline-flex', alignItems: 'center'}}>
						<Dashicon style={ { width: '16px', height: '16px', fontSize: '16px' } } icon="warning" />
					</span>
				}
				{ props?.address?.isSource == true &&
					<span title="Is Source" style={{display: 'inline-flex', alignItems: 'center'}}>
						<Dashicon style={ { width: '16px', height: '16px', fontSize: '16px' } } icon="yes-alt" />
					</span>
				}
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
 



