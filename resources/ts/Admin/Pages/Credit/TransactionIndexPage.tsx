import * as React from 'react';
import { useInjection } from 'inversify-react';
import { useState, useEffect } from 'react';
import Page from './../Page';
import { Component } from 'react';
import TransactionList from '../../Components/Credit/TransactionList';
import Preloader from '../../Components/Preloader';
import TransactionRepositoryInterface from '../../../Interfaces/Repositories/Credit/TransactionRepositoryInterface';
import { TYPES } from '../../../Types';

import {
	Panel,
	PanelBody,
	PanelRow,
	Flex,
	PanelHeader,
} from '@wordpress/components';

interface TransactionIndexPageData {
	//
}

interface TransactionIndexPageProps {
	pageData: TransactionIndexPageData;
}

export default function TransactionIndexPage( props: TransactionIndexPageProps ) {
	const transactionRepository: TransactionRepositoryInterface = useInjection( TYPES.Repositories.Credit.TransactionRepositoryInterface );

	const [ transactions, setTransactions ] = useState<any>( null );
	const [ loadingTransactions, setLoadingTransactions ] = useState<any>( false );

	useEffect( () => {
		const urlParams = new URLSearchParams( window.location.search );
		const group = urlParams.get( 'group' );
		const params = {
			group: group,
			with: [ 'user' ],
		}
		setLoadingTransactions( true );
		transactionRepository.index( params ).then( ( transactionsFound: any ) => {
			setLoadingTransactions( false );
			setTransactions( transactionsFound );
		} );
	 }, [] );
	
	return (
		<Page title="Transaction Listing">
			<Panel>
				<PanelHeader>
					<Preloader loading={ loadingTransactions }>Registered Transactions</Preloader>
				</PanelHeader>
			{
				(
					!loadingTransactions &&
					transactions &&
					Array.isArray( transactions )
				) &&
				<PanelBody>
					<PanelRow>
						<TransactionList transactions={ transactions } />
					</PanelRow>
				</PanelBody>
			}
			</Panel>
		</Page>
	);
}
