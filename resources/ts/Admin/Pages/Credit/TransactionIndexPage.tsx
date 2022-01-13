import { resolve } from 'inversify-react';
import * as React from 'react';
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

interface TransactionIndexPageState {
	transactions: any;
	loadingTransactions: any;
}

export default class TransactionIndexPage extends Component<TransactionIndexPageProps, TransactionIndexPageState> {
	@resolve( TYPES.Repositories.Credit.TransactionRepositoryInterface )
	transactionRepository: TransactionRepositoryInterface;

	state: TransactionIndexPageState = {
		transactions: null,
		loadingTransactions: null,
	}
	constructor( props: TransactionIndexPageProps ) {
		super( props );
	}

	componentWillMount() {
		this.setState( { loadingTransactions: true } );
		const urlParams = new URLSearchParams( window.location.search );
		const group = urlParams.get( 'group' );
		const params = {
			group: group,
			with: [ 'user' ],
		}
		this.transactionRepository.index( params ).then( ( transactions ) => {
			this.setState( {
				loadingTransactions: false,
				transactions: transactions,
			} );
		} );
	}
	
	render() {
		return (
			<Page title="Transaction Listing">
				<Panel>
					<PanelHeader>
						<Preloader loading={ this.state.loadingTransactions }>Registered Transactions</Preloader>
					</PanelHeader>
				{
					(
						!this.state.loadingTransactions &&
						this.state.transactions &&
						Array.isArray( this.state.transactions )
					) &&
					<PanelBody>
						<PanelRow>
							<TransactionList transactions={ this.state.transactions } />
						</PanelRow>
					</PanelBody>
				}
				</Panel>
			</Page>
		);
	}
}
