import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../../Page';
import { Component } from 'react';
import Preloader from '../../../Components/Preloader';
import AccountList from '../../../Components/Credit/AccountList';
import UserRepositoryInterface from '../../../../Interfaces/Repositories/UserRepositoryInterface';
import GroupRepositoryInterface from '../../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import { TYPES } from '../../../../Types';

import { 
	Panel,
	PanelBody,
	PanelRow,
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
	loadingUser: boolean;
	id: string;
	user: any;
	groups: any;
}

export default class TokenBalanceIndexPage extends Component<TokenBalanceIndexPageProps, TokenBalanceIndexPageState> {
	@resolve( TYPES.Repositories.UserRepositoryInterface )
	userRepository: UserRepositoryInterface;
	@resolve( TYPES.Repositories.Credit.GroupRepositoryInterface )
	groupRepository: GroupRepositoryInterface;

	state: TokenBalanceIndexPageState = {
		loadingUser: false,
		loadingGroups: false,
		id: null,
		user: null,
		groups: null,
	}
	constructor( props: TokenBalanceIndexPageProps ) {
		super( props );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.id = urlParams.get( 'id' );
	}

	componentWillMount() {
		this.setState( { loadingGroups: true } );
		this.groupRepository.index().then( ( groups: any ) => {
			console.log(groups);
			this.setState( {
				loadingGroups: false,
			} );
			const params = {
				with: [ 'oauth_user.credit_account' ],
			}
			this.userRepository.show( this.state.id, params ).then( ( user: any ) => {
				console.log(user);
				let accounts = user.oauth_user.credit_account;
				// if ( accounts ) {
				// 	accounts = accounts.map( ( account: any ) => {
				// 		groups.forEach( (group: any) => {
				// 			if ( group.uuid ==  ) {
								
				// 			}
				// 		} );
				// 	} )
				// } else {
				// 	accounts = [];
				// }
				console.log(accounts);
				// this.setState( {
				// 	loadingUser: false,
				// 	user: user,
				// } );
			} );
		} );


	}

	getLoadingLabel() {
		if ( this.state.loadingGroups ) {
			return 'groups';
		} else if ( this.state.loadingUser ) {
			return 'user';
		}
	}

	getLoadingState() {
		return ( 
			this.state.loadingUser ||
			this.state.loadingGroups
		);
	}

	render() {
		const loading = this.getLoadingState();
		return (
			<Page title={'Credit user balance listing'}>
				<Panel header="Credit listing">
					<PanelBody>
						<PanelRow>
							<Flex>
								<Preloader loading={ loading } label={ this.getLoadingLabel() } />
							{ !loading &&
								<Flex>
									{ this.state.user?.oauth_user?.credit_account?.length > 0
										? <AccountList
											accounts={ this.state.user?.oauth_user.credit_account }
										/>
										: <div style={ { opacity: 0.5 } }>There are no registered accounts</div>
									}
								</Flex>
							}
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
