import * as React from 'react';
import { Component } from 'react';

import { 
	Card,
	CardHeader,
	CardBody,
} from '@wordpress/components';

interface BalanceCardProps {
	balance: any;
}

interface BalanceCardState {
	//
}

export class BalanceCard extends Component<BalanceCardProps, BalanceCardState> {

	constructor( props: BalanceCardProps ) {
		super( props );
		this.getName = this.getName.bind( this );
	}
	
	getName() {
		let name = this.props.balance.asset;
		if ( this.props.balance?.token_meta?.name ) {
			name = this.props.balance.token_meta.name;
		}
		return name;
	}

	render() {
		return (
			<Card size="extraSmall" style={ { width: '100%' } }>
				<CardHeader>
					<strong title={ this.props?.balance?.asset }>{ this.getName() }</strong>
				</CardHeader>
				<CardBody style={ { width: '100%' } }>
					{ this.props?.balance?.quantity?.value ?? 0 }
				</CardBody>
			</Card>
		);
	}
}
 

