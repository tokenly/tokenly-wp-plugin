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
