import * as React from 'react';
import { Component } from 'react';

import { 
	Button,
	Card,
	CardHeader,
	CardBody,
	Flex,
	CardFooter
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
		if ( this.props.balance?.meta?.name ) {
			name = this.props.balance.meta.name;
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
					{ this.props?.balance?.balance ?? 0 }
				</CardBody>
			</Card>
		);
	}
}
 

