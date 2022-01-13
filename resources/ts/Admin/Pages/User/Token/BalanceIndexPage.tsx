import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../../Page';
import { Component } from 'react';
import Preloader from '../../../Components/Preloader';
import BalanceList from '../../../Components/Token/BalanceList';
import UserInfo from '../../../Components/UserInfo';
import UserRepositoryInterface from '../../../../Interfaces/Repositories/UserRepositoryInterface';
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
	loadingUser: boolean;
	loadingBalance: boolean;
	id: string;
	user: any;
	balance: any;
}

export default class BalanceIndexPage extends Component<BalanceIndexPageProps, BalanceIndexPageState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;
	@resolve( TYPES.Repositories.UserRepositoryInterface )
	userRepository: UserRepositoryInterface;

	state: BalanceIndexPageState = {
		loadingUser: false,
		loadingBalance: false,
		balance: null,
		id: null,
		user: null,
	}
	constructor( props: BalanceIndexPageProps ) {
		super( props );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.id = urlParams.get( 'id' );
	}

	componentWillMount() {
		this.setState( {
			loadingBalance: true,
			loadingUser: true,
		} );
		this.userRepository.tokenBalanceIndex( this.state.id, {
			with: [ 'meta' ],
		} )
		.then( ( balance: any ) => {
			this.setState( {
				balance: balance,
			} );
			return balance;
		} )
		.then( ( balance: any ) => {
			this.userRepository.show( this.state.id, {
				with: [ 'oauth_user' ],
			} ).then( ( user: any ) => {
				this.setState( {
					loadingBalance: false,
					loadingUser: false,
					user: user,
				} );
			} );
		} );
	}
	
	render() {
		return (
			<Page title="User Token Balance Listing">
				<Panel>
					<PanelHeader>
						<Preloader loading={ this.state.loadingBalance }>Balance Listing</Preloader>
					</PanelHeader>
					<PanelBody>
						<PanelRow>
							<b>
								<span>User: </span>
								<a href={ `/${this.namespace}/user/${this.state.id}` }>
									{ this.state?.user?.name ?? this.state.id }
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
