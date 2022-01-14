import * as React from 'react';
import TransactionCard from './TransactionCard';
import ResourceList from '../../Components/ResourceList';

interface TransactionList {
	transactions: Array<any>;
}

export default function PromiseList( props: TransactionList ) {
	return (
		<ResourceList
			items={ props.transactions }
			component={ TransactionCard }
			itemProp="transaction"
			notFoundLabel="transactions"
		/>
	);
}
