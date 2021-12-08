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

interface CreditTransactionCardProps {
	creditTransaction: any;
}

interface CreditTransactionCardState {
	//
}

export class CreditTransactionCard extends Component<CreditTransactionCardProps, CreditTransactionCardState> {

	constructor( props: CreditTransactionCardProps ) {
		super( props );
	}

	render() {
		return (
			<Card size="extraSmall" style={ { width: '100%' } }>
				<CardHeader>
					<div>{ this.props.creditTransaction.uuid }</div>
				</CardHeader>
				<CardBody style={ { width: '100%' } }>
					<Flex style={ { width: '100%', alignItems: 'center' } }>
						<div style={ { flex: 1 } }>
							<div><span>UUID: </span><strong>{ this.props.creditTransaction.account_uuid }</strong></div>
							<div><span>Amount: </span><strong>{ this.props.creditTransaction.amount }</strong></div>
						</div>
					</Flex>
				</CardBody>
			</Card>
		);
	}
}
 

