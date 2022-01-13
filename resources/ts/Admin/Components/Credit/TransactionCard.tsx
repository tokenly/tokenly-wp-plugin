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

export default function TransactionCard( props: TransactionCardProps ) {
	function dateFormatted( date: Date ) {
		if ( date ) {
			return dayjs( date ).format( 'MMMM D, YYYY h:mm A' )
		}
		return;
	}

	return (
		<Card size="extraSmall" style={ { width: '100%' } }>
			<CardHeader>
				<TransactionLink uuid={ props.transaction?.tx_uuid } />
			</CardHeader>
			<CardBody style={ { width: '100%' } }>
				<TransactionInfo transaction={ props.transaction } />
			</CardBody>
		</Card>
	);
}
 

