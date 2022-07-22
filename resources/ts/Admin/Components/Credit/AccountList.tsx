import * as React from 'react'
import TransactionCard from './TransactionCard'
import ResourceList from '../../Components/ResourceList'
import AccountCollectionInterface from '../../../Interfaces/Collections/Credit/AccountCollectionInterface'

interface AccountList {
	accounts: AccountCollectionInterface
}

export default function AccountList( props: AccountList ) {
	return (
		<ResourceList
			items={ props.accounts }
			component={ TransactionCard }
			itemProp="account"
			notFoundLabel="accounts"
		/>
	)
}
