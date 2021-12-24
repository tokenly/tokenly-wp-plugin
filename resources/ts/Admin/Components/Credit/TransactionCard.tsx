import * as React from 'react';
import { Component } from 'react';
import * as dayjs from 'dayjs';
import { UserLink } from './../UserLink';

import { 
	Button,
	Card,
	CardHeader,
	CardBody,
	Flex,
	CardFooter
} from '@wordpress/components';

interface TransactionCardProps {
	transaction: any;
}

interface TransactionCardState {
	//
}

export class TransactionCard extends Component<TransactionCardProps, TransactionCardState> {

	constructor( props: TransactionCardProps ) {
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
					<div>№ <strong>{ this.props.transaction.tx_uuid }</strong></div>
				</CardHeader>
				<CardBody style={ { width: '100%' } }>
					<Flex style={ { width: '100%', alignItems: 'center' } }>
						<div style={ { flex: 1 } }>
							<Flex justify="flex-start">
								<span>User: </span>
								<UserLink
									id={ this.props.transaction?.user?.id }
									name={ this.props.transaction?.user?.name ? this.props.transaction?.user?.name : this.props.transaction?.account }
									alt={ this.props.transaction.account }
								/>
							</Flex>
							<div>
								<span>Amount: </span>
								<strong>{ this.props.transaction.amount }</strong>
							</div>
							<div>
								<span>Created at: </span>
								<strong>{ this.dateFormatted( this.props.transaction?.created_at ) }</strong>
							</div>
							<div>
								<span>Updated at: </span>
								<strong>{ this.dateFormatted( this.props.transaction?.updated_at ) }</strong>
							</div>
						</div>
					</Flex>
				</CardBody>
			</Card>
		);
	}
}
 

