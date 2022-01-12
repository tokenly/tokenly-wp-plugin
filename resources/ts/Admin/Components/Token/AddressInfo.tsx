import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';

import { 
	Flex,
} from '@wordpress/components';

interface AddressInfoProps {
	address: any;
}

interface AddressInfoState {
	//
}

export default class AddressInfo extends Component<AddressInfoProps, AddressInfoState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;
	
	constructor( props: AddressInfoProps ) {
		super( props );
	}

	render() {
		return (
			<Flex
				//@ts-ignore
				direction="column"
			>
				<Flex
					//@ts-ignore
					direction="column"
					gap={0}
					style={ { opacity: this.props.address ? 1 : 0.5 } }
				>
					<div>
						<b>Type: </b>
						<span>{ this.props.address?.type ?? '-' }</span>
					</div>
					<div>
						<b>Address: </b>
						<span>{ this.props.address?.address ?? '-' }</span>
					</div>
					<div>
						<b>Assets: </b>
						{ this.props.address
							?	<a href={ `${ this.adminPageUrl }${ this.namespace }-token-address-balance-index&id=${ this.props.address.address }` } >View Balance</a>
							:	<span>-</span>
						}
					</div>
				</Flex>
			</Flex>
		);
	}
}
