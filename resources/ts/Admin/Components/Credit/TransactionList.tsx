import * as React from 'react'
import TransactionCard from './TransactionCard'
import ResourceList from '../../Components/ResourceList'
import TransactionCollectionInterface from '../../../Interfaces/Collections/Credit/TransactionCollectionInterface'

interface TransactionList {
	transactions: TransactionCollectionInterface
}

export default function PromiseList( props: TransactionList ) {
	return (
		<ResourceList
			items={ props.transactions }
			component={ TransactionCard }
			itemProp="transaction"
			notFoundLabel="transactions"
		/>
	)
}
