import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../../Page';
import { Component } from 'react';
import Preloader from '../../../Components/Preloader';
import BalanceList from '../../../Components/Token/BalanceList';
import AddressRepositoryInterface from '../../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import { TYPES } from '../../../../Types';

import { 
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
} from '@wordpress/components';

interface BalanceIndexPageData {
	//
}

interface BalanceIndexPageProps {
	pageData: BalanceIndexPageData;
}

interface BalanceIndexPageState {
	loadingAddress: boolean;
	loadingBalance: boolean;
	id: string;
	address: any;
	balance: any;
}

export default class BalanceIndexPage extends Component<BalanceIndexPageProps, BalanceIndexPageState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;
	@resolve( TYPES.Repositories.Token.AddressRepositoryInterface )
	addressRepository: AddressRepositoryInterface;

	state: BalanceIndexPageState = {
		loadingAddress: false,
		loadingBalance: false,
		balance: null,
		id: null,
		address: null,
	}
	constructor( props: BalanceIndexPageProps ) {
		super( props );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.id = urlParams.get( 'id' );
	}

	componentWillMount() {
		this.setState( {
			loadingBalance: true,
			loadingAddress: true,
		} );
		this.addressRepository.balanceIndex( this.state.id, {
			with: [ 'meta' ],
		} )
		.then( ( balance: any ) => {
			console.log(balance);
			this.setState( {
				balance: balance,
			} );
			return balance;
		} )
		.then( ( balance: any ) => {
			this.addressRepository.show( this.state.id ).then( ( address: any ) => {
				this.setState( {
					loadingAddress: false,
					loadingBalance: false,
					address: address,
				} );
			} );
		} )
	}
	
	render() {
		return (
			<Page title="Token Address Balance Listing">
				<Panel>
					<PanelHeader>
						<Preloader loading={ this.state.loadingBalance }>Balance Listing</Preloader>
					</PanelHeader>
					<PanelBody>
						<PanelRow>
							<b>
								<span>Address: </span>
								<a href={ `${this.adminPageUrl}${this.namespace}-token-address-show&id=${this.state.id}` }>
									{ this.state?.address?.label ?? this.state.id }
								</a>
							</b>
						</PanelRow>
					{ ( this.state.loadingBalance === false || this.state.balance ) &&
						<PanelRow>
							<BalanceList balance={ this.state.balance } />
						</PanelRow>
					}
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
