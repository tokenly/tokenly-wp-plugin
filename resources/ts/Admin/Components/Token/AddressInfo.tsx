import * as React from 'react';
import { Component } from 'react';

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

	constructor( props: AddressInfoProps ) {
		super( props );
	}

	render() {
		return (
			<Flex
				//@ts-ignore
				direction="column"
				gap={0.5}
			>
				<div>Address info:</div>
				<Flex
					//@ts-ignore
					direction="column"
					gap={0}
					style={ { opacity: this.props.address ? 1 : 0.5 } }
				>
					<div>
						<strong>Type: </strong>
						<span>{ this.props.address?.type ?? '-' }</span>
					</div>
					<div>
						<strong>Address: </strong>
						<span>{ this.props.address?.address ?? '-' }</span>
					</div>
					<div>
						<strong>Assets: </strong>
						{ this.props.address
							?	<a href={ `/wp-admin/admin.php?page=tokenly-token-balance-index&address=${ this.props.address.address }` } >View balances</a>
							:	<span>-</span>
						}
					</div>
				</Flex>
			</Flex>
		);
	}
}
