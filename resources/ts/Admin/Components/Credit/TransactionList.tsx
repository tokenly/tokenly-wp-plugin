import * as React from 'react';
import { Component } from 'react';
import { TransactionCard } from './TransactionCard';

import { 
	Flex,
} from '@wordpress/components';

interface TransactionListProps {
	transactions: Array<any>;
}

interface TransactionListState {
	//
}

export class TransactionList extends Component<TransactionListProps, TransactionListState> {
	constructor( props: TransactionListProps ) {
		super( props );
	}

	render() {
		let listItems = Object.keys( this.props.transactions ).map( ( key: any ) => this.props.transactions[ key ] ) as any;
		listItems = listItems.map( ( transaction: any, i: number ) => {
			return (
				<div style={ { width: '100%' } }>
					<TransactionCard transaction={ transaction } />
				</div>
			);
		} );
		return (
			<div style={ { width: '100%' } }>
				{ listItems.length > 0
					//@ts-ignore
					? <Flex direction="column" style={ { width: '100%' } }>{ listItems }</Flex>
					: <div style={ { opacity: 0.5 } }>There are no registered transactions</div>
				}
			</div>
		);
	}
}
