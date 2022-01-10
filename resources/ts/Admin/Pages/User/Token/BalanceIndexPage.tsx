import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../../Page';
import { Component } from 'react';
import Preloader from '../../../Components/Preloader';
import BalanceList from '../../../Components/Token/BalanceList';
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
	id: string;
	user: any;
}

export default class TokenBalanceIndexPage extends Component<TokenBalanceIndexPageProps, TokenBalanceIndexPageState> {
	@resolve( TYPES.Repositories.UserRepositoryInterface )
	userRepository: UserRepositoryInterface;

	state: TokenBalanceIndexPageState = {
		loadingUser: false,
		id: null,
		user: null,
	}
	constructor( props: TokenBalanceIndexPageProps ) {
		super( props );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.id = urlParams.get( 'id' );
	}

	componentWillMount() {
		const params = {
			with: [ 'oauth_user.balance' ]
		}
		this.setState( { loadingUser: true } );
		this.userRepository.show( this.state.id, params ).then( ( user: any ) => {
			this.setState( {
				loadingUser: false,
				user: user,
			} );
		} );
	}
	
	render() {
		return (
			<Page title={'Token user balance listing'}>
				 <Panel>
				 	{ this.state.loadingUser 
				? 	<PanelHeader>
						<Preloader loading={ this.state.loadingUser } label="user" />
					</PanelHeader>
				:	<PanelBody>
						<PanelRow>
							User info
						</PanelRow>
						<PanelRow>
							<BalanceList balance={ this.state?.user?.oauth_user?.balance ?? [] } />
						</PanelRow>
					</PanelBody>
				}
				</Panel>
			</Page>
		);
	}
}
