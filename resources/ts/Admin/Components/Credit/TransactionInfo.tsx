import * as React from 'react';
import { Component } from 'react';
import * as dayjs from 'dayjs'
import UserLink from './../UserLink';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';

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
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	constructor( props: TransactionInfoProps ) {
		super( props );
		this.getUserLink = this.getUserLink.bind( this );
	}

	dateFormatted( date: Date ) {
		if ( date ) {
			return dayjs( date ).format( 'MMMM D, YYYY h:mm A' )
		}
		return;
	}

	getUserLink() {
		if ( this.props.transaction?.user.id ) {
			return `${this.adminPageUrl}${this.namespace}-user-credit-balance-index&id=${this.props.transaction?.user.id}`;
		} else {
			return null
		}		
	}

	render() {
		return (
			<Flex style={ { width: '100%', alignItems: 'center' } }>
				<div style={ { flex: 1 } }>
					<Flex justify="flex-start">
						<span>User: </span>
						<UserLink
							url={ this.getUserLink() }
							name={ this.props.transaction?.user?.name ? this.props.transaction?.user?.name : this.props.transaction?.account }
							alt={ this.props.transaction.account }
						/>
					</Flex>
					<div>
						<span>Amount: </span>
						<b>{ this.props.transaction.amount }</b>
					</div>
					<div>
						<span>Created At: </span>
						<b>{ this.dateFormatted( this.props.transaction?.created_at ) }</b>
					</div>
					<div>
						<span>Updated At: </span>
						<b>{ this.dateFormatted( this.props.transaction?.updated_at ) }</b>
					</div>
				</div>
			</Flex>
		);
	}
}
