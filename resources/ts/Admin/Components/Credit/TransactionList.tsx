import * as React from 'react';
import { Component } from 'react';
import TransactionCard from './TransactionCard';
import ResourceList from '../../Components/ResourceList';

import { 
	Flex,
} from '@wordpress/components';

interface TransactionList {
	transactions: Array<any>;
}

interface PromiseListState {
	//
}

export default class PromiseList extends Component<TransactionList, PromiseListState> {
	constructor( props: TransactionList ) {
		super( props );
	}

	render() {
		return (
			<ResourceList
				items={ this.props.transactions }
				component={ TransactionCard }
				itemProp="transaction"
				notFoundLabel="transactions"
			/>
		);
	}
}
