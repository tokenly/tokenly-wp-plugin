import * as React from 'react';
import { Component } from 'react';
import BalanceCard from './BalanceCard';
import ResourceList from '../../Components/ResourceList';

import { 
	Flex,
} from '@wordpress/components';

interface BalanceListProps {
	balance: Array<any>;
}

interface BalanceListState {
	//
}

export default class BalanceList extends Component<BalanceListProps, BalanceListState> {
	constructor( props: BalanceListProps ) {
		super( props );
	}

	render() {
		return (
			<ResourceList
				items={ this.props.balance }
				component={ BalanceCard }
				itemProp="balance"
				notFoundLabel="balances"
			/>
		);
	}
}
