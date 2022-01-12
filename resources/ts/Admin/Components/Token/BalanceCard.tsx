import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
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

interface BalanceCardState {
	//
}

export default class BalanceCard extends Component<BalanceCardProps, BalanceCardState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

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
					<b title={ this.props?.balance?.asset }>{ this.getName() }</b>
				</CardHeader>
				<CardBody style={ { width: '100%' } }>
					{ this.props?.balance?.quantity?.value ?? 0 }
				</CardBody>
			</Card>
		);
	}
}
 

