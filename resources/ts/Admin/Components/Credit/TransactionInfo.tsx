import * as React from 'react';
import { Component } from 'react';
import * as dayjs from 'dayjs'
import UserLink from './../UserLink';

import { 
	Flex,
} from '@wordpress/components';

interface TransactionInfoProps {
	transaction: any;
	verbose?: boolean;
}

interface TransactionInfoState {
	//
}

export default class TransactionInfo extends Component<TransactionInfoProps, TransactionInfoState> {
	constructor( props: TransactionInfoProps ) {
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
			<Flex style={ { width: '100%', alignItems: 'center' } }>
				<div style={ { flex: 1 } }>
					<Flex justify="flex-start">
						<span>User: </span>
						<UserLink
							url={ `` }
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
		);
	}
}
