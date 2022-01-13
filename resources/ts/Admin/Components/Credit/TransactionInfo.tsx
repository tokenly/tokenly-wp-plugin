import * as React from 'react';
import { Component } from 'react';
import * as dayjs from 'dayjs'
import UserLink from './../UserLink';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';

import { 
	Flex,
} from '@wordpress/components';

interface TransactionInfoProps {
	transaction: any;
	verbose?: boolean;
}

export default function TransactionInfo( props: TransactionInfoProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	function dateFormatted( date: Date ) {
		if ( date ) {
			return dayjs( date ).format( 'MMMM D, YYYY h:mm A' )
		}
		return;
	}

	function getUserLink() {
		if ( props.transaction?.user.id ) {
			return `${adminPageUrl}${namespace}-user-credit-balance-index&id=${props.transaction?.user.id}`;
		} else {
			return null
		}		
	}

	return (
		<Flex style={ { width: '100%', alignItems: 'center' } }>
			<div style={ { flex: 1 } }>
				<Flex justify="flex-start">
					<span>User: </span>
					<UserLink
						url={ getUserLink() }
						name={ props.transaction?.user?.name ? props.transaction?.user?.name : props.transaction?.account }
						alt={ props.transaction.account }
					/>
				</Flex>
				<div>
					<span>Amount: </span>
					<b>{ props.transaction.amount }</b>
				</div>
				<div>
					<span>Created At: </span>
					<b>{ dateFormatted( props.transaction?.created_at ) }</b>
				</div>
				<div>
					<span>Updated At: </span>
					<b>{ dateFormatted( props.transaction?.updated_at ) }</b>
				</div>
			</div>
		</Flex>
	);
}
