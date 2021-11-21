import * as React from 'react';
import { Component } from 'react';
import { BalanceCard } from './BalanceCard';

import { 
	Button,
	Flex,
} from '@wordpress/components';

interface BalanceListProps {
	balances: any;
}

interface BalanceListState {
	//
}

export class BalanceList extends Component<BalanceListProps, BalanceListState> {

	constructor( props: BalanceListProps ) {
		super( props );
	}

	render() {
		let listItems = Object.keys( this.props.balances ).map( ( key: any ) => this.props.balances[ key ] ) as any;
		listItems = listItems.map( ( balanceItem: any, i: number ) => {
			return (
				<div style={ { width: '100%' } }>
					<BalanceCard balance={ balanceItem } />
				</div>
			);
		} );
		return (
			<div style={ { width: '100%' } }>
				{ listItems.length > 0
					//@ts-ignore
					? <Flex direction="column" style={ { width: '100%' } }>{ listItems }</Flex>
					: <div style={ { opacity: 0.5 } }>There are no assets</div>
				}
			</div>
		);
	}
}
