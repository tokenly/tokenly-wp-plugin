import * as React from 'react';
import { Component } from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';

import { 
	Flex,
} from '@wordpress/components';

interface AddressInfoProps {
	address: any;
}

export default function AddressInfo( props: AddressInfoProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	return (
		<Flex
			//@ts-ignore
			direction="column"
		>
			<Flex
				//@ts-ignore
				direction="column"
				gap={0}
				style={ { opacity: props.address ? 1 : 0.5 } }
			>
				<div>
					<b>Type: </b>
					<span>{ props.address?.type ?? '-' }</span>
				</div>
				<div>
					<b>Address: </b>
					<span>{ props.address?.address ?? '-' }</span>
				</div>
				<div>
					<b>Assets: </b>
					{ props.address
						?	<a href={ `${ adminPageUrl }${ namespace }-token-address-balance-index&id=${ props.address.address }` } >View Balance</a>
						:	<span>-</span>
					}
				</div>
			</Flex>
		</Flex>
	);
}
