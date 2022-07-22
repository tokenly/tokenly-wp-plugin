import * as React from 'react'
import { useInjection } from 'inversify-react'
import { useState, useEffect } from 'react'
import Page from '../Page'
import TransactionList from '../../Components/Credit/TransactionList'
import Preloader from '../../Components/Preloader'
import TransactionRepositoryInterface
	from '../../../Interfaces/Repositories/Credit/TransactionRepositoryInterface'
import { TYPES } from '../../Types'

import {
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
} from '@wordpress/components'
import TransactionCollectionInterface
	from '../../../Interfaces/Collections/Credit/TransactionCollectionInterface'

interface TransactionIndexPageProps {
	//
}

export default function TransactionIndexPage(
	props: TransactionIndexPageProps
) {
	const transactionRepository: TransactionRepositoryInterface = useInjection(
		TYPES.Repositories.Credit.TransactionRepositoryInterface
	)

	const [ transactions, setTransactions ] =
		useState<TransactionCollectionInterface>( null )
	const [ loadingTransactions, setLoadingTransactions ] =
		useState<any>( false )

	useEffect( () => {
		const urlParams = new URLSearchParams( window.location.search )
		const group = urlParams.get( 'group' )
		const params = {
			group: group,
		}
		setLoadingTransactions( true )
		transactionRepository.index( params ).then( (
			transactionsFound: TransactionCollectionInterface
		) => {
			setLoadingTransactions( false )
			setTransactions( transactionsFound )
		} )
	 }, [] )
	
	return (
		<Page title="Transaction Listing">
			<Panel>
				<PanelHeader>
					<Preloader loading={ loadingTransactions }>Registered Transactions</Preloader>
				</PanelHeader>
			{
				(
					!loadingTransactions &&
					transactions
				) &&
				<PanelBody>
					<PanelRow>
						<TransactionList transactions={ transactions } />
					</PanelRow>
				</PanelBody>
			}
			</Panel>
		</Page>
	)
}
