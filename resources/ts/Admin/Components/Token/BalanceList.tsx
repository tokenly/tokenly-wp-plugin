import * as React from 'react';
import BalanceCard from './BalanceCard';
import ResourceList from '../../Components/ResourceList';

interface BalanceListProps {
	balance: Array<any>;
}

export default function BalanceList( props: BalanceListProps ) {
	return (
		<ResourceList
			items={ props.balance }
			component={ BalanceCard }
			itemProp="balance"
			notFoundLabel="balances"
		/>
	);
}
