import * as React from 'react';
import { Component } from 'react';
import BalanceCard from './BalanceCard';

import { 
	Flex,
} from '@wordpress/components';

interface BalanceListProps {
	balances: any;
}

interface BalanceListState {
	//
}

export default class BalanceList extends Component<BalanceListProps, BalanceListState> {
	constructor( props: BalanceListProps ) {
		super( props );
	}

	render() {
		const listItems = this.props.balances.map( ( balance: any, i: number ) => {
			return (
				<Flex>
					<BalanceCard balance={ balance } />
				</Flex>
			);
		} );
		return (
			<div style={ { width: '100%' } }>
				{ listItems.length > 0
					//@ts-ignore
					? <Flex direction="column" style={ { width: '100%' } }>{ listItems }</Flex>
					: <div style={ { opacity: 0.5 } }>There are no balances</div>
				}
			</div>
		);
	}
}
