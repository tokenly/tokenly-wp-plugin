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
	Flex,
	Spinner,
} from '@wordpress/components';

interface TokenBalanceIndexPageData {
	//
}

interface TokenBalanceIndexPageProps {
	pageData: TokenBalanceIndexPageData;
}

interface TokenBalanceIndexPageState {
	loadingUser: boolean;
	loadingBalance: boolean;
	id: string;
	user: any;
	balance: any;
}

export default class TokenBalanceIndexPage extends Component<TokenBalanceIndexPageProps, TokenBalanceIndexPageState> {
	@resolve( TYPES.Repositories.UserRepositoryInterface )
	userRepository: UserRepositoryInterface;

	state: TokenBalanceIndexPageState = {
		loadingUser: false,
		loadingBalance: false,
		balance: null,
		id: null,
		user: null,
	}
	constructor( props: TokenBalanceIndexPageProps ) {
		super( props );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.id = urlParams.get( 'id' );
	}

	componentWillMount() {
		this.setState( {
			loadingBalance: true,
			loadingUser: true,
		} );
		this.userRepository.indexTokenBalance( this.state.id, {
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
			this.userRepository.show( this.state.id, {
				with: [ 'oauth_user' ],
			} ).then( ( user: any ) => {
				this.setState( {
					loadingUser: false,
					user: user,
				} );
			} );
		} );
	}
	
	render() {
		return (
			<Page title={'Token user balance listing'}>
				 <Panel>
					<PanelHeader>
					{ this.state.loadingUser
						?	<Preloader loading={ this.state.loadingUser } label="user" />
						:	<span>User info</span>
					}
					</PanelHeader>
				{ ( this.state.loadingUser === false || this.state.user ) &&
					<PanelBody>
						<PanelRow>
							<UserInfo user={ this.state.user } />
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelHeader>
					{ this.state.loadingBalance
						?	<Preloader loading={ this.state.loadingBalance } label="balance" />
						:	<span>Balance listing</span>
					}
					</PanelHeader>
				{ ( this.state.loadingBalance === false || this.state.balance ) &&
					<PanelBody>
						<BalanceList balance={ this.state.balance } />
					</PanelBody>
				}
				</Panel>
			</Page>
		);
	}
}
