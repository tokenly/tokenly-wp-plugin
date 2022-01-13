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
	loading: boolean;
	id: string;
	user: any;
	balance: any;
	groups: any;
}

export default class BalanceIndexPage extends Component<BalanceIndexPageProps, BalanceIndexPageState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;
	@resolve( TYPES.Repositories.UserRepositoryInterface )
	userRepository: UserRepositoryInterface;
	@resolve( TYPES.Repositories.Credit.GroupRepositoryInterface )
	groupRepository: GroupRepositoryInterface;

	state: BalanceIndexPageState = {
		loading: false,
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
			loading: true,
		} );
		this.userRepository.creditBalanceIndex( this.state.id ).then( ( balances: any ) => {
			this.setState( {
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
				this.setState( {
					balance: balances,
				} );
			} );
		} )
		.then( () => {
			this.userRepository.show( this.state.id, {
				with: [ 'oauth_user' ],
			} ).then( ( user: any ) => {
				this.setState( {
					loading: false,
					user: user,
				} );
			} );
		} );
	}

	render() {
		return (
			<Page title="User Credit Balance Listing">
				<Panel>
					<PanelHeader>
						<Preloader loading={ this.state.loading }>Balance Listing</Preloader>
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
					{ ( this.state.loading === false || this.state.balance ) &&
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
