import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../../Page';
import { Component } from 'react';
import Preloader from '../../../Components/Preloader';
import BalanceList from '../../../Components/Token/BalanceList';
import UserInfo from '../../../Components/UserInfo';
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
				loadingBalance: false,
				balance: balance,
			} );
			return balance;
		} )
		.then( ( balance: any ) => {
			this.addressRepository.show( this.state.id, {
				with: [ 'meta' ],
			} )
		} );
		// .then( ( balance: any ) => {
		// 	this.userRepository.show( this.state.id, {
		// 		with: [ 'oauth_user' ],
		// 	} ).then( ( user: any ) => {
		// 		this.setState( {
		// 			loadingUser: false,
		// 			user: user,
		// 		} );
		// 	} );
		// } );
	}
	
	render() {
		return (
			<Page title="Credit Balance Listing">
				<Panel>
					<PanelHeader>
						<Preloader loading={ this.state.loadingBalance }>Balance Listing</Preloader>
					</PanelHeader>
				{ ( this.state.loadingBalance === false || this.state.balance ) &&
					<PanelBody>
						<BalanceList balance={ this.state.balance } />
					</PanelBody>
				}
				</Panel>
				 <Panel>
					<PanelHeader>
						<Preloader loading={ this.state.loadingAddress }>Address Info</Preloader>
					</PanelHeader>
				{ ( this.state.loadingAddress === false || this.state.address ) &&
					<PanelBody>
						<PanelRow>
							//
						</PanelRow>
					</PanelBody>
				}
				</Panel>
			</Page>
		);
	}
}
