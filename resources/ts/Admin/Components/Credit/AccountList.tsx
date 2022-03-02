import * as React from 'react';
import TransactionCard from './TransactionCard';
import ResourceList from '../../Components/ResourceList';

interface AccountList {
	accounts: Array<any>;
}

export default function AccountList( props: AccountList ) {
	return (
		<ResourceList
			items={ props.accounts }
			component={ TransactionCard }
			itemProp="account"
			notFoundLabel="accounts"
		/>
	);
}
