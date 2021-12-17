import * as React from 'react';
import { Component } from 'react';
import * as dayjs from 'dayjs';
import { UserLink } from './UserLink';

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
		console.log(this.props);
	}

	dateFormatted( date: Date ) {
		if ( date ) {
			return dayjs( date ).format( 'MMMM D, YYYY h:mm A' )
		}
		return;
	}

	render() {
		return (
			<Card size="extraSmall" style={ { width: '100%' } }>
				<CardHeader>
					<div>№ <strong>{ this.props.creditTransaction.tx_uuid }</strong></div>
				</CardHeader>
				<CardBody style={ { width: '100%' } }>
					<Flex style={ { width: '100%', alignItems: 'center' } }>
						<div style={ { flex: 1 } }>
							<Flex justify="flex-start">
								<span>User: </span>
								<UserLink
									id={ this.props.creditTransaction?.user?.id }
									name={ this.props.creditTransaction?.user?.name ? this.props.creditTransaction?.user?.name : this.props.creditTransaction?.account }
									alt={ this.props.creditTransaction.account }
								/>
							</Flex>
							<div>
								<span>Amount: </span>
								<strong>{ this.props.creditTransaction.amount }</strong>
							</div>
							<div>
								<span>Created at: </span>
								<strong>{ this.dateFormatted( this.props.creditTransaction?.created_at ) }</strong>
							</div>
							<div>
								<span>Updated at: </span>
								<strong>{ this.dateFormatted( this.props.creditTransaction?.updated_at ) }</strong>
							</div>
						</div>
					</Flex>
				</CardBody>
			</Card>
		);
	}
}
 

