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
} from '@wordpress/components';

interface BalanceIndexPageData {
	//
}

interface BalanceIndexPageProps {
	pageData: BalanceIndexPageData;
}

interface BalanceIndexPageState {
	loadingGroups: boolean;
	loadingBalance: boolean;
	loadingUser: boolean;
	id: string;
	user: any;
	balance: any;
	groups: any;
}

export default class BalanceIndexPage extends Component<BalanceIndexPageProps, BalanceIndexPageState> {
	@resolve( TYPES.Repositories.UserRepositoryInterface )
	userRepository: UserRepositoryInterface;
	@resolve( TYPES.Repositories.Credit.GroupRepositoryInterface )
	groupRepository: GroupRepositoryInterface;

	state: BalanceIndexPageState = {
		loadingUser: false,
		loadingBalance: false,
		loadingGroups: false,
		id: null,
		user: null,
		balance: null,
		groups: null,
	}
	constructor( props: BalanceIndexPageProps ) {
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
		this.userRepository.indexCreditBalance( this.state.id ).then( ( balances: any ) => {
			this.setState( {
				loadingBalance: false,
				balance: balances,
			} );
			return balances;
		} )
		.then( ( balances: any ) => {
			this.groupRepository.index( this.state.id ).then( ( groups: any ) => {
				balances = balances.map( ( balance: any ) => {
					for ( let i = 0; i < groups.length; ++i ) {
						const group = groups[ i ];
						if ( balance.group_id === group.uuid ) {
							balance.group = group;
							break;
						}
					}
					return balance;
				} );
				console.log(balances);
				this.setState( {
					loadingGroups: false,
					balance: balances,
				} );
			} );
		} )
		.then( () => {
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
			<Page title="Token Balance Listing">
				<Panel>
					<PanelHeader>
						<Preloader loading={ ( this.state.loadingBalance || this.state.loadingGroups ) }>Balance Listing</Preloader>
					</PanelHeader>
				{ ( this.state.loadingBalance === false || this.state.balance ) &&
					<PanelBody>
						<BalanceList balances={ this.state.balance } />
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelHeader>
						<Preloader loading={ this.state.loadingUser } >User Profile</Preloader>
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
