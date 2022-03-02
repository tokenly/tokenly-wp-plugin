import * as React from 'react';
import BalanceCard from './BalanceCard';
import ResourceList from '../../Components/ResourceList';

interface BalanceListProps {
	balance: Array<any>;
	username?: string;
}

export default function BalanceList( props: BalanceListProps ) {
	return (
		<ResourceList
			items={ props.balance }
			component={ BalanceCard }
			itemProp="balance"
			props={ {
				username: props.username,
			} }
			notFoundLabel="balances"
		/>
	);
}
