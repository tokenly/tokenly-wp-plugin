import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../../Page';
import { Component } from 'react';
import Preloader from '../../../Components/Preloader';
import BalanceList from '../../../Components/Token/BalanceList';
import UserRepositoryInterface from '../../../../Interfaces/Repositories/UserRepositoryInterface';
import AddressRepositoryInterface from '../../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import BalanceRepositoryInterface from '../../../../Interfaces/Repositories/Token/BalanceRepositoryInterface';
import { TYPES } from '../../../../Types';

import { 
	Panel,
	PanelBody,
	PanelRow,
	Flex,
	Spinner,
} from '@wordpress/components';

interface TokenBalancePageData {
	//
}

interface TokenBalancePageProps {
	pageData: TokenBalancePageData;
}

interface TokenBalancePageState {
	balance: any;
	loadingBalance: boolean;
	loadingUser: boolean;
	user_id: string;
	user: any;
}

export default class TokenBalancePage extends Component<TokenBalancePageProps, TokenBalancePageState> {
	@resolve( TYPES.Repositories.UserRepositoryInterface )
	userRepository: UserRepositoryInterface;

	state: TokenBalancePageState = {
		balance: null,
		loadingBalance: false,
		loadingUser: false,
		user_id: null,
		user: null,
	}
	constructor( props: TokenBalancePageProps ) {
		super( props );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.user_id = urlParams.get( 'user' );
	}

	componentWillMount() {
		this.setState( { loadingBalance: true } );
		this.userRepository.show( this.state.user ).then( ( user: any ) => {
			this.setState( {
				loadingUser: false,
				user: user,
			} );
		} );
	}
	
	render() {
		return (
			<Page title={'Token user balance listing'}>
			{ this.state.user &&
				<Panel header="User info">
					<PanelBody>
						<Preloader loading={ this.state.loadingUser } label="user" />
					{ !this.state.loadingUser &&
						<Flex></Flex>
					}
					</PanelBody>
				</Panel>
			}
				<Panel header="Token listing">
					<PanelBody>
						<PanelRow>
							<Flex>
								<Preloader loading={ this.state.loadingBalance } label="balance" />
							{ !this.state.loadingBalance &&
								<Flex style={ { width: '100%' } } >
									<div style={ { marginBottom: '12px' } }>
										{/* Owner ({ this.props.pageData.entity.type }): <strong>{ this.props.pageData.entity.name }</strong> */}
									</div>
									<BalanceList balance={ this.state?.balance ?? [] } />
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
