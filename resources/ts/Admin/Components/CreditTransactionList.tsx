import * as React from 'react';
import { Component } from 'react';
import { SourceItem } from '../../Interfaces';
import { CreditTransactionCard } from './CreditTransactionCard';

import { 
	Button,
	Flex,
	Dashicon,
	Card,
	CardBody,
	CardHeader,
	CardFooter,
} from '@wordpress/components';

interface CreditTransactionListProps {
	creditTransactions: Array<any>;
}

interface CreditTransactionListState {
	//
}

export class CreditTransactionList extends Component<CreditTransactionListProps, CreditTransactionListState> {

	constructor( props: CreditTransactionListProps ) {
		super( props );
	}

	render() {
		let listItems = Object.keys( this.props.creditTransactions ).map( ( key: any ) => this.props.creditTransactions[ key ] ) as any;
		listItems = listItems.map( ( creditTransaction: any, i: number ) => {
			return (
				<div style={ { width: '100%' } }>
					<CreditTransactionCard creditTransaction={ creditTransaction } />
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
