import * as React from 'react';
import { Component } from 'react';
import TransactionCard from './TransactionCard';

import { 
	Flex,
} from '@wordpress/components';

interface TransactionListProps {
	transactions: Array<any>;
	loadingTransactions: boolean;
}

interface TransactionListState {
	//
}

export default class TransactionList extends Component<TransactionListProps, TransactionListState> {
	constructor( props: TransactionListProps ) {
		super( props );
	}

	render() {
		let listItems = null;
		if ( this.props.transactions && Array.isArray( this.props.transactions ) ) {
			listItems = Object.keys( this.props.transactions ).map( ( key: any ) => this.props.transactions[ key ] ) as any;
			listItems = listItems.map( ( transaction: any, i: number ) => {
				return (
					<div style={ { width: '100%' } }>
						<TransactionCard transaction={ transaction } />
					</div>
				);
			} );
		}
		return (
			<div style={ { width: '100%' } }>
				{ ( listItems && Array.isArray( listItems ) && listItems.length > 0 )
					//@ts-ignore
					? <Flex direction="column" style={ { width: '100%' } }>{ listItems }</Flex>
					: <div style={ { opacity: 0.5 } }>There are no registered transactions</div>
				}
			</div>
		);
	}
}
