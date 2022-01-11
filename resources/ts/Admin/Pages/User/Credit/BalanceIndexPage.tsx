import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../../Page';
import { Component } from 'react';
import Preloader from '../../../Components/Preloader';
import BalanceList from '../../../Components/Credit/BalanceList';
import UserInfo from '../../../Components/UserInfo';
import UserRepositoryInterface from '../../../../Interfaces/Repositories/UserRepositoryInterface';
import GroupRepositoryInterface from '../../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
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
	loadingGroups: boolean;
	loadingBalance: boolean;
	loadingUser: boolean;
	id: string;
	user: any;
	balance: any;
	groups: any;
}

export default class TokenBalanceIndexPage extends Component<TokenBalanceIndexPageProps, TokenBalanceIndexPageState> {
	@resolve( TYPES.Repositories.UserRepositoryInterface )
	userRepository: UserRepositoryInterface;
	@resolve( TYPES.Repositories.Credit.GroupRepositoryInterface )
	groupRepository: GroupRepositoryInterface;

	state: TokenBalanceIndexPageState = {
		loadingUser: false,
		loadingBalance: false,
		loadingGroups: false,
		id: null,
		user: null,
		balance: null,
		groups: null,
	}
	constructor( props: TokenBalanceIndexPageProps ) {
		super( props );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.id = urlParams.get( 'id' );
	}

	componentWillMount() {
		this.setState( {
			loadingGroups: true,
			loadingBalance: true,
			loadingUser: true,
		} );
		this.userRepository.indexCreditBalance( this.state.id )
			.then( ( balance: any ) => {
				console.log(balance);
				this.setState( {
					loadingBalance: false,
					balance: balance,
				} );
				return balance;
			} )
			.then( ( balances: any ) => {
				this.groupRepository.index( this.state.id ).then( ( groups: any ) => {
					balances.forEach( ( balance: any ) => {
						
					} );
					this.setState( {
						loadingGroups: false,
						groups: groups,
					} );
					return groups;
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
		} );
	}

	render() {
		return (
			<Page title={'Token user balance listing'}>
				<Panel>
					<PanelHeader>
						<Preloader loading={ ( this.state.loadingBalance || this.state.loadingGroups ) } label="Balance listing" />
					</PanelHeader>
				{ ( this.state.loadingBalance === false || this.state.balance ) &&
					<PanelBody>
						<BalanceList balances={ this.state.balance } />
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelHeader>
						<Preloader loading={ this.state.loadingUser } label="User profile" />
					</PanelHeader>
				{ ( this.state.loadingUser === false || this.state.user ) &&
					<PanelBody>
						<PanelRow>
							<UserInfo user={ this.state.user } />
						</PanelRow>
					</PanelBody>
				}
				</Panel>
			</Page>
		);
	}
}
