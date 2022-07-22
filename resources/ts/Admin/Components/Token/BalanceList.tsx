import * as React from 'react'
import BalanceCard from './BalanceCard'
import ResourceList from '../../Components/ResourceList'
import BalanceCollectionInterface from '../../../Interfaces/Collections/Token/BalanceCollectionInterface'

interface BalanceListProps {
	balance: BalanceCollectionInterface
	username?: string
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
	)
}
