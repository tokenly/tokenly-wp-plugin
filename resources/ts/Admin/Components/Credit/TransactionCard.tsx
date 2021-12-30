import * as React from 'react';
import { Component } from 'react';
import * as dayjs from 'dayjs';
import TransactionInfo from './TransactionInfo';
import TransactionLink from './TransactionLink';

import { 
	Card,
	CardHeader,
	CardBody,
} from '@wordpress/components';

interface TransactionCardProps {
	transaction: any;
}

interface TransactionCardState {
	//
}

export default class TransactionCard extends Component<TransactionCardProps, TransactionCardState> {
	constructor( props: TransactionCardProps ) {
		super( props );
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
					<TransactionLink uuid={ this.props.transaction?.tx_uuid } />
				</CardHeader>
				<CardBody style={ { width: '100%' } }>
					<TransactionInfo transaction={ this.props.transaction } />
				</CardBody>
			</Card>
		);
	}
}
 

